<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    // Menampilkan seluruh transaksi
    public function index()
    {
        $payments = Payment::with('booking')
            ->latest()
            ->paginate(10);

        $totalPayments = Payment::count();

        $pendingPayments = Payment::where('status', 'pending')->count();

        $paidPayments = Payment::where('status', 'paid')->count();

        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        return view('admin.payments.index', compact(
            'payments',
            'totalPayments',
            'pendingPayments',
            'paidPayments',
            'totalRevenue'
        ));
    }

    // Menampilkan detail transaksi
    public function show(Payment $payment)
    {
        $payment->load('booking.details.package', 'booking.details.schedule');

        return view('admin.payments.show', compact('payment'));
    }

    // Verifikasi pembayaran
    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['paid', 'failed']),
            ],
        ]);

        DB::transaction(function () use ($payment, $validated) {

            $payment = Payment::whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $payment->load('booking');

            if ($payment->status !== 'pending') {
                abort(422, 'Pembayaran ini sudah diproses.');
            }

            if ($payment->booking->status === 'cancelled') {
                abort(422, 'Booking sudah dibatalkan.');
            }

           $payment->status = $validated['status'];
            $payment->verified_at = now();

            if ($validated['status'] === 'paid') {
                 $payment->paid_at = now();

         if ($payment->booking->status === 'pending') {
        $payment->booking->update([
            'status' => 'confirmed',
        ]);
    }
            }

$payment->save();
        });

        return redirect()
            ->route('admin.payments.show', $payment->id)
            ->with(
                'success',
                $validated['status'] === 'paid'
                    ? 'Pembayaran berhasil dikonfirmasi!'
                    : 'Pembayaran ditandai gagal!'
            );
    }

    
public function showProof(Payment $payment)
{
    if (!$payment->proof_of_payment) {
        abort(404, 'Bukti pembayaran tidak ditemukan.');
    }

    $disk = Storage::disk('local');

    if (!$disk->exists($payment->proof_of_payment)) {
        abort(404, 'File bukti pembayaran tidak ditemukan.');
    }

    $filePath = $disk->path($payment->proof_of_payment);

    return response()->file($filePath, [
        'Content-Type' => $disk->mimeType($payment->proof_of_payment),
        'Content-Disposition' => 'inline',
        'X-Content-Type-Options' => 'nosniff',
    ]);
}


}
