@extends('layouts.app')

@section('title', 'Masuk Akun PPDB')

@section('content')
    <div class="mx-auto grid max-w-5xl gap-6 lg:grid-cols-[1fr_0.85fr] lg:items-stretch">
        <section class="overflow-hidden rounded-lg border border-emerald-100 bg-white shadow-sm">
            <div class="bg-[linear-gradient(135deg,#064e3b_0%,#0f172a_64%,#075985_100%)] p-6 text-white sm:p-8">
                <p class="text-xs font-bold uppercase tracking-wide text-emerald-200">Akun PPDB</p>
                <h1 class="mt-3 text-3xl font-bold leading-tight">Masuk untuk melanjutkan pendaftaran</h1>
                <p class="mt-3 max-w-xl text-sm leading-6 text-emerald-50/90">
                    Calon peserta didik baru perlu masuk menggunakan akun pendaftar sebelum mengisi form PPDB.
                    Admin tetap dapat menggunakan halaman ini untuk mengakses panel pengelolaan.
                </p>
            </div>

            <form method="POST" action="{{ route('login.store') }}" class="p-6 sm:p-8">
                @csrf
                <div class="grid gap-5">
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control" placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" required class="form-control" placeholder="Password akun">
                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                        Ingat sesi login
                    </label>
                    <button type="submit" class="btn-primary w-full">Masuk</button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <div class="surface p-5 sm:p-6">
                <p class="section-kicker">Belum punya akun?</p>
                <h2 class="mt-1 text-xl font-semibold text-slate-950">Buat akun pendaftar</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Setelah akun dibuat, sistem langsung mengarahkan ke form pendaftaran calon peserta didik.
                </p>
                <a href="{{ route('account.register') }}" class="btn-primary mt-5 w-full">Buat Akun Pendaftar</a>
            </div>

            <div class="rounded-lg border border-slate-200 bg-slate-50/80 p-5 text-sm text-slate-600 shadow-sm">
                <p class="font-semibold text-slate-800">Akun demo admin</p>
                <p class="mt-2">Email: admin@sdnsemayu.sch.id</p>
                <p>Password: password</p>
            </div>
        </aside>
    </div>
@endsection
