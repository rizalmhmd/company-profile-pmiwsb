<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\FooterSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SiteSettingController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/SiteSetting/Index', [
            'site' => SiteSetting::first() ?? new SiteSetting(),
            'footer' => FooterSetting::first() ?? new FooterSetting(),
        ]);
    }

    public function update(Request $request)
    {
        $site = SiteSetting::first() ?? new SiteSetting();
        $footer = FooterSetting::first() ?? new FooterSetting();

        $request->validate([
            // Branding
            'site_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg,svg,webp|max:1024',
            // Footer & Contact
            'about_pmi' => 'nullable|string',
            'address'   => 'nullable|string|max:500',
            'phone'     => 'nullable|string|max:30',
            'email'     => 'nullable|email|max:255',
            'facebook'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'copyright' => 'nullable|string|max:255',
        ]);

        // Handle Branding
        $siteData = $request->only(['site_name']);
        if ($request->hasFile('logo')) {
            if ($site->logo) Storage::disk('public')->delete($site->logo);
            $siteData['logo'] = $request->file('logo')->store('settings', 'public');
        }
        if ($request->hasFile('favicon')) {
            if ($site->favicon) Storage::disk('public')->delete($site->favicon);
            $siteData['favicon'] = $request->file('favicon')->store('settings', 'public');
        }
        
        if ($site->exists) {
            $site->update($siteData);
        } else {
            SiteSetting::create($siteData);
        }

        // Handle Footer & Contact
        $footerData = $request->only(['about_pmi', 'address', 'phone', 'email', 'facebook', 'instagram', 'copyright']);
        if ($footer->exists) {
            $footer->update($footerData);
        } else {
            FooterSetting::create($footerData);
        }

        return redirect()->back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
