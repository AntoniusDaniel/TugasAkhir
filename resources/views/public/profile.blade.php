@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
<section class="overflow-hidden rounded-lg border border-emerald-100 bg-white shadow-sm shadow-emerald-100/70">
    <div class="grid lg:grid-cols-[minmax(0,1fr)_minmax(340px,0.82fr)]">
        <div class="bg-[linear-gradient(135deg,#064e3b_0%,#0f172a_62%,#075985_100%)] p-6 text-white sm:p-8 lg:p-10">
            <p class="text-xs font-bold uppercase tracking-wide text-emerald-200">Profil sekolah</p>
            <h1 class="mt-3 max-w-2xl text-3xl font-bold leading-tight sm:text-4xl">{{ $profile->school_name }}</h1>

            @if ($profile->address)
            <div class="mt-4 max-w-2xl rounded-lg border border-white/15 bg-white/10 px-4 py-3 shadow-sm backdrop-blur">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-200">Lokasi sekolah</p>
                <p class="mt-1 text-sm leading-6 text-white">{{ $profile->address }}</p>
                @if ($profile->map_url)
                <a href="{{ $profile->map_url }}" target="_blank" rel="noopener" class="mt-2 inline-flex text-sm font-semibold text-emerald-100 hover:text-white">
                    Buka lokasi sekolah
                </a>
                @endif
            </div>
            @endif

            <p class="mt-5 max-w-2xl text-base leading-7 text-emerald-50/90">{{ $profile->tagline }}</p>

            <dl class="mt-7 grid gap-3 sm:grid-cols-2">
                <div class="rounded-lg border border-white/15 bg-white/10 p-4">
                    <dt class="text-xs uppercase tracking-wide text-emerald-100">Kepala sekolah</dt>
                    <dd class="mt-1 font-semibold text-white">{{ $profile->headmaster ?: '-' }}</dd>
                </div>
                <div class="rounded-lg border border-white/15 bg-white/10 p-4">
                    <dt class="text-xs uppercase tracking-wide text-emerald-100">Akreditasi</dt>
                    <dd class="mt-1 font-semibold text-white">{{ $profile->accreditation ?: '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-[linear-gradient(135deg,#ecfdf5_0%,#eff6ff_58%,#ffffff_100%)] p-4 sm:p-6">
            @if ($profile->photo_path)
            <img src="{{ Storage::disk('public')->url($profile->photo_path) }}" alt="Foto {{ $profile->school_name }}" class="h-full min-h-88 w-full rounded-lg object-cover shadow-sm">
            @else
            <div class="flex h-full min-h-88 items-center justify-center rounded-lg border border-dashed border-emerald-200 bg-white/75 p-8 text-center">
                <div>
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-lg bg-emerald-700 text-2xl font-bold text-white shadow-sm">SD</div>
                    <p class="mt-4 text-sm font-semibold text-slate-800">Foto sekolah belum diunggah</p>
                    <p class="mt-1 max-w-xs text-sm leading-6 text-slate-500">Admin dapat mengunggah foto melalui panel profil sekolah.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<section class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,1fr)_minmax(300px,0.42fr)]">
    <div class="space-y-6">
        <article class="surface p-5 sm:p-6">
            <p class="section-kicker">Tentang sekolah</p>
            <h2 class="mt-1 text-xl font-semibold text-slate-950">Lingkungan belajar yang dekat dengan masyarakat</h2>
            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $profile->description }}</p>
        </article>

        <div class="grid gap-6 md:grid-cols-2">
            <article class="rounded-lg border border-emerald-100 bg-emerald-50 p-5 shadow-sm sm:p-6">
                <p class="section-kicker">Visi</p>
                <p class="mt-3 text-sm leading-7 text-emerald-950">{{ $profile->vision }}</p>
            </article>

            <article class="surface p-5 sm:p-6">
                <p class="section-kicker">Misi</p>
                <div class="mt-4 grid gap-3">
                    @foreach ($profile->missionList() as $mission)
                    <div class="flex gap-3 rounded-lg border border-slate-200 bg-slate-50/80 p-3 text-sm leading-6 text-slate-700">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md bg-emerald-700 text-xs font-bold text-white">{{ $loop->iteration }}</span>
                        <span>{{ $mission }}</span>
                    </div>
                    @endforeach
                </div>
            </article>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="rounded-lg border border-sky-100 bg-[linear-gradient(180deg,#f0f9ff_0%,#ffffff_100%)] p-5 shadow-sm sm:p-6">
            <p class="text-xs font-bold uppercase tracking-wide text-sky-700">Kontak panitia</p>
            <h2 class="mt-1 text-lg font-semibold text-slate-950">Informasi PPDB</h2>

            <div class="mt-4 space-y-3 text-sm">
                <div class="rounded-lg border border-sky-100 bg-white/85 p-3">
                    <p class="text-slate-500">Telepon</p>
                    <p class="mt-1 wrap-break-words font-semibold text-slate-950">{{ $profile->phone ?: '-' }}</p>
                </div>
                <div class="rounded-lg border border-sky-100 bg-white/85 p-3">
                    <p class="text-slate-500">WhatsApp</p>
                    <p class="mt-1 wrap-break-words font-semibold text-slate-950">{{ $profile->whatsapp ?: '-' }}</p>
                </div>
                <div class="rounded-lg border border-sky-100 bg-white/85 p-3">
                    <p class="text-slate-500">Email</p>
                    <p class="mt-1 wrap-break-words font-semibold text-slate-950">{{ $profile->email ?: '-' }}</p>
                </div>
            </div>

            @if ($profile->website)
            <a href="{{ $profile->website }}" target="_blank" rel="noopener" class="btn-secondary mt-4 w-full">Kunjungi Website Sekolah</a>
            @endif
        </div>

        <div class="rounded-lg border border-amber-100 bg-[linear-gradient(180deg,#fffbeb_0%,#ffffff_100%)] p-5 shadow-sm sm:p-6">
            <p class="text-xs font-bold uppercase tracking-wide text-amber-700">FAQ PPDB</p>
            <h2 class="mt-1 text-lg font-semibold text-slate-950">Pertanyaan umum</h2>
            <div class="mt-4 space-y-3">
                @foreach ($profile->faqList() as $faq)
                <details class="rounded-lg border border-amber-100 bg-white/85 p-4">
                    <summary class="cursor-pointer text-sm font-semibold text-slate-950">{{ $faq['question'] }}</summary>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $faq['answer'] }}</p>
                </details>
                @endforeach
            </div>
        </div>
    </aside>
</section>
@endsection