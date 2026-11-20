<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();

        $pendingBookings = Booking::where(
            'status',
            'pending'
        )->count();

        $totalPackages = Package::count();

        $totalCustomers = User::where(
            'role',
            'customer'
        )->count();

        $totalRevenue = Payment::where(
            'status',
            'paid'
        )->sum('amount');

        $recentBookings = Booking::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'totalPackages',
            'totalCustomers',
            'totalRevenue',
            'recentBookings'
        ));
    }
}