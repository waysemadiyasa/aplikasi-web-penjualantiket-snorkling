<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PublicBookingController extends Controller
{
    public function create($scheduleId)
    {
        $schedule = Schedule::with('package')
            ->whereKey($scheduleId)
            ->where('is_active', true)
            ->whereDate('travel_date', '>=', today())
            ->where('available_seats', '>', 0)
            ->whereHas('package', function ($query) {
                $query->where('is_active', true);
            })
            ->firstOrFail();

        return view('public.booking-form', compact('schedule'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'quantity' => 'required|integer|min:1|max:100',
            'payment_method' => 'required|in:Transfer Bank,QRIS,Cash',
            'notes' => 'nullable|string',
        ]);

        $booking = DB::transaction(function () use ($validated) {

            $schedule = Schedule::with('package')
                ->whereKey($validated['schedule_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (
                !$schedule->is_active ||
                !$schedule->package ||
                !$schedule->package->is_active ||
                $schedule->travel_date->lt(today())
            ) {
                throw ValidationException::withMessages([
                    'schedule_id' => 'Jadwal tidak aktif atau sudah lewat.',
                ]);
            }

            if ($schedule->available_seats < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => 'Jumlah tiket melebihi kursi yang tersedia.',
                ]);
            }

            $price = $schedule->package->price;
            $subtotal = $price * $validated['quantity'];

            $bookingCode = 'KAI-' . now()->format('YmdHis')
                . '-' . strtoupper(Str::random(5));

            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'user_id' => null,
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'total_amount' => $subtotal,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            BookingDetail::create([
                'booking_id' => $booking->id,
                'package_id' => $schedule->package_id,
                'schedule_id' => $schedule->id,
                'quantity' => $validated['quantity'],
                'price' => $price,
                'subtotal' => $subtotal,
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'payment_method' => $validated['payment_method'],
                'payment_provider' => 'Manual',
                'transaction_id' => null,
                'amount' => $subtotal,
                'status' => 'pending',
                'paid_at' => null,
            ]);

            $schedule->decrement(
                'available_seats',
                $validated['quantity']
            );

            return $booking;
        });

        return redirect()->route(
            'booking.success',
            ['bookingCode' => $booking->booking_code]
        );
    }

public function track(Request $request)
{
    $validated = $request->validate([
        'booking_code' => 'required|string|max:50',
        'email' => 'required|email|max:255',
    ]);

    $booking = Booking::with([
        'details.package',
        'details.schedule',
        'payments',
    ])
    ->where('booking_code', trim($validated['booking_code']))
    ->where('email', trim($validated['email']))
    ->first();

    if (!$booking) {
        return back()
            ->withInput()
            ->withErrors([
                'lookup' => 'Kode booking atau email tidak sesuai. Silakan periksa kembali.',
            ]);
    }

    return view('public.booking-tracking-result', compact('booking'));
}

    public function success($bookingCode)
    {
        $booking = Booking::with([
            'details.package',
            'details.schedule',
            'payments',
        ])
        ->where('booking_code', $bookingCode)
        ->firstOrFail();

        return view('public.booking-success', compact('booking'));
    }
        public function tracking()
    {
        return view('public.booking-tracking');
    }

    public function checkTracking(Request $request)
    {
        $validated = $request->validate([
            'booking_code' => 'required|string|max:50',
            'email' => 'required|email|max:255',
        ]);

        $booking = Booking::with([
            'details.package',
            'details.schedule',
            'payments',
        ])
        ->where('booking_code', $validated['booking_code'])
        ->where('email', $validated['email'])
        ->first();

        if (!$booking) {
            return back()
                ->withInput()
                ->withErrors([
                    'booking_code' => 'Kode booking atau email tidak sesuai.',
                ]);
        }

        return view('public.booking-tracking-result', compact('booking'));
    }
        public function uploadProof(Request $request, $bookingCode)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'payment_notes' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::with('payments')
            ->where('booking_code', $bookingCode)
            ->where('email', $validated['email'])
            ->firstOrFail();

        $payment = $booking->payments()
            ->where('status', 'pending')
            ->first();

        if (!$payment) {
            return back()->withErrors([
                'proof' => 'Pembayaran tidak ditemukan atau sudah diverifikasi.',
            ]);
        }

        $filePath = $request->file('proof')->store('payment-proofs');

        if (!$filePath) {
            return back()->withErrors([
                'proof' => 'Gagal menyimpan bukti pembayaran. Silakan coba lagi.',
            ]);
        }

        if ($payment->proof_of_payment) {
            Storage::delete($payment->proof_of_payment);
        }

        $payment->update([
            'proof_of_payment' => $filePath,
            'payment_notes' => $validated['payment_notes'] ?? null,
        ]);

        return redirect()
            ->route('booking.success', $booking->booking_code)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi admin.');
    }
}
