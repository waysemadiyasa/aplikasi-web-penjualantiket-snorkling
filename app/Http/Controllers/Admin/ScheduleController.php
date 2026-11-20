<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('package')
            ->latest('travel_date')
            ->paginate(10);

        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $packages = Package::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.schedules.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'travel_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required|date_format:H:i',
            'quota' => 'required|integer|min:1|max:1000',
            'is_active' => 'required|boolean',
        ]);

        $validated['available_seats'] = $validated['quota'];

        Schedule::create($validated);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Schedule $schedule)
    {
        $packages = Package::where('is_active', true)
            ->orWhere('id', $schedule->package_id)
            ->orderBy('name')
            ->get();

        return view('admin.schedules.edit', compact(
            'schedule',
            'packages'
        ));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:packages,id',
            'travel_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required|date_format:H:i',
            'quota' => 'required|integer|min:1|max:1000',
            'is_active' => 'required|boolean',
        ]);

        DB::transaction(function () use ($schedule, $validated) {

            $current = Schedule::whereKey($schedule->id)
                ->lockForUpdate()
                ->firstOrFail();

            $bookedSeats = $current->quota - $current->available_seats;

            if ($validated['quota'] < $bookedSeats) {
                throw ValidationException::withMessages([
                    'quota' => 'Kuota tidak boleh lebih kecil dari jumlah tiket yang sudah dipesan (' . $bookedSeats . ').',
                ]);
            }

            $validated['available_seats'] =
                $validated['quota'] - $bookedSeats;

            $current->update($validated);
        });

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $bookedSeats = $schedule->quota - $schedule->available_seats;

        if ($bookedSeats > 0) {
            return redirect()
                ->route('admin.schedules.index')
                ->with('error', 'Jadwal tidak dapat dihapus karena sudah memiliki pemesanan.');
        }

        $schedule->delete();

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
}
