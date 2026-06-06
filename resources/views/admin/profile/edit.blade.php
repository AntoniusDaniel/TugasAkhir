@extends('layouts.app')

@section('title', 'Edit Profil Sekolah')

@section('content')
    <div class="mx-auto max-w-5xl">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="section-kicker">Admin</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-950">Profil Sekolah</h1>
                <p class="mt-2 text-sm text-slate-600">Kelola identitas sekolah, kontak panitia, FAQ, dan foto sekolah yang tampil di halaman publik.</p>
            </div>
            <a href="{{ route('school.profile') }}" class="btn-secondary">Lihat Halaman Publik</a>
        </div>

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <section class="form-card">
                <h2 class="text-lg font-semibold text-slate-950">Identitas Sekolah</h2>
                <div class="mt-5 grid gap-5 xl:grid-cols-2">
                    <div>
                        <label for="school_name" class="form-label">Nama sekolah</label>
                        <input id="school_name" name="school_name" value="{{ old('school_name', $profile->school_name) }}" required class="form-control">
                        <x-input-error :messages="$errors->get('school_name')" />
                    </div>
                    <div>
                        <label for="tagline" class="form-label">Tagline</label>
                        <input id="tagline" name="tagline" value="{{ old('tagline', $profile->tagline) }}" class="form-control">
                        <x-input-error :messages="$errors->get('tagline')" />
                    </div>
                    <div>
                        <label for="headmaster" class="form-label">Kepala sekolah</label>
                        <input id="headmaster" name="headmaster" value="{{ old('headmaster', $profile->headmaster) }}" class="form-control">
                        <x-input-error :messages="$errors->get('headmaster')" />
                    </div>
                    <div>
                        <label for="accreditation" class="form-label">Akreditasi</label>
                        <input id="accreditation" name="accreditation" value="{{ old('accreditation', $profile->accreditation) }}" class="form-control">
                        <x-input-error :messages="$errors->get('accreditation')" />
                    </div>
                    <div class="xl:col-span-2">
                        <label for="description" class="form-label">Deskripsi sekolah</label>
                        <textarea id="description" name="description" rows="5" class="form-control">{{ old('description', $profile->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" />
                    </div>
                </div>
            </section>

            <section class="form-card">
                <h2 class="text-lg font-semibold text-slate-950">Visi, Misi, dan FAQ</h2>
                <div class="mt-5 grid gap-5">
                    <div>
                        <label for="vision" class="form-label">Visi</label>
                        <textarea id="vision" name="vision" rows="3" class="form-control">{{ old('vision', $profile->vision) }}</textarea>
                        <x-input-error :messages="$errors->get('vision')" />
                    </div>
                    <div>
                        <label for="mission" class="form-label">Misi</label>
                        <textarea id="mission" name="mission" rows="5" class="form-control">{{ old('mission', $profile->mission) }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">Tulis satu misi per baris.</p>
                        <x-input-error :messages="$errors->get('mission')" />
                    </div>
                    <div>
                        <label for="faq" class="form-label">FAQ</label>
                        <textarea id="faq" name="faq" rows="5" class="form-control">{{ old('faq', $profile->faq) }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">Format: Pertanyaan|Jawaban, satu FAQ per baris.</p>
                        <x-input-error :messages="$errors->get('faq')" />
                    </div>
                </div>
            </section>

            <section class="form-card">
                <h2 class="text-lg font-semibold text-slate-950">Kontak dan Gambar</h2>
                <div class="mt-5 grid gap-5 xl:grid-cols-2">
                    <div>
                        <label for="address" class="form-label">Alamat</label>
                        <textarea id="address" name="address" rows="3" class="form-control">{{ old('address', $profile->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>
                    <div>
                        <label for="map_url" class="form-label">Link Google Maps</label>
                        <input id="map_url" name="map_url" value="{{ old('map_url', $profile->map_url) }}" class="form-control" placeholder="https://maps.google.com/...">
                        <x-input-error :messages="$errors->get('map_url')" />
                    </div>
                    <div>
                        <label for="phone" class="form-label">Telepon</label>
                        <input id="phone" name="phone" value="{{ old('phone', $profile->phone) }}" class="form-control">
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>
                    <div>
                        <label for="whatsapp" class="form-label">WhatsApp</label>
                        <input id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp) }}" class="form-control">
                        <x-input-error :messages="$errors->get('whatsapp')" />
                    </div>
                    <div>
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $profile->email) }}" class="form-control">
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div>
                        <label for="website" class="form-label">Website</label>
                        <input id="website" name="website" value="{{ old('website', $profile->website) }}" class="form-control" placeholder="https://...">
                        <x-input-error :messages="$errors->get('website')" />
                    </div>
                    <div class="xl:col-span-2">
                        <label for="photo" class="form-label">Foto sekolah</label>
                        <input id="photo" type="file" name="photo" class="form-file">
                        <p class="mt-1 text-xs text-slate-500">Format JPG, PNG, atau WebP. Maksimal 4 MB.</p>
                        <x-input-error :messages="$errors->get('photo')" />
                    </div>
                </div>

                @if ($profile->photo_path)
                    <div class="mt-5 overflow-hidden rounded-lg border border-slate-200">
                        <img src="{{ Storage::disk('public')->url($profile->photo_path) }}" alt="Foto {{ $profile->school_name }}" class="h-56 w-full object-cover">
                    </div>
                @endif
            </section>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Kembali</a>
                <button type="submit" class="btn-primary">Simpan Profil Sekolah</button>
            </div>
        </form>
    </div>
@endsection
