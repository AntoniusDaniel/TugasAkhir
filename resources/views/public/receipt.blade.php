@extends('layouts.app')

@section('title', 'Status Pendaftaran '.$applicant->registration_number)

@section('content')
    <div class="no-print mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="section-kicker">Bukti pendaftaran</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-950">Status dan Bukti Pendaftaran</h1>
        </div>
        <button type="button" class="btn-primary" data-print-page>Cetak Bukti</button>
    </div>

    <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
        <aside class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-5 border-b border-slate-200 pb-4">
                <p class="text-sm font-semibold text-slate-950">{{ $profile->school_name }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $profile->address }}</p>
            </div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">Nomor Pendaftaran</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-950">{{ $applicant->registration_number }}</h1>
            <p class="mt-3 text-sm text-slate-600">Simpan nomor ini untuk mengecek status pendaftaran.</p>

            <div class="mt-6 space-y-3">
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Status verifikasi</p>
                    <div class="mt-2">
                        <x-status-badge :variant="['pending' => 'amber', 'verified' => 'green', 'rejected' => 'red'][$applicant->verification_status] ?? 'neutral'">
                            {{ $applicant->verificationLabel() }}
                        </x-status-badge>
                    </div>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Hasil seleksi</p>
                    <div class="mt-2">
                        <x-status-badge :variant="['waiting' => 'neutral', 'accepted' => 'green', 'reserve' => 'amber', 'rejected' => 'red'][$applicant->selection_status] ?? 'neutral'">
                            {{ $applicant->selectionLabel() }}
                        </x-status-badge>
                    </div>
                </div>
            </div>

            @if ($applicant->verification_note)
                <div class="mt-5 rounded-lg bg-amber-50 p-4 text-sm text-amber-900">
                    <p class="font-semibold">Catatan panitia</p>
                    <p class="mt-1">{{ $applicant->verification_note }}</p>
                </div>
            @endif

            @if ($applicant->selection_status === 'rejected' && $applicant->selection_note)
                <div class="mt-5 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-900">
                    <p class="font-semibold">Catatan hasil seleksi</p>
                    <p class="mt-1 leading-6">{{ $applicant->selection_note }}</p>
                </div>
            @endif
        </aside>

        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-950">Data Pendaftar</h2>
            <dl class="mt-5 grid gap-4 md:grid-cols-2">
                <div>
                    <dt class="text-sm text-slate-500">Nama siswa</dt>
                    <dd class="font-medium text-slate-950">{{ $applicant->student_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">NISN</dt>
                    <dd class="font-medium text-slate-950">{{ $applicant->nisn ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Tempat, tanggal lahir</dt>
                    <dd class="font-medium text-slate-950">{{ $applicant->birth_place }}, {{ $applicant->birth_date->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Jenis kelamin</dt>
                    <dd class="font-medium text-slate-950">{{ $applicant->genderLabel() }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Asal sekolah</dt>
                    <dd class="font-medium text-slate-950">{{ $applicant->previous_school }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Orang tua/wali</dt>
                    <dd class="font-medium text-slate-950">{{ $applicant->parent_name }}</dd>
                </div>
                <div class="md:col-span-2">
                    <dt class="text-sm text-slate-500">Alamat</dt>
                    <dd class="font-medium text-slate-950">{{ $applicant->address }}</dd>
                </div>
            </dl>
        </section>
    </div>
@endsection
