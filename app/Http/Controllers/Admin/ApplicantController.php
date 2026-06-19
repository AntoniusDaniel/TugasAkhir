<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSetting;
use App\Models\Applicant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicantController extends Controller
{
    public function index(Request $request): View
    {
        $verificationStatus = $request->string('verification_status')->toString();
        $selectionStatus = $request->string('selection_status')->toString();

        $applicants = Applicant::query()
            ->search($request->string('search')->toString())
            ->when(array_key_exists($verificationStatus, Applicant::verificationOptions()), function ($query) use ($verificationStatus): void {
                $query->where('verification_status', $verificationStatus);
            })
            ->when(array_key_exists($selectionStatus, Applicant::selectionOptions()), function ($query) use ($selectionStatus): void {
                $query->where('selection_status', $selectionStatus);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.applicants.index', [
            'applicants' => $applicants,
            'verificationOptions' => Applicant::verificationOptions(),
            'selectionOptions' => Applicant::selectionOptions(),
        ]);
    }

    public function show(Applicant $applicant): View
    {
        return view('admin.applicants.show', [
            'applicant' => $applicant,
            'setting' => AdmissionSetting::current(),
            'verificationOptions' => Applicant::verificationOptions(),
            'selectionOptions' => Applicant::selectionOptions(),
        ]);
    }

    public function updateVerification(Request $request, Applicant $applicant): RedirectResponse
    {
        $validated = $request->validate([
            'verification_status' => ['required', Rule::in(array_keys(Applicant::verificationOptions()))],
            'verification_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $updates = [
            'verification_status' => $validated['verification_status'],
            'verification_note' => $validated['verification_note'] ?? null,
            'verified_at' => $validated['verification_status'] === Applicant::VERIFICATION_VERIFIED ? now() : null,
        ];

        if ($validated['verification_status'] === Applicant::VERIFICATION_REJECTED) {
            $updates['selection_status'] = Applicant::SELECTION_REJECTED;
            $updates['selection_note'] = null;
            $updates['decided_at'] = now();
        }

        if ($validated['verification_status'] === Applicant::VERIFICATION_PENDING) {
            $updates['selection_status'] = Applicant::SELECTION_WAITING;
            $updates['selection_note'] = null;
            $updates['decided_at'] = null;
        }

        $applicant->update($updates);

        return back()->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function updateSelection(Request $request, Applicant $applicant): RedirectResponse
    {
        $validated = $request->validate([
            'selection_status' => ['required', Rule::in(array_keys(Applicant::selectionOptions()))],
            'selection_note' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($applicant->verification_status !== Applicant::VERIFICATION_VERIFIED && $validated['selection_status'] !== Applicant::SELECTION_REJECTED) {
            return back()->withErrors(['selection_status' => 'Pendaftar harus terverifikasi sebelum ditetapkan sebagai diterima atau cadangan.']);
        }

        $setting = AdmissionSetting::current();
        $targetStatus = $validated['selection_status'];

        if ($targetStatus === Applicant::SELECTION_ACCEPTED && $applicant->selection_status !== Applicant::SELECTION_ACCEPTED) {
            $acceptedCount = Applicant::query()
                ->where('selection_status', Applicant::SELECTION_ACCEPTED)
                ->count();

            if ($acceptedCount >= $setting->quota) {
                return back()->withErrors(['selection_status' => 'Kuota diterima sudah penuh. Gunakan status cadangan jika diperlukan.']);
            }
        }

        if ($targetStatus === Applicant::SELECTION_RESERVE && $applicant->selection_status !== Applicant::SELECTION_RESERVE) {
            $reserveCount = Applicant::query()
                ->where('selection_status', Applicant::SELECTION_RESERVE)
                ->count();

            if ($reserveCount >= $setting->reserve_quota) {
                return back()->withErrors(['selection_status' => 'Kuota cadangan sudah penuh.']);
            }
        }

        $selectionNote = trim((string) ($validated['selection_note'] ?? ''));

        $applicant->update([
            'selection_status' => $targetStatus,
            'selection_note' => $targetStatus === Applicant::SELECTION_REJECTED
                ? ($selectionNote !== '' ? $selectionNote : null)
                : null,
            'decided_at' => $targetStatus === Applicant::SELECTION_WAITING ? null : now(),
        ]);

        return back()->with('success', 'Hasil seleksi berhasil diperbarui.');
    }

    public function download(Applicant $applicant, string $document): mixed
    {
        $map = [
            'akta' => $applicant->birth_certificate_path,
            'kk' => $applicant->family_card_path,
            'foto' => $applicant->photo_path,
        ];

        $disk = Storage::disk('public');
        abort_unless(isset($map[$document]) && $disk->exists($map[$document]), 404);

        return response()->download($disk->path($map[$document]));
    }

    public function export(): StreamedResponse
    {
        $fileName = 'data-ppdb-semayu-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');

            fputcsv($output, [
                'Nomor Pendaftaran',
                'Nama Siswa',
                'NISN',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Jenis Kelamin',
                'Asal Sekolah',
                'Nama Orang Tua',
                'Telepon',
                'Email',
                'Status Verifikasi',
                'Hasil Seleksi',
                'Catatan Hasil Seleksi',
            ]);

            Applicant::query()->orderBy('student_name')->chunk(100, function ($applicants) use ($output): void {
                foreach ($applicants as $applicant) {
                    fputcsv($output, [
                        $applicant->registration_number,
                        $applicant->student_name,
                        $applicant->nisn,
                        $applicant->birth_place,
                        $applicant->birth_date?->format('Y-m-d'),
                        $applicant->genderLabel(),
                        $applicant->previous_school,
                        $applicant->parent_name,
                        $applicant->parent_phone,
                        $applicant->parent_email,
                        $applicant->verificationLabel(),
                        $applicant->selectionLabel(),
                        $applicant->selection_note,
                    ]);
                }
            });

            fclose($output);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
