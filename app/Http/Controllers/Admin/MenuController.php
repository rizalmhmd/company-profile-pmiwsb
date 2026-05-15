<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Menu/Index', [
            'menus' => Menu::with('children')->main()->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Menu/Form', [
            'parents' => Menu::main()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'url'       => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order'     => 'integer',
            'is_active' => 'boolean',
        ]);

        Menu::create($request->all());

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return Inertia::render('Admin/Menu/Form', [
            'menu'    => $menu,
            'parents' => Menu::where('id', '!=', $menu->id)->main()->get()
        ]);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'url'       => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order'     => 'integer',
            'is_active' => 'boolean',
        ]);

        $menu->update($request->all());

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
