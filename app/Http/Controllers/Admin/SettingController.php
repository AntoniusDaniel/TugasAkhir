<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'setting' => AdmissionSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:120'],
            'academic_year' => ['required', 'string', 'max:20'],
            'quota' => ['required', 'integer', 'min:1', 'max:500'],
            'reserve_quota' => ['required', 'integer', 'min:0', 'max:500'],
            'registration_start' => ['nullable', 'date'],
            'registration_end' => ['nullable', 'date', 'after_or_equal:registration_start'],
            'requirements' => ['nullable', 'string', 'max:3000'],
        ]);

        AdmissionSetting::current()->update([
            ...$validated,
            'is_registration_open' => $request->boolean('is_registration_open'),
            'is_announcement_published' => $request->boolean('is_announcement_published'),
        ]);

        return back()->with('success', 'Pengaturan PPDB berhasil disimpan.');
    }
}
