@extends('layouts.app')

@section('title', 'Pengumuman Hasil PPDB')

@section('content')
    <div class="surface mb-6 overflow-hidden">
        <div class="grid gap-6 bg-slate-900 p-5 text-white sm:p-7 lg:grid-cols-[1fr_auto] lg:items-end">
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-emerald-300">Pengumuman PPDB</p>
                <h1 class="mt-2 text-2xl font-bold leading-tight sm:text-3xl">Hasil Seleksi Calon Peserta Didik</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-300">
                    Tahun ajaran {{ $setting->academic_year }} - {{ $setting->school_name }}.
                    Hasil yang tampil mengikuti data terbaru dari panitia PPDB.
                </p>
            </div>

            <div class="rounded-lg border border-white/10 bg-white/10 p-4 backdrop-blur">
                <x-status-badge :variant="$setting->is_announcement_published ? 'green' : 'amber'">
                    {{ $setting->is_announcement_published ? 'Sudah dipublikasikan' : 'Belum dipublikasikan' }}
                </x-status-badge>
                <p class="mt-3 text-sm text-slate-300">Total tampil</p>
                <p class="text-2xl font-bold">{{ $acceptedApplicants->count() + $reserveApplicants->count() }} siswa</p>
            </div>
        </div>
    </div>

    @unless ($setting->is_announcement_published)
        <div class="surface border-amber-200 bg-amber-50 p-5 text-sm text-amber-900">
            <p class="font-semibold">Pengumuman belum dibuka oleh panitia.</p>
            <p class="mt-1">Silakan gunakan halaman cek status atau kunjungi kembali halaman ini secara berkala.</p>
        </div>
    @else
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="surface p-4">
                <p class="text-sm text-slate-500">Kuota diterima</p>
                <p class="mt-1 text-2xl font-bold text-slate-950">{{ $setting->quota }}</p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500">Kuota cadangan</p>
                <p class="mt-1 text-2xl font-bold text-slate-950">{{ $setting->reserve_quota }}</p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500">Diterima</p>
                <p class="mt-1 text-2xl font-bold text-emerald-700">{{ $acceptedApplicants->count() }}</p>
            </div>
            <div class="surface p-4">
                <p class="text-sm text-slate-500">Cadangan</p>
                <p class="mt-1 text-2xl font-bold text-amber-700">{{ $reserveApplicants->count() }}</p>
            </div>
        </section>

        <section class="surface mt-6 overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
                <div>
                    <p class="section-kicker">Daftar hasil seleksi</p>
                    <h2 class="mt-1 text-lg font-semibold text-slate-950">Peserta Didik Baru</h2>
                </div>

                <div class="flex rounded-lg border border-slate-200 bg-slate-50 p-1" role="tablist" aria-label="Daftar pengumuman">
                    <button type="button" class="tab-button tab-button-active" data-announcement-tab="accepted" role="tab" aria-selected="true">
                        Diterima
                    </button>
                    <button type="button" class="tab-button" data-announcement-tab="reserve" role="tab" aria-selected="false">
                        Cadangan
                    </button>
                </div>
            </div>

            <div data-announcement-panel="accepted" role="tabpanel">
                <div class="grid gap-3 p-4 sm:hidden">
                    @forelse ($acceptedApplicants as $applicant)
                        <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-sm font-semibold text-slate-950">{{ $applicant->student_name }}</span>
                                <x-status-badge variant="green">Diterima</x-status-badge>
                            </div>
                            <p class="mt-2 text-sm font-medium text-slate-600">{{ $applicant->registration_number }}</p>
                        </div>
                    @empty
                        <p class="rounded-lg bg-slate-50 p-5 text-center text-sm text-slate-500">Belum ada data diterima.</p>
                    @endforelse
                </div>

                <div class="hidden overflow-x-auto sm:block">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-5 py-3">No</th>
                                <th class="px-5 py-3">Nomor</th>
                                <th class="px-5 py-3">Nama</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($acceptedApplicants as $applicant)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4 font-semibold text-slate-950">{{ $applicant->registration_number }}</td>
                                    <td class="px-5 py-4">{{ $applicant->student_name }}</td>
                                    <td class="px-5 py-4"><x-status-badge variant="green">Diterima</x-status-badge></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada data diterima.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="hidden" data-announcement-panel="reserve" role="tabpanel">
                <div class="grid gap-3 p-4 sm:hidden">
                    @forelse ($reserveApplicants as $applicant)
                        <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="flex items-center justify-between gap-3">
                                <span class="text-sm font-semibold text-slate-950">{{ $applicant->student_name }}</span>
                                <x-status-badge variant="amber">Cadangan</x-status-badge>
                            </div>
                            <p class="mt-2 text-sm font-medium text-slate-600">{{ $applicant->registration_number }}</p>
                        </div>
                    @empty
                        <p class="rounded-lg bg-slate-50 p-5 text-center text-sm text-slate-500">Belum ada data cadangan.</p>
                    @endforelse
                </div>

                <div class="hidden overflow-x-auto sm:block">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                            <tr>
                                <th class="px-5 py-3">No</th>
                                <th class="px-5 py-3">Nomor</th>
                                <th class="px-5 py-3">Nama</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($reserveApplicants as $applicant)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-4 font-semibold text-slate-950">{{ $applicant->registration_number }}</td>
                                    <td class="px-5 py-4">{{ $applicant->student_name }}</td>
                                    <td class="px-5 py-4"><x-status-badge variant="amber">Cadangan</x-status-badge></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada data cadangan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    @endunless
@endsection
