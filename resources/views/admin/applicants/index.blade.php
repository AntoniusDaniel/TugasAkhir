@extends('layouts.app')

@section('title', 'Data Pendaftar PPDB')

@section('content')
    <div class="mb-6 flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-950">Data Pendaftar</h1>
            <p class="mt-2 text-sm text-slate-600">Cari, filter, verifikasi, dan tetapkan hasil seleksi calon peserta didik.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.applicants.export') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Export CSV</a>
            <a href="{{ route('admin.dashboard') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Dashboard</a>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.applicants.index') }}" class="mb-5 grid gap-3 rounded-lg border border-slate-200 bg-white p-4 shadow-sm md:grid-cols-[1fr_180px_180px_auto]">
        <input name="search" value="{{ request('search') }}" placeholder="Cari nomor, nama, orang tua, atau asal sekolah" class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
        <select name="verification_status" class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
            <option value="">Semua verifikasi</option>
            @foreach ($verificationOptions as $value => $label)
                <option value="{{ $value }}" @selected(request('verification_status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <select name="selection_status" class="rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
            <option value="">Semua seleksi</option>
            @foreach ($selectionOptions as $value => $label)
                <option value="{{ $value }}" @selected(request('selection_status') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-md bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800">Filter</button>
    </form>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Nomor</th>
                        <th class="px-4 py-3">Nama Siswa</th>
                        <th class="px-4 py-3">Orang Tua</th>
                        <th class="px-4 py-3">Asal Sekolah</th>
                        <th class="px-4 py-3">Verifikasi</th>
                        <th class="px-4 py-3">Seleksi</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($applicants as $applicant)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-medium text-slate-950">{{ $applicant->registration_number }}</td>
                            <td class="px-4 py-3">{{ $applicant->student_name }}</td>
                            <td class="px-4 py-3">{{ $applicant->parent_name }}</td>
                            <td class="px-4 py-3">{{ $applicant->previous_school }}</td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="['pending' => 'amber', 'verified' => 'green', 'rejected' => 'red'][$applicant->verification_status] ?? 'neutral'">
                                    {{ $applicant->verificationLabel() }}
                                </x-status-badge>
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :variant="['waiting' => 'neutral', 'accepted' => 'green', 'reserve' => 'amber', 'rejected' => 'red'][$applicant->selection_status] ?? 'neutral'">
                                    {{ $applicant->selectionLabel() }}
                                </x-status-badge>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.applicants.show', $applicant) }}" class="font-semibold text-emerald-700 hover:text-emerald-900">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">Data pendaftar belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 px-4 py-3">
            {{ $applicants->links() }}
        </div>
    </div>
@endsection
