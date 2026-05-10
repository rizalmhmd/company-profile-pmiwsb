<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Page/Index', [
            'pages' => Page::orderBy('category')->orderBy('title')->get()->map(function ($p) {
                $p->image_url = $p->image ? Storage::url($p->image) : null;
                return $p;
            }),
        ]);
    }

    public function edit(Page $page)
    {
        $page->image_url = $page->image ? Storage::url($page->image) : null;
        return Inertia::render('Admin/Page/Form', [
            'page' => $page,
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Konten halaman berhasil diperbarui.');
    }
}
