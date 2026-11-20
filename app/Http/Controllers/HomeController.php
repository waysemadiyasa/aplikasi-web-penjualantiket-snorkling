<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Category;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Setting;

class HomeController extends Controller
{
    // Halaman utama website
    public function index()
    {
        $packages = Package::with('category')
            ->where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        $totalPackages = Package::where('is_active', true)->count();

        $totalSchedules = Schedule::where('is_active', true)
            ->whereDate('travel_date', '>=', today())
            ->where('available_seats', '>', 0)
            ->count();
        $setting = Setting::first();
        return view('public.home', compact(
            'packages',
            'categories',
            'totalPackages',
            'totalSchedules',
            'setting'
        )); 
        
    }

    // Detail paket wisata
    public function show($slug)
    {
        $package = Package::with([
            'category',
            'schedules' => function ($query) {
                $query->where('is_active', true)
                    ->whereDate('travel_date', '>=', today())
                    ->where('available_seats', '>', 0)
                    ->orderBy('travel_date')
                    ->orderBy('departure_time');
            }
        ])
        ->where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();
        $setting = Setting::first();
        return view('public.package-detail', compact('package', 'setting'));
    }
    // Halaman katalog berdasarkan kategori wisata
public function category($slug)
{
    $category = Category::where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

    $packages = Package::with('category')
        ->where('category_id', $category->id)
        ->where('is_active', true)
        ->latest()
        ->paginate(9);

    $setting = Setting::first();

    return view('public.package-category', compact(
        'category',
        'packages',
        'setting'
    ));
}
}   