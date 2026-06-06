<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PPDB SD Negeri Semayu')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[linear-gradient(180deg,#f7fbf8_0%,#edf7f4_44%,#f8fafc_100%)] text-slate-900 antialiased">
    @php
        $registrationRoute = auth()->check() ? 'registrations.create' : 'account.register';
        $navItems = [
            ['label' => 'Beranda', 'route' => 'home', 'active' => request()->routeIs('home')],
            ['label' => 'Profil', 'route' => 'school.profile', 'active' => request()->routeIs('school.profile')],
            ['label' => 'Daftar', 'route' => $registrationRoute, 'active' => request()->routeIs('registrations.create') || request()->routeIs('account.register')],
            ['label' => 'Cek Status', 'route' => 'registrations.status.form', 'active' => request()->routeIs('registrations.status.*')],
            ['label' => 'Pengumuman', 'route' => 'announcement', 'active' => request()->routeIs('announcement')],
        ];
    @endphp

    <header class="sticky top-0 z-40 border-b border-emerald-100 bg-white/95 backdrop-blur">
        <nav class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-emerald-700 text-sm font-bold text-white shadow-sm ring-1 ring-emerald-600">SD</span>
                    <span class="min-w-0">
                        <span class="block text-xs font-semibold uppercase tracking-wide text-emerald-700">PPDB Online</span>
                        <span class="block truncate text-lg font-bold leading-tight text-slate-950">SD Negeri Semayu</span>
                    </span>
                </a>

                <div class="hidden items-center gap-2 rounded-lg border border-emerald-100 bg-white p-1 shadow-sm lg:flex">
                    @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}" @class(['nav-item', 'nav-item-active'=> $item['active']]) @if ($item['active']) aria-current="page" @endif>
                        {{ $item['label'] }}
                    </a>
                    @endforeach
                </div>

                <div class="hidden items-center gap-2 lg:flex">
                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary px-3 py-2">Admin</a>
                        @else
                            <a href="{{ route('registrations.create') }}" class="btn-primary px-3 py-2">Form Daftar</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn-secondary px-3 py-2">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary px-3 py-2">Masuk</a>
                        <a href="{{ route('account.register') }}" class="btn-primary px-3 py-2">Buat Akun</a>
                    @endauth
                </div>

                <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-lg border border-emerald-100 bg-white text-slate-700 shadow-sm transition hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 lg:hidden" data-nav-toggle aria-controls="mobile-nav" aria-expanded="false">
                    <span class="sr-only">Buka menu navigasi</span>
                    <span class="flex w-5 flex-col gap-1.5" aria-hidden="true">
                        <span class="h-0.5 rounded-full bg-current transition" data-nav-line="top"></span>
                        <span class="h-0.5 rounded-full bg-current transition" data-nav-line="middle"></span>
                        <span class="h-0.5 rounded-full bg-current transition" data-nav-line="bottom"></span>
                    </span>
                </button>
            </div>

            <div id="mobile-nav" class="hidden pt-4 lg:hidden" data-mobile-nav>
                <div class="grid gap-2 rounded-lg border border-emerald-100 bg-white p-3 shadow-sm">
                    @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}" @class(['mobile-nav-item', 'mobile-nav-item-active'=> $item['active']]) @if ($item['active']) aria-current="page" @endif>
                        <span>{{ $item['label'] }}</span>
                        <span class="text-xs text-slate-400">Buka</span>
                    </a>
                    @endforeach

                    <div class="mt-2 grid gap-2 border-t border-slate-200 pt-3">
                        @auth
                            @if (auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item border-emerald-200 bg-emerald-700 text-white hover:bg-emerald-800 hover:text-white">
                                    <span>Dashboard Admin</span>
                                    <span class="text-xs text-white/70">Panel</span>
                                </a>
                            @else
                                <a href="{{ route('registrations.create') }}" class="mobile-nav-item border-emerald-200 bg-emerald-700 text-white hover:bg-emerald-800 hover:text-white">
                                    <span>Form Pendaftaran</span>
                                    <span class="text-xs text-white/70">Isi data</span>
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="mobile-nav-item w-full">
                                    <span>Keluar</span>
                                    <span class="text-xs text-slate-400">Logout</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="mobile-nav-item">
                                <span>Masuk</span>
                                <span class="text-xs text-slate-400">Login</span>
                            </a>
                            <a href="{{ route('account.register') }}" class="mobile-nav-item border-emerald-200 bg-emerald-700 text-white hover:bg-emerald-800 hover:text-white">
                                <span>Buat Akun</span>
                                <span class="text-xs text-white/70">Pendaftar</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="mx-auto min-h-[calc(100vh-150px)] max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        @if (session('registered'))
        <div class="mb-6 rounded-lg border border-sky-200 bg-sky-50 px-4 py-3 text-sm font-medium text-sky-800 shadow-sm">
            {{ session('registered') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-6 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm">
            <p class="font-semibold">Ada data yang perlu diperbaiki.</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-emerald-900 bg-slate-950">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-sm text-slate-300 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
            <p>PPDB SD Negeri Semayu - aplikasi pendaftaran peserta didik baru berbasis Laravel.</p>
            <p>Tahun ajaran {{ \App\Models\AdmissionSetting::current()->academic_year }}</p>
        </div>
    </footer>
</body>

</html>
