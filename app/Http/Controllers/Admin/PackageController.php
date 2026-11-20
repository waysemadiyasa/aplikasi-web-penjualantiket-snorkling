<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.packages.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $validated['slug'] = $this->generateSlug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('packages', 'public');
        }

        Package::create($validated);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket wisata berhasil ditambahkan!');
    }

    public function edit(Package $package)
    {
        $categories = Category::where('is_active', true)
            ->orWhere('id', $package->category_id)
            ->orderBy('name')
            ->get();

        return view('admin.packages.edit', compact(
            'package',
            'categories'
        ));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $validated['slug'] = $this->generateSlug(
            $validated['name'],
            $package->id
        );

        if ($request->hasFile('image')) {
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }

            $validated['image'] = $request->file('image')
                ->store('packages', 'public');
        }

        $package->update($validated);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket wisata berhasil diperbarui!');
    }

    public function destroy(Package $package)
    {
        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket wisata berhasil dihapus!');
    }

    private function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Package::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}