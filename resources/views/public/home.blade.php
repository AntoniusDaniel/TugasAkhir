@extends('layouts.app')

@section('title', 'Portal PPDB SD Negeri Semayu')

@section('content')
    <section class="grid gap-6 lg:grid-cols-[1.25fr_0.75fr] lg:items-stretch">
        <div class="surface overflow-hidden">
            <div class="border-b border-slate-200 bg-emerald-700 px-5 py-3 text-sm font-semibold text-white sm:px-6">
                Portal layanan PPDB {{ $setting->school_name }}
            </div>

            <div class="p-5 sm:p-7">
                <div class="flex flex-wrap items-center gap-2">
                    <x-status-badge :variant="$setting->registrationIsActive() ? 'green' : 'red'">
                        {{ $setting->registrationIsActive() ? 'Pendaftaran dibuka' : 'Pendaftaran ditutup' }}
                    </x-status-badge>
                    <x-status-badge variant="sky">Tahun ajaran {{ $setting->academic_year }}</x-status-badge>
                </div>

                <h1 class="mt-5 max-w-3xl text-3xl font-bold leading-tight text-slate-950 sm:text-4xl">
                    Aplikasi Penerimaan Peserta Didik Baru
                </h1>
                <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                    Pendaftaran, unggah berkas, verifikasi panitia, pengelolaan kuota, dan publikasi hasil seleksi
                    tersedia dalam satu sistem yang mudah diakses oleh orang tua dan panitia.
                </p>

                <div class="mt-6 grid gap-3 sm:flex sm:flex-wrap">
                    @auth
                        <a href="{{ route('registrations.create') }}" class="btn-primary">Isi Form Pendaftaran</a>
                    @else
                        <a href="{{ route('account.register') }}" class="btn-primary">Buat Akun Pendaftar</a>
                        <a href="{{ route('login') }}" class="btn-secondary">Masuk untuk Mendaftar</a>
                    @endauth
                    <a href="{{ route('school.profile') }}" class="btn-secondary">Profil Sekolah</a>
                    <a href="{{ route('registrations.status.form') }}" class="btn-secondary">Cek Status</a>
                    <a href="{{ route('announcement') }}" class="btn-secondary">Lihat Pengumuman</a>
                </div>
            </div>
        </div>

        <aside class="surface p-5 sm:p-6">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-slate-950">Ringkasan PPDB</h2>
                <span class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">Live</span>
            </div>

            <dl class="mt-5 grid grid-cols-2 gap-3">
                <div class="surface-soft p-4">
                    <dt class="text-sm text-slate-500">Kuota diterima</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-950">{{ $setting->quota }}</dd>
                </div>
                <div class="surface-soft p-4">
                    <dt class="text-sm text-slate-500">Kuota cadangan</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-950">{{ $setting->reserve_quota }}</dd>
                </div>
                <div class="surface-soft p-4">
                    <dt class="text-sm text-slate-500">Pendaftar</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-950">{{ $totalApplicants }}</dd>
                </div>
                <div class="surface-soft p-4">
                    <dt class="text-sm text-slate-500">Diterima</dt>
                    <dd class="mt-1 text-2xl font-bold text-slate-950">{{ $acceptedApplicants }}</dd>
                </div>
            </dl>

            <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                <p class="font-semibold">Jadwal pendaftaran</p>
                <p class="mt-1">
                    {{ $setting->registration_start?->translatedFormat('d F Y') ?? '-' }}
                    sampai
                    {{ $setting->registration_end?->translatedFormat('d F Y') ?? '-' }}
                </p>
            </div>
        </aside>
    </section>

    <section class="mt-6 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="overflow-hidden rounded-lg border border-emerald-100 bg-white shadow-sm shadow-emerald-100/70">
            <div class="border-b border-emerald-100 bg-[linear-gradient(135deg,#ecfdf5_0%,#eff6ff_58%,#ffffff_100%)] p-5 sm:p-6">
                <p class="section-kicker">Persyaratan utama</p>
                <h2 class="mt-1 text-2xl font-bold leading-tight text-slate-950">Siapkan berkas pendaftaran sebelum mengisi form</h2>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                    Beranda difokuskan untuk membantu orang tua menyiapkan dokumen dan memahami langkah pendaftaran PPDB.
                </p>
            </div>

            <div class="p-5 sm:p-6">
                <ul class="grid gap-3 sm:grid-cols-2">
                    @foreach ($setting->requirementList() as $requirement)
                        <li class="flex gap-3 rounded-lg border border-slate-200 bg-slate-50/80 p-4 text-sm leading-6 text-slate-700">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-emerald-700 text-xs font-bold text-white">{{ $loop->iteration }}</span>
                            <span>{{ $requirement }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                    @auth
                        <a href="{{ route('registrations.create') }}" class="btn-primary">Lanjut Isi Form</a>
                    @else
                        <a href="{{ route('account.register') }}" class="btn-primary">Buat Akun untuk Mendaftar</a>
                    @endauth
                    <a href="{{ route('registrations.status.form') }}" class="btn-secondary">Cek Status Pendaftaran</a>
                </div>
            </div>
        </div>

        <div class="surface p-5 sm:p-6">
            <p class="section-kicker">Berkas</p>
            <h2 class="mt-1 text-xl font-semibold text-slate-950">Catatan pengumpulan berkas</h2>
            <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-700">
                <li class="rounded-lg border border-slate-200 bg-slate-50/80 p-3">Pastikan nama dan tanggal lahir sama dengan dokumen resmi.</li>
                <li class="rounded-lg border border-slate-200 bg-slate-50/80 p-3">File dapat berupa PDF atau gambar sesuai ketentuan pada form pendaftaran.</li>
                <li class="rounded-lg border border-slate-200 bg-slate-50/80 p-3">Gunakan nomor telepon orang tua/wali yang aktif untuk komunikasi panitia.</li>
            </ul>
        </div>

        <div class="surface p-5 sm:p-6 lg:col-span-2">
            <p class="section-kicker">Proses</p>
            <h2 class="mt-1 text-xl font-semibold text-slate-950">Alur PPDB</h2>
            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                @foreach (['Calon peserta didik mengisi formulir dan mengunggah berkas.', 'Panitia memeriksa kelengkapan data dan memberi status verifikasi.', 'Panitia menetapkan hasil seleksi sesuai kuota diterima dan cadangan.', 'Orang tua mengecek status atau melihat pengumuman hasil seleksi.'] as $step)
                    <div class="rounded-lg border border-slate-200 p-4 text-sm text-slate-700">
                        <span class="mb-3 flex h-7 w-7 items-center justify-center rounded-md bg-emerald-700 text-xs font-bold text-white">{{ $loop->iteration }}</span>
                        {{ $step }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
