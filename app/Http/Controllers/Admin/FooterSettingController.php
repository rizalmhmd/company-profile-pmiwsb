<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FooterSettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/FooterSetting/Index', [
            'setting' => FooterSetting::first() ?? new FooterSetting(),
        ]);
    }

    public function upsert(Request $request)
    {
        $request->validate([
            'about_pmi' => 'nullable|string',
            'address'   => 'nullable|string|max:500',
            'phone'     => 'nullable|string|max:30',
            'email'     => 'nullable|email|max:255',
            'facebook'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'copyright' => 'nullable|string|max:255',
        ]);

        FooterSetting::updateOrCreate(['id' => 1], $request->all());

        return redirect()->route('admin.footer-setting.index')
            ->with('success', 'Pengaturan footer berhasil disimpan.');
    }
}
