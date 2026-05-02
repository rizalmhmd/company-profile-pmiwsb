<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodStock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BloodStockController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/BloodStock/Index', [
            'stocks' => BloodStock::orderBy('product')->get(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/BloodStock/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|string|max:100',
            'stock_a'  => 'required|integer|min:0',
            'stock_b'  => 'required|integer|min:0',
            'stock_o'  => 'required|integer|min:0',
            'stock_ab' => 'required|integer|min:0',
        ]);

        BloodStock::create($request->all());

        return redirect()->route('admin.blood-stocks.index')
            ->with('success', 'Stok darah berhasil ditambahkan.');
    }

    public function edit(BloodStock $bloodStock)
    {
        return Inertia::render('Admin/BloodStock/Form', [
            'stock' => $bloodStock,
        ]);
    }

    public function update(Request $request, BloodStock $bloodStock)
    {
        $request->validate([
            'product' => 'required|string|max:100',
            'stock_a'  => 'required|integer|min:0',
            'stock_b'  => 'required|integer|min:0',
            'stock_o'  => 'required|integer|min:0',
            'stock_ab' => 'required|integer|min:0',
        ]);

        $bloodStock->update($request->all());

        return redirect()->route('admin.blood-stocks.index')
            ->with('success', 'Stok darah berhasil diperbarui.');
    }

    public function destroy(BloodStock $bloodStock)
    {
        $bloodStock->delete();

        return redirect()->route('admin.blood-stocks.index')
            ->with('success', 'Stok darah berhasil dihapus.');
    }
}
