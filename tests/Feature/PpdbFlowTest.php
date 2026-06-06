<?php

namespace Tests\Feature;

use App\Models\AdmissionSetting;
use App\Models\Applicant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PpdbFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_homepage_shows_ppdb_portal(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Aplikasi Penerimaan Peserta Didik Baru')
            ->assertSee('SD Negeri Semayu');
    }

    public function test_guest_must_login_before_opening_registration_form(): void
    {
        $this->get(route('registrations.create'))
            ->assertRedirect(route('login'));
    }

    public function test_parent_can_create_account_before_registration(): void
    {
        $response = $this->post(route('account.store'), [
            'name' => 'Maria Lestari',
            'email' => 'maria@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertRedirect(route('registrations.create'))
            ->assertSessionHas('success');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'maria@example.com',
            'is_admin' => false,
        ]);
    }

    public function test_parent_can_submit_registration(): void
    {
        Storage::fake('public');
        AdmissionSetting::current();
        $parent = User::query()->create([
            'name' => 'Maria Lestari',
            'email' => 'maria@example.com',
            'password' => 'password',
            'is_admin' => false,
        ]);

        $response = $this->actingAs($parent)->post('/daftar', [
            'student_name' => 'Citra Lestari',
            'nisn' => '9876543210',
            'birth_place' => 'Gunungkidul',
            'birth_date' => '2019-02-10',
            'gender' => 'P',
            'religion' => 'Katolik',
            'address' => 'Semayu, Gunungkidul',
            'previous_school' => 'TK Melati',
            'parent_name' => 'Maria Lestari',
            'parent_phone' => '081111111111',
            'parent_email' => 'maria@example.com',
            'birth_certificate' => UploadedFile::fake()->create('akta.pdf', 100, 'application/pdf'),
            'family_card' => UploadedFile::fake()->create('kk.pdf', 100, 'application/pdf'),
            'photo' => UploadedFile::fake()->create('foto.jpg', 100, 'image/jpeg'),
            'agreement' => '1',
        ]);

        $applicant = Applicant::query()->firstOrFail();

        $response->assertRedirect(route('registrations.show', $applicant->registration_number));
        $this->assertDatabaseHas('applicants', [
            'user_id' => $parent->id,
            'student_name' => 'Citra Lestari',
            'verification_status' => Applicant::VERIFICATION_PENDING,
            'selection_status' => Applicant::SELECTION_WAITING,
        ]);
        Storage::disk('public')->assertExists($applicant->birth_certificate_path);
    }

    public function test_admin_can_verify_and_accept_applicant(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin PPDB',
            'email' => 'admin@example.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        AdmissionSetting::current()->update([
            'quota' => 1,
            'reserve_quota' => 1,
        ]);

        $applicant = Applicant::query()->create([
            'registration_number' => 'PPDB-2026-0100',
            'student_name' => 'Damar Wijaya',
            'birth_place' => 'Gunungkidul',
            'birth_date' => '2019-01-01',
            'gender' => 'L',
            'address' => 'Semayu',
            'previous_school' => 'TK Semayu',
            'parent_name' => 'Wahyu Wijaya',
            'parent_phone' => '082222222222',
            'birth_certificate_path' => 'documents/akta/akta.pdf',
            'family_card_path' => 'documents/kk/kk.pdf',
            'photo_path' => 'documents/foto/foto.jpg',
        ]);

        $this->actingAs($admin)
            ->patch(route('admin.applicants.verification', $applicant), [
                'verification_status' => Applicant::VERIFICATION_VERIFIED,
                'verification_note' => 'Berkas lengkap.',
            ])
            ->assertSessionHas('success');

        $this->actingAs($admin)
            ->patch(route('admin.applicants.selection', $applicant), [
                'selection_status' => Applicant::SELECTION_ACCEPTED,
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('applicants', [
            'registration_number' => 'PPDB-2026-0100',
            'verification_status' => Applicant::VERIFICATION_VERIFIED,
            'selection_status' => Applicant::SELECTION_ACCEPTED,
        ]);
    }

    public function test_admin_can_reject_applicant_with_selection_note(): void
    {
        $admin = User::query()->create([
            'name' => 'Admin PPDB',
            'email' => 'admin-note@example.com',
            'password' => 'password',
            'is_admin' => true,
        ]);

        $applicant = Applicant::query()->create([
            'registration_number' => 'PPDB-2026-0200',
            'student_name' => 'Raka Saputra',
            'birth_place' => 'Gunungkidul',
            'birth_date' => '2019-03-15',
            'gender' => 'L',
            'address' => 'Semayu',
            'previous_school' => 'TK Semayu',
            'parent_name' => 'Budi Saputra',
            'parent_phone' => '083333333333',
            'birth_certificate_path' => 'documents/akta/akta.pdf',
            'family_card_path' => 'documents/kk/kk.pdf',
            'photo_path' => 'documents/foto/foto.jpg',
        ]);

        $note = 'Silakan mencoba mendaftar ke sekolah lain yang masih membuka pendaftaran.';

        $this->actingAs($admin)
            ->patch(route('admin.applicants.selection', $applicant), [
                'selection_status' => Applicant::SELECTION_REJECTED,
                'selection_note' => $note,
            ])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('applicants', [
            'registration_number' => 'PPDB-2026-0200',
            'selection_status' => Applicant::SELECTION_REJECTED,
            'selection_note' => $note,
        ]);

        $this->get(route('registrations.show', $applicant->registration_number))
            ->assertOk()
            ->assertSee('Catatan hasil seleksi')
            ->assertSee($note);
    }
}
