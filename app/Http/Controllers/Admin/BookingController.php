<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\Payment;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('details.package', 'details.schedule')
            ->latest()
            ->paginate(10);

        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        return view('admin.bookings.index', compact(
            'bookings',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'cancelledBookings'
        ));
    }

    public function create()
    {
        $schedules = Schedule::with('package')
            ->where('is_active', true)
            ->whereDate('travel_date', '>=', today())
            ->where('available_seats', '>', 0)
            ->whereHas('package', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('travel_date')
            ->get();

        return view('admin.bookings.create', compact('schedules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'schedule_id' => 'required|exists:schedules,id',
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
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'schedule_id' => 'Jadwal tidak aktif atau sudah lewat.',
                ]);
            }

            if ($schedule->available_seats < $validated['quantity']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity' => 'Jumlah tiket melebihi kursi yang tersedia.',
                ]);
            }

            $price = $schedule->package->price;
            $subtotal = $price * $validated['quantity'];

            $booking = Booking::create([
                'booking_code' => 'KAI-' . now()->format('YmdHis')
                    . '-' . strtoupper(Str::random(5)),
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
                'amount' => $booking->total_amount,
                'status' => 'pending',
        ]);

            $schedule->decrement(
                'available_seats',
                $validated['quantity']
            );

            return $booking;
        });

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Booking berhasil dibuat!');
    }

    public function show(Booking $booking)
    {
        $booking->load('details.package', 'details.schedule', 'payments');

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['confirmed', 'cancelled', 'completed']),
            ],
        ]);

        DB::transaction(function () use ($booking, $validated) {

            $booking = Booking::whereKey($booking->id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldStatus = $booking->status;
            $newStatus = $validated['status'];

            if ($oldStatus === 'cancelled' || $oldStatus === 'completed') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Booking yang sudah dibatalkan atau selesai tidak dapat diubah.',
                ]);
            }
            if ($newStatus === 'completed' && $oldStatus !== 'confirmed') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                       'status' => 'Booking harus dikonfirmasi sebelum diselesaikan.',
    ]);
            }

            if ($newStatus === 'cancelled') {
                $details = $booking->details()->get();

                foreach ($details as $detail) {
                    $schedule = Schedule::whereKey($detail->schedule_id)
                        ->lockForUpdate()
                        ->first();

                    if ($schedule) {
                        $schedule->increment(
                            'available_seats',
                            $detail->quantity
                        );
                    }
                }
            }

            $booking->update([
                'status' => $newStatus,
            ]);
        });

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Status booking berhasil diperbarui!');
    }
}
