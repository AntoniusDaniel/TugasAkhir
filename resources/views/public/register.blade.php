@extends('layouts.app')

@section('title', 'Form Pendaftaran PPDB')

@section('content')
    @php
        $account = $user ?? auth()->user();
        $steps = [
            ['number' => '01', 'label' => 'Data siswa'],
            ['number' => '02', 'label' => 'Orang tua'],
            ['number' => '03', 'label' => 'Berkas'],
            ['number' => '04', 'label' => 'Kirim'],
        ];
    @endphp

    <div class="mb-5 grid gap-4 sm:mb-6 lg:grid-cols-[1fr_auto] lg:items-end">
        <div>
            <p class="section-kicker">Pendaftaran online</p>
            <h1 class="mt-1 text-2xl font-bold leading-tight text-slate-950 sm:text-3xl">Form Pendaftaran Calon Peserta Didik</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                Isi data secara berurutan. Berkas dapat berupa PDF atau gambar dengan ukuran maksimal 2 MB.
            </p>
        </div>

        <x-status-badge :variant="$setting->registrationIsActive() ? 'green' : 'red'">
            {{ $setting->registrationIsActive() ? 'Pendaftaran dibuka' : 'Pendaftaran ditutup' }}
        </x-status-badge>
    </div>

    @unless ($setting->registrationIsActive())
        <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 shadow-sm">
            Pendaftaran saat ini ditutup. Form tetap ditampilkan untuk pratinjau data yang diperlukan.
        </div>
    @endunless

    <div class="mb-6 rounded-lg border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-950 shadow-sm">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="font-semibold">Akun pendaftar aktif</p>
                <p class="mt-1 text-emerald-800">{{ $account?->name }} - {{ $account?->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary bg-white">Keluar akun</button>
            </form>
        </div>
    </div>

    <div class="grid min-w-0 gap-5 2xl:grid-cols-[280px_minmax(0,1fr)] 2xl:items-start">
        <aside class="min-w-0 2xl:sticky 2xl:top-24">
            <div class="surface p-4">
                <div class="flex items-center justify-between gap-3">
                    <p class="section-kicker">Panduan cepat</p>
                    <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-500 2xl:hidden">Geser</span>
                </div>
                <div class="-mx-1 mt-4 flex gap-3 overflow-x-auto px-1 pb-2 2xl:mx-0 2xl:flex-col 2xl:overflow-visible 2xl:px-0 2xl:pb-0">
                    @foreach ($steps as $step)
                        <div class="step-pill">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-emerald-700 text-xs font-bold text-white">{{ $step['number'] }}</span>
                            <span class="text-sm font-semibold text-slate-800">{{ $step['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                    <p class="font-semibold">Jadwal</p>
                    <p class="mt-1">
                        {{ $setting->registration_start?->translatedFormat('d F Y') ?? '-' }}
                        sampai
                        {{ $setting->registration_end?->translatedFormat('d F Y') ?? '-' }}
                    </p>
                </div>
            </div>
        </aside>

        <form method="POST" action="{{ route('registrations.store') }}" enctype="multipart/form-data" class="min-w-0 space-y-5 sm:space-y-6">
            @csrf

            <section class="form-card">
                <div class="flex flex-col gap-2 border-b border-slate-200 pb-4 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <p class="section-kicker">Langkah 01</p>
                        <h2 class="mt-1 text-lg font-semibold text-slate-950">Data Calon Peserta Didik</h2>
                    </div>
                    <span class="text-sm text-slate-500">Kolom bertanda wajib harus diisi</span>
                </div>

                <div class="mt-5 grid min-w-0 gap-4 xl:grid-cols-2 xl:gap-5">
                    <div class="min-w-0">
                        <label for="student_name" class="form-label">Nama lengkap</label>
                        <input id="student_name" name="student_name" value="{{ old('student_name') }}" required class="form-control" placeholder="Nama sesuai dokumen">
                        <x-input-error :messages="$errors->get('student_name')" />
                    </div>
                    <div class="min-w-0">
                        <label for="nisn" class="form-label">NISN</label>
                        <input id="nisn" name="nisn" value="{{ old('nisn') }}" class="form-control" placeholder="Opsional">
                        <x-input-error :messages="$errors->get('nisn')" />
                    </div>
                    <div class="min-w-0">
                        <label for="birth_place" class="form-label">Tempat lahir</label>
                        <input id="birth_place" name="birth_place" value="{{ old('birth_place') }}" required class="form-control" placeholder="Contoh: Gunungkidul">
                        <x-input-error :messages="$errors->get('birth_place')" />
                    </div>
                    <div class="min-w-0">
                        <label for="birth_date" class="form-label">Tanggal lahir</label>
                        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required class="form-control">
                        <x-input-error :messages="$errors->get('birth_date')" />
                    </div>
                    <div class="min-w-0">
                        <label for="gender" class="form-label">Jenis kelamin</label>
                        <select id="gender" name="gender" required class="form-control">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" />
                    </div>
                    <div class="min-w-0">
                        <label for="religion" class="form-label">Agama</label>
                        <input id="religion" name="religion" value="{{ old('religion') }}" class="form-control" placeholder="Opsional">
                        <x-input-error :messages="$errors->get('religion')" />
                    </div>
                    <div class="min-w-0 xl:col-span-2">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea id="address" name="address" rows="3" required class="form-control" placeholder="Alamat tempat tinggal calon peserta didik">{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                    <div class="min-w-0 xl:col-span-2">
                        <label for="previous_school" class="form-label">Asal sekolah/TK</label>
                        <input id="previous_school" name="previous_school" value="{{ old('previous_school') }}" required class="form-control" placeholder="Contoh: TK Pertiwi Semayu">
                        <x-input-error :messages="$errors->get('previous_school')" />
                    </div>
                </div>
            </section>

            <section class="form-card">
                <div class="border-b border-slate-200 pb-4">
                    <p class="section-kicker">Langkah 02</p>
                    <h2 class="mt-1 text-lg font-semibold text-slate-950">Data Orang Tua/Wali</h2>
                </div>

                <div class="mt-5 grid min-w-0 gap-4 xl:grid-cols-3 xl:gap-5">
                    <div class="min-w-0">
                        <label for="parent_name" class="form-label">Nama orang tua/wali</label>
                        <input id="parent_name" name="parent_name" value="{{ old('parent_name', $account?->name) }}" required class="form-control">
                        <x-input-error :messages="$errors->get('parent_name')" />
                    </div>
                    <div class="min-w-0">
                        <label for="parent_phone" class="form-label">Nomor telepon</label>
                        <input id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" required class="form-control" placeholder="08xxxxxxxxxx">
                        <x-input-error :messages="$errors->get('parent_phone')" />
                    </div>
                    <div class="min-w-0">
                        <label for="parent_email" class="form-label">Email</label>
                        <input id="parent_email" type="email" name="parent_email" value="{{ old('parent_email', $account?->email) }}" class="form-control" placeholder="Opsional">
                        <x-input-error :messages="$errors->get('parent_email')" />
                    </div>
                </div>
            </section>

            <section class="form-card">
                <div class="border-b border-slate-200 pb-4">
                    <p class="section-kicker">Langkah 03</p>
                    <h2 class="mt-1 text-lg font-semibold text-slate-950">Unggah Berkas</h2>
                    <p class="mt-1 text-sm text-slate-500">Format yang diterima: PDF, JPG, JPEG, PNG. Ukuran maksimal 2 MB per berkas.</p>
                </div>

                <div class="mt-5 grid min-w-0 gap-4 2xl:grid-cols-3 2xl:gap-5">
                    <div class="min-w-0 rounded-lg border border-slate-200 p-4">
                        <label for="birth_certificate" class="form-label">Akta kelahiran</label>
                        <input id="birth_certificate" type="file" name="birth_certificate" required class="form-file">
                        <x-input-error :messages="$errors->get('birth_certificate')" />
                    </div>
                    <div class="min-w-0 rounded-lg border border-slate-200 p-4">
                        <label for="family_card" class="form-label">Kartu keluarga</label>
                        <input id="family_card" type="file" name="family_card" required class="form-file">
                        <x-input-error :messages="$errors->get('family_card')" />
                    </div>
                    <div class="min-w-0 rounded-lg border border-slate-200 p-4">
                        <label for="photo" class="form-label">Foto calon peserta didik</label>
                        <input id="photo" type="file" name="photo" required class="form-file">
                        <x-input-error :messages="$errors->get('photo')" />
                    </div>
                </div>
            </section>

            <section class="form-card">
                <div class="grid gap-5 xl:grid-cols-[1fr_auto] xl:items-center">
                    <div class="min-w-0">
                        <p class="section-kicker">Langkah 04</p>
                        <label class="mt-3 flex gap-3 text-sm leading-6 text-slate-700">
                            <input type="checkbox" name="agreement" value="1" required class="mt-1 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600" @checked(old('agreement'))>
                            <span>Saya menyatakan data yang diisi benar dan bersedia mengikuti proses verifikasi panitia PPDB.</span>
                        </label>
                        <x-input-error :messages="$errors->get('agreement')" />
                    </div>

                    <button type="submit" @disabled(! $setting->registrationIsActive()) class="btn-primary w-full xl:w-auto">
                        Kirim Pendaftaran
                    </button>
                </div>
            </section>
        </form>
    </div>
@endsection
