@extends('layouts.app')

@section('title', 'Detail Pendaftar '.$applicant->registration_number)

@section('content')
    <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">{{ $applicant->registration_number }}</p>
            <h1 class="mt-1 text-2xl font-bold text-slate-950">{{ $applicant->student_name }}</h1>
            <p class="mt-2 text-sm text-slate-600">Terdaftar pada {{ $applicant->created_at->format('d M Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.applicants.index') }}" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Kembali</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <section class="space-y-6">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Data Calon Siswa</h2>
                <dl class="mt-5 grid gap-4 md:grid-cols-2">
                    <div>
                        <dt class="text-sm text-slate-500">Nama lengkap</dt>
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
                        <dt class="text-sm text-slate-500">Agama</dt>
                        <dd class="font-medium text-slate-950">{{ $applicant->religion ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-slate-500">Asal sekolah/TK</dt>
                        <dd class="font-medium text-slate-950">{{ $applicant->previous_school }}</dd>
                    </div>
                    <div class="md:col-span-2">
                        <dt class="text-sm text-slate-500">Alamat</dt>
                        <dd class="font-medium text-slate-950">{{ $applicant->address }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Data Orang Tua/Wali</h2>
                <dl class="mt-5 grid gap-4 md:grid-cols-3">
                    <div>
                        <dt class="text-sm text-slate-500">Nama</dt>
                        <dd class="font-medium text-slate-950">{{ $applicant->parent_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-slate-500">Telepon</dt>
                        <dd class="font-medium text-slate-950">{{ $applicant->parent_phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-slate-500">Email</dt>
                        <dd class="font-medium text-slate-950">{{ $applicant->parent_email ?: '-' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Berkas Persyaratan</h2>
                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    @foreach (['akta' => 'Akta kelahiran', 'kk' => 'Kartu keluarga', 'foto' => 'Foto siswa'] as $key => $label)
                        <a href="{{ route('admin.applicants.documents', [$applicant, $key]) }}" class="rounded-lg border border-slate-200 p-4 text-sm font-semibold text-slate-700 hover:border-emerald-300 hover:bg-emerald-50">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <aside class="space-y-6">
            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Verifikasi Data</h2>
                <form method="POST" action="{{ route('admin.applicants.verification', $applicant) }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="verification_status" class="block text-sm font-medium text-slate-700">Status verifikasi</label>
                        <select id="verification_status" name="verification_status" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            @foreach ($verificationOptions as $value => $label)
                                <option value="{{ $value }}" @selected($applicant->verification_status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('verification_status')" />
                    </div>
                    <div>
                        <label for="verification_note" class="block text-sm font-medium text-slate-700">Catatan</label>
                        <textarea id="verification_note" name="verification_note" rows="4" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('verification_note', $applicant->verification_note) }}</textarea>
                        <x-input-error :messages="$errors->get('verification_note')" />
                    </div>
                    <button type="submit" class="w-full rounded-md bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Simpan Verifikasi</button>
                </form>
            </div>

            <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-950">Hasil Seleksi</h2>
                <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-slate-500">Kuota diterima</p>
                        <p class="font-bold text-slate-950">{{ $setting->quota }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-slate-500">Kuota cadangan</p>
                        <p class="font-bold text-slate-950">{{ $setting->reserve_quota }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.applicants.selection', $applicant) }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="selection_status" class="block text-sm font-medium text-slate-700">Status seleksi</label>
                        <select id="selection_status" name="selection_status" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                            @foreach ($selectionOptions as $value => $label)
                                <option value="{{ $value }}" @selected($applicant->selection_status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('selection_status')" />
                    </div>
                    <div>
                        <label for="selection_note" class="block text-sm font-medium text-slate-700">Catatan jika tidak diterima</label>
                        <textarea id="selection_note" name="selection_note" rows="4" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100" placeholder="Contoh: Silakan mencoba mendaftar ke sekolah lain yang masih membuka pendaftaran.">{{ old('selection_note', $applicant->selection_note) }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">Catatan ini ditampilkan kepada pendaftar ketika hasil seleksi berstatus tidak diterima.</p>
                        <x-input-error :messages="$errors->get('selection_note')" />
                    </div>
                    <button type="submit" class="w-full rounded-md bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">Simpan Hasil Seleksi</button>
                </form>
            </div>
        </aside>
    </div>
@endsection
