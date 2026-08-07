<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\QueueDisplaySetting;

class QueueSettingController extends Controller
{
    public function index()
    {
        $setting = QueueDisplaySetting::firstOrCreate(['id' => 1]);
        
        return Inertia::render('Admin/Queue/Setting', [
            'setting' => $setting
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'video_url' => 'nullable|url',
            'running_text' => 'nullable|string'
        ]);

        $setting = QueueDisplaySetting::firstOrCreate(['id' => 1]);
        $setting->update($request->only(['video_url', 'running_text']));

        return redirect()->back()->with('success', 'Pengaturan tampilan antrian berhasil diperbarui');
    }
}
