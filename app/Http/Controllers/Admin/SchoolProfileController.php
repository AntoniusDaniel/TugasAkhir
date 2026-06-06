<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SchoolProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => SchoolProfile::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:180'],
            'headmaster' => ['nullable', 'string', 'max:120'],
            'accreditation' => ['nullable', 'string', 'max:80'],
            'description' => ['nullable', 'string', 'max:2500'],
            'vision' => ['nullable', 'string', 'max:1000'],
            'mission' => ['nullable', 'string', 'max:2500'],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:120'],
            'website' => ['nullable', 'url', 'max:180'],
            'map_url' => ['nullable', 'url', 'max:500'],
            'faq' => ['nullable', 'string', 'max:3500'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $profile = SchoolProfile::current();

        if ($request->hasFile('photo')) {
            if ($profile->photo_path) {
                Storage::disk('public')->delete($profile->photo_path);
            }

            $validated['photo_path'] = $request->file('photo')->store('school', 'public');
        }

        unset($validated['photo']);

        $profile->update($validated);

        return back()->with('success', 'Profil sekolah berhasil disimpan.');
    }
}
