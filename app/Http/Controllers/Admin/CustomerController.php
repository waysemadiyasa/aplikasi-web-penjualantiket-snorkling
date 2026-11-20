<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Booking::query()
            ->select(
                'customer_name',
                'email',
                'phone',
                DB::raw('COUNT(*) as total_bookings'),
                DB::raw('SUM(total_amount) as total_transaction'),
                DB::raw('MAX(created_at) as last_booking')
            )
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('customer_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->groupBy('customer_name', 'email', 'phone')
            ->orderByDesc('last_booking')
            ->paginate(10)
            ->withQueryString();

        $totalCustomers = Booking::distinct()
            ->count(DB::raw("CONCAT(customer_name, '|', email, '|', phone)"));

        $totalBookings = Booking::count();

        $totalRevenue = DB::table('payments')
            ->where('status', 'paid')
            ->sum('amount');

        return view('admin.customers.index', compact(
            'customers',
            'totalCustomers',
            'totalBookings',
            'totalRevenue',
            'search'
        ));
    }

    public function show(Request $request)
    {
        $customer = Booking::where('email', $request->email)
            ->firstOrFail();

        $bookings = Booking::with([
            'details.package',
            'details.schedule',
            'payments'
        ])
        ->where('email', $customer->email)
        ->latest()
        ->paginate(10);

        return view('admin.customers.show', compact(
            'customer',
            'bookings'
        ));
    }
}
