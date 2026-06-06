<?php

namespace App\Http\Controllers;

use App\Models\AdmissionSetting;
use App\Models\Applicant;
use App\Models\SchoolProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $setting = AdmissionSetting::current();

        return view('public.home', [
            'setting' => $setting,
            'totalApplicants' => Applicant::query()->count(),
            'verifiedApplicants' => Applicant::query()
                ->where('verification_status', Applicant::VERIFICATION_VERIFIED)
                ->count(),
            'acceptedApplicants' => Applicant::query()
                ->where('selection_status', Applicant::SELECTION_ACCEPTED)
                ->count(),
        ]);
    }

    public function create(): View
    {
        return view('public.register', [
            'setting' => AdmissionSetting::current(),
            'user' => request()->user(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $setting = AdmissionSetting::current();

        if (! $setting->registrationIsActive()) {
            return back()
                ->withInput()
                ->withErrors(['registration' => 'Pendaftaran PPDB sedang ditutup. Silakan cek jadwal pendaftaran.']);
        }

        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:120'],
            'nisn' => ['nullable', 'string', 'max:30'],
            'birth_place' => ['required', 'string', 'max:80'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', Rule::in(['L', 'P'])],
            'religion' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:1000'],
            'previous_school' => ['required', 'string', 'max:120'],
            'parent_name' => ['required', 'string', 'max:120'],
            'parent_phone' => ['required', 'string', 'max:30'],
            'parent_email' => ['nullable', 'email', 'max:120'],
            'birth_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'family_card' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'photo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'agreement' => ['accepted'],
        ]);

        $applicant = Applicant::query()->create([
            ...collect($validated)->except(['birth_certificate', 'family_card', 'photo', 'agreement'])->all(),
            'user_id' => $request->user()->id,
            'registration_number' => $this->generateRegistrationNumber(),
            'birth_certificate_path' => $request->file('birth_certificate')->store('documents/akta', 'public'),
            'family_card_path' => $request->file('family_card')->store('documents/kk', 'public'),
            'photo_path' => $request->file('photo')->store('documents/foto', 'public'),
        ]);

        return redirect()
            ->route('registrations.show', $applicant->registration_number)
            ->with('registered', 'Pendaftaran berhasil disimpan. Simpan nomor pendaftaran untuk mengecek status.');
    }

    public function show(Applicant $applicant): View
    {
        return view('public.receipt', [
            'applicant' => $applicant,
            'setting' => AdmissionSetting::current(),
            'profile' => SchoolProfile::current(),
        ]);
    }

    public function profile(): View
    {
        return view('public.profile', [
            'profile' => SchoolProfile::current(),
            'setting' => AdmissionSetting::current(),
        ]);
    }

    public function statusForm(): View
    {
        return view('public.status');
    }

    public function status(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'registration_number' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
        ]);

        $applicant = Applicant::query()
            ->where('registration_number', $validated['registration_number'])
            ->whereDate('birth_date', $validated['birth_date'])
            ->first();

        if (! $applicant) {
            return back()
                ->withInput()
                ->withErrors(['registration_number' => 'Data pendaftaran tidak ditemukan. Periksa kembali nomor pendaftaran dan tanggal lahir.']);
        }

        return redirect()
            ->route('registrations.show', $applicant->registration_number)
            ->with('status_checked', true);
    }

    public function announcement(): View
    {
        $setting = AdmissionSetting::current();

        return view('public.announcement', [
            'setting' => $setting,
            'acceptedApplicants' => Applicant::query()
                ->where('selection_status', Applicant::SELECTION_ACCEPTED)
                ->orderBy('student_name')
                ->get(),
            'reserveApplicants' => Applicant::query()
                ->where('selection_status', Applicant::SELECTION_RESERVE)
                ->orderBy('student_name')
                ->get(),
        ]);
    }

    private function generateRegistrationNumber(): string
    {
        $nextId = (int) Applicant::query()->max('id') + 1;

        do {
            $number = 'PPDB-'.now()->format('Y').'-'.str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
            $nextId++;
        } while (Applicant::query()->where('registration_number', $number)->exists());

        return $number;
    }
}
