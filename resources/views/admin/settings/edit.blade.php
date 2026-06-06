@extends('layouts.app')

@section('title', 'Pengaturan PPDB')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-950">Pengaturan PPDB</h1>
            <p class="mt-2 text-sm text-slate-600">Atur identitas sekolah, tahun ajaran, jadwal, kuota, persyaratan, dan status pengumuman.</p>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            @method('PATCH')

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="school_name" class="block text-sm font-medium text-slate-700">Nama sekolah</label>
                    <input id="school_name" name="school_name" value="{{ old('school_name', $setting->school_name) }}" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <x-input-error :messages="$errors->get('school_name')" />
                </div>
                <div>
                    <label for="academic_year" class="block text-sm font-medium text-slate-700">Tahun ajaran</label>
                    <input id="academic_year" name="academic_year" value="{{ old('academic_year', $setting->academic_year) }}" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <x-input-error :messages="$errors->get('academic_year')" />
                </div>
                <div>
                    <label for="registration_start" class="block text-sm font-medium text-slate-700">Tanggal mulai</label>
                    <input id="registration_start" type="date" name="registration_start" value="{{ old('registration_start', $setting->registration_start?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <x-input-error :messages="$errors->get('registration_start')" />
                </div>
                <div>
                    <label for="registration_end" class="block text-sm font-medium text-slate-700">Tanggal selesai</label>
                    <input id="registration_end" type="date" name="registration_end" value="{{ old('registration_end', $setting->registration_end?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <x-input-error :messages="$errors->get('registration_end')" />
                </div>
                <div>
                    <label for="quota" class="block text-sm font-medium text-slate-700">Kuota diterima</label>
                    <input id="quota" type="number" min="1" name="quota" value="{{ old('quota', $setting->quota) }}" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <x-input-error :messages="$errors->get('quota')" />
                </div>
                <div>
                    <label for="reserve_quota" class="block text-sm font-medium text-slate-700">Kuota cadangan</label>
                    <input id="reserve_quota" type="number" min="0" name="reserve_quota" value="{{ old('reserve_quota', $setting->reserve_quota) }}" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    <x-input-error :messages="$errors->get('reserve_quota')" />
                </div>
                <div class="md:col-span-2">
                    <label for="requirements" class="block text-sm font-medium text-slate-700">Persyaratan berkas</label>
                    <textarea id="requirements" name="requirements" rows="6" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('requirements', $setting->requirements) }}</textarea>
                    <p class="mt-1 text-xs text-slate-500">Tulis satu persyaratan per baris.</p>
                    <x-input-error :messages="$errors->get('requirements')" />
                </div>
            </div>

            <div class="mt-6 grid gap-3 md:grid-cols-2">
                <label class="flex items-center gap-3 rounded-lg border border-slate-200 p-4 text-sm text-slate-700">
                    <input type="checkbox" name="is_registration_open" value="1" class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600" @checked(old('is_registration_open', $setting->is_registration_open))>
                    Buka pendaftaran online
                </label>
                <label class="flex items-center gap-3 rounded-lg border border-slate-200 p-4 text-sm text-slate-700">
                    <input type="checkbox" name="is_announcement_published" value="1" class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600" @checked(old('is_announcement_published', $setting->is_announcement_published))>
                    Publikasikan pengumuman hasil seleksi
                </label>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Batal</a>
                <button type="submit" class="rounded-md bg-emerald-700 px-5 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
@endsection
