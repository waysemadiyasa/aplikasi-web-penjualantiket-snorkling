<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrCreate(
            [],
            ['business_name' => 'KAI TRIP TOMMOROW']
        );

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_description' => 'nullable|string',
            'business_address' => 'nullable|string',
            'whatsapp' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $setting = Setting::firstOrCreate(
            [],
            ['business_name' => 'KAI TRIP TOMMOROW']
        );

        $oldLogo = $setting->logo;

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('logos', 'public');
        }

        $setting->update($validated);

        if (isset($validated['logo']) && $oldLogo) {
            Storage::disk('public')->delete($oldLogo);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Profil usaha berhasil diperbarui.');
    }
}
