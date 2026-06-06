@extends('layouts.app')

@section('title', 'Dashboard Admin PPDB')

@section('content')
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Panel Panitia PPDB</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-950">Dashboard Admin</h1>
            <p class="mt-2 text-sm text-slate-600">{{ $setting->school_name }} - tahun ajaran {{ $setting->academic_year }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.applicants.index') }}" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Kelola Pendaftar</a>
            <a href="{{ route('admin.profile.edit') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Profil Sekolah</a>
            <a href="{{ route('admin.settings.edit') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Pengaturan</a>
        </div>
    </div>

    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-6">
        @foreach ([
            ['label' => 'Total pendaftar', 'value' => $totalApplicants],
            ['label' => 'Menunggu', 'value' => $pendingApplicants],
            ['label' => 'Terverifikasi', 'value' => $verifiedApplicants],
            ['label' => 'Diterima', 'value' => $acceptedApplicants],
            ['label' => 'Cadangan', 'value' => $reserveApplicants],
            ['label' => 'Sisa kuota', 'value' => $remainingQuota],
        ] as $stat)
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 text-2xl font-bold text-slate-950">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </section>

    <section class="mt-6 grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-lg font-semibold text-slate-950">Pendaftar Terbaru</h2>
                <a href="{{ route('admin.applicants.index') }}" class="text-sm font-semibold text-emerald-700 hover:text-emerald-900">Lihat semua</a>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-3 py-3">Nomor</th>
                            <th class="px-3 py-3">Nama</th>
                            <th class="px-3 py-3">Verifikasi</th>
                            <th class="px-3 py-3">Seleksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($latestApplicants as $applicant)
                            <tr>
                                <td class="px-3 py-3 font-medium text-slate-950">
                                    <a href="{{ route('admin.applicants.show', $applicant) }}" class="hover:text-emerald-700">{{ $applicant->registration_number }}</a>
                                </td>
                                <td class="px-3 py-3">{{ $applicant->student_name }}</td>
                                <td class="px-3 py-3">{{ $applicant->verificationLabel() }}</td>
                                <td class="px-3 py-3">{{ $applicant->selectionLabel() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-6 text-center text-slate-500">Belum ada pendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-950">Status Sistem</h2>
            <div class="mt-4 space-y-3 text-sm">
                <div class="flex items-center justify-between rounded-lg bg-slate-50 p-4">
                    <span class="text-slate-600">Pendaftaran</span>
                    <x-status-badge :variant="$setting->registrationIsActive() ? 'green' : 'red'">
                        {{ $setting->registrationIsActive() ? 'Aktif' : 'Tutup' }}
                    </x-status-badge>
                </div>
                <div class="flex items-center justify-between rounded-lg bg-slate-50 p-4">
                    <span class="text-slate-600">Pengumuman</span>
                    <x-status-badge :variant="$setting->is_announcement_published ? 'green' : 'amber'">
                        {{ $setting->is_announcement_published ? 'Publik' : 'Draft' }}
                    </x-status-badge>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-slate-500">Jadwal pendaftaran</p>
                    <p class="mt-1 font-medium text-slate-950">
                        {{ $setting->registration_start?->translatedFormat('d F Y') ?? '-' }}
                        sampai
                        {{ $setting->registration_end?->translatedFormat('d F Y') ?? '-' }}
                    </p>
                </div>
            </div>
        </aside>
    </section>
@endsection
