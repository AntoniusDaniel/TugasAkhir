@extends('layouts.app')

@section('title', 'Cek Status PPDB')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
        <section class="surface overflow-hidden">
            <div class="bg-slate-900 px-5 py-5 text-white sm:px-6">
                <p class="text-xs font-bold uppercase tracking-wide text-emerald-300">Layanan status</p>
                <h1 class="mt-2 text-2xl font-bold leading-tight sm:text-3xl">Cek Status Pendaftaran</h1>
                <p class="mt-2 text-sm leading-6 text-slate-300">
                    Gunakan nomor pendaftaran dan tanggal lahir calon peserta didik untuk melihat status verifikasi dan hasil seleksi.
                </p>
            </div>

            <form method="POST" action="{{ route('registrations.status') }}" class="space-y-5 p-5 sm:p-6">
                @csrf
                <div>
                    <label for="registration_number" class="form-label">Nomor pendaftaran</label>
                    <input id="registration_number" name="registration_number" value="{{ old('registration_number') }}" placeholder="PPDB-2026-0001" required class="form-control uppercase tracking-wide">
                    <x-input-error :messages="$errors->get('registration_number')" />
                </div>
                <div>
                    <label for="birth_date" class="form-label">Tanggal lahir</label>
                    <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required class="form-control">
                    <x-input-error :messages="$errors->get('birth_date')" />
                </div>
                <button type="submit" class="btn-primary w-full">Cari Status</button>
            </form>
        </section>

        <aside class="space-y-4">
            <div class="surface p-5 sm:p-6">
                <p class="section-kicker">Contoh data demo</p>
                <h2 class="mt-1 text-lg font-semibold text-slate-950">Coba fitur cek status</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Gunakan data contoh jika ingin memastikan alur pencarian status berjalan setelah database di-import.
                </p>

                <div class="mt-4 grid gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500">Nomor</span>
                        <span class="font-semibold text-slate-950">PPDB-2026-0001</span>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-slate-500">Tanggal lahir</span>
                        <span class="font-semibold text-slate-950">2019-05-12</span>
                    </div>
                </div>

                <button type="button" class="btn-secondary mt-4 w-full" data-fill-status data-registration-number="PPDB-2026-0001" data-birth-date="2019-05-12">
                    Isi Data Contoh
                </button>
            </div>

            <div class="surface p-5 sm:p-6">
                <p class="section-kicker">Tahapan</p>
                <div class="mt-4 grid gap-3">
                    @foreach (['Data diterima oleh sistem.', 'Panitia memeriksa kelengkapan berkas.', 'Hasil seleksi dapat dilihat setelah pengumuman dibuka.'] as $item)
                        <div class="flex gap-3 rounded-lg bg-slate-50 p-3 text-sm text-slate-700">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-emerald-700 text-xs font-bold text-white">{{ $loop->iteration }}</span>
                            <span>{{ $item }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
@endsection
