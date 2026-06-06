@extends('layouts.app')

@section('title', 'Buat Akun Pendaftar')

@section('content')
    <div class="mx-auto grid max-w-5xl gap-6 lg:grid-cols-[0.85fr_1fr] lg:items-stretch">
        <aside class="overflow-hidden rounded-lg border border-emerald-100 bg-white shadow-sm">
            <div class="h-full bg-[linear-gradient(135deg,#ecfdf5_0%,#eff6ff_58%,#ffffff_100%)] p-6 sm:p-8">
                <p class="section-kicker">Registrasi akun</p>
                <h1 class="mt-2 text-3xl font-bold leading-tight text-slate-950">Buat akun sebelum mendaftar PPDB</h1>
                <p class="mt-3 text-sm leading-7 text-slate-600">
                    Akun ini digunakan untuk masuk ke sistem sebelum mengisi form pendaftaran calon peserta didik baru.
                    Gunakan email aktif orang tua atau wali.
                </p>

                <div class="mt-6 grid gap-3 text-sm text-slate-700">
                    <div class="rounded-lg border border-emerald-100 bg-white/80 p-4">
                        <p class="font-semibold text-slate-950">1. Buat akun</p>
                        <p class="mt-1">Isi nama, email, dan password.</p>
                    </div>
                    <div class="rounded-lg border border-emerald-100 bg-white/80 p-4">
                        <p class="font-semibold text-slate-950">2. Login otomatis</p>
                        <p class="mt-1">Setelah berhasil, kamu langsung masuk ke form pendaftaran.</p>
                    </div>
                    <div class="rounded-lg border border-emerald-100 bg-white/80 p-4">
                        <p class="font-semibold text-slate-950">3. Kirim data PPDB</p>
                        <p class="mt-1">Lengkapi data siswa, orang tua, dan berkas.</p>
                    </div>
                </div>
            </div>
        </aside>

        <section class="surface p-6 sm:p-8">
            <h2 class="text-2xl font-bold text-slate-950">Data akun pendaftar</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">Satu akun dapat digunakan untuk masuk kembali ke sistem PPDB.</p>

            <form method="POST" action="{{ route('account.store') }}" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label for="name" class="form-label">Nama orang tua/wali</label>
                    <input id="name" name="name" value="{{ old('name') }}" required autofocus class="form-control" placeholder="Nama lengkap">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="email" class="form-label">Email aktif</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control" placeholder="nama@email.com">
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" required class="form-control" placeholder="Minimal 8 karakter">
                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                    <div>
                        <label for="password_confirmation" class="form-label">Ulangi password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control" placeholder="Ketik ulang password">
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full">Buat Akun dan Lanjut Daftar</button>
            </form>

            <p class="mt-5 text-center text-sm text-slate-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:text-emerald-800">Masuk di sini</a>
            </p>
        </section>
    </div>
@endsection
