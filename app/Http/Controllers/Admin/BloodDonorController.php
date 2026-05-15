<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodDonor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BloodDonorController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/BloodDonor/Index', [
            'donors' => BloodDonor::orderBy('date', 'desc')->paginate(15),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/BloodDonor/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'location'   => 'required|string|max:255',
            'date'       => 'required|date',
            'time_start' => 'required',
            'time_end'   => 'required',
        ]);

        $data = $request->only(['name', 'location', 'date', 'time_start', 'time_end']);
        $data['slug'] = Str::slug($request->name);

        BloodDonor::create($data);

        return redirect()->route('admin.blood-donors.index')
            ->with('success', 'Data donor berhasil ditambahkan.');
    }

    public function edit(BloodDonor $bloodDonor)
    {
        return Inertia::render('Admin/BloodDonor/Form', [
            'donor' => $bloodDonor,
        ]);
    }

    public function update(Request $request, BloodDonor $bloodDonor)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'location'   => 'required|string|max:255',
            'date'       => 'required|date',
            'time_start' => 'required',
            'time_end'   => 'required',
        ]);

        $data = $request->only(['name', 'location', 'date', 'time_start', 'time_end']);
        $data['slug'] = Str::slug($request->name);

        $bloodDonor->update($data);

        return redirect()->route('admin.blood-donors.index')
            ->with('success', 'Data donor berhasil diperbarui.');
    }

    public function destroy(BloodDonor $bloodDonor)
    {
        $bloodDonor->delete();

        return redirect()->route('admin.blood-donors.index')
            ->with('success', 'Data donor berhasil dihapus.');
    }
}
