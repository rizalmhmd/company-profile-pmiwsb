<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class HeroSliderController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/HeroSlider/Index', [
            'sliders' => HeroSlider::orderBy('order')->get()->map(function ($s) {
                $s->image_url = $s->image_path ? Storage::url($s->image_path) : null;
                return $s;
            }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/HeroSlider/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $path = $request->file('image')->store('hero-sliders', 'public');

        HeroSlider::create([
            'image_path'  => $path,
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'order'       => $request->order ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(HeroSlider $heroSlider)
    {
        $heroSlider->image_url = $heroSlider->image_path ? Storage::url($heroSlider->image_path) : null;
        return Inertia::render('Admin/HeroSlider/Form', [
            'slider' => $heroSlider,
        ]);
    }

    public function update(Request $request, HeroSlider $heroSlider)
    {
        $request->validate([
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'title'       => 'nullable|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order'       => 'nullable|integer',
            'is_active'   => 'boolean',
        ]);

        $data = [
            'title'       => $request->title,
            'subtitle'    => $request->subtitle,
            'description' => $request->description,
            'order'       => $request->order ?? $heroSlider->order,
            'is_active'   => $request->boolean('is_active', $heroSlider->is_active),
        ];

        if ($request->hasFile('image')) {
            if ($heroSlider->image_path) {
                Storage::disk('public')->delete($heroSlider->image_path);
            }
            $data['image_path'] = $request->file('image')->store('hero-sliders', 'public');
        }

        $heroSlider->update($data);

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image_path) {
            Storage::disk('public')->delete($heroSlider->image_path);
        }
        $heroSlider->delete();

        return redirect()->route('admin.hero-sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
