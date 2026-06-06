<?php

namespace Database\Seeders;

use App\Models\AdmissionSetting;
use App\Models\Applicant;
use App\Models\SchoolProfile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@sdnsemayu.sch.id'],
            [
                'name' => 'Admin PPDB',
                'password' => 'password',
                'is_admin' => true,
            ],
        );

        $parentDemo = User::query()->updateOrCreate(
            ['email' => 'orangtua@example.com'],
            [
                'name' => 'Daniel Prasetyo',
                'password' => 'password',
                'is_admin' => false,
            ],
        );

        AdmissionSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'school_name' => 'SD Negeri Semayu',
                'academic_year' => '2026/2027',
                'quota' => 28,
                'reserve_quota' => 5,
                'registration_start' => '2026-06-02',
                'registration_end' => '2026-08-02',
                'is_registration_open' => true,
                'is_announcement_published' => true,
                'requirements' => implode("\n", [
                    'Akta kelahiran calon peserta didik',
                    'Kartu keluarga',
                    'Foto calon peserta didik',
                    'Data asal sekolah/TK',
                    'Nomor telepon orang tua/wali yang aktif',
                ]),
            ],
        );

        SchoolProfile::query()->updateOrCreate(
            ['id' => 1],
            [
                'school_name' => 'SD Negeri Semayu',
                'tagline' => 'Sekolah dasar yang ramah, tertib, dan dekat dengan masyarakat.',
                'headmaster' => 'Kepala SD Negeri Semayu',
                'accreditation' => 'Terakreditasi',
                'description' => 'SD Negeri Semayu merupakan lembaga pendidikan dasar yang melayani pembelajaran dan administrasi peserta didik di wilayah Semayu. Portal PPDB ini disiapkan untuk mempermudah orang tua dalam melakukan pendaftaran peserta didik baru secara online.',
                'vision' => 'Terwujudnya peserta didik yang berkarakter, berprestasi, mandiri, dan peduli lingkungan.',
                'mission' => implode("\n", [
                    'Menyelenggarakan pembelajaran yang aktif, tertib, dan menyenangkan.',
                    'Menguatkan karakter peserta didik melalui pembiasaan positif.',
                    'Meningkatkan kualitas layanan administrasi sekolah berbasis teknologi.',
                    'Membangun komunikasi yang baik antara sekolah, peserta didik, dan orang tua.',
                ]),
                'address' => 'Semayu, Gunungkidul, Daerah Istimewa Yogyakarta',
                'phone' => '0274-000000',
                'whatsapp' => '081234567890',
                'email' => 'ppdb@sdnsemayu.sch.id',
                'faq' => implode("\n", [
                    'Apa saja berkas yang perlu disiapkan?|Akta kelahiran, kartu keluarga, foto calon peserta didik, dan data asal sekolah/TK.',
                    'Bagaimana cara mengecek status pendaftaran?|Gunakan nomor pendaftaran dan tanggal lahir pada halaman Cek Status.',
                    'Kapan hasil seleksi diumumkan?|Hasil seleksi ditampilkan pada halaman Pengumuman setelah panitia mempublikasikannya.',
                ]),
            ],
        );

        Applicant::query()->updateOrCreate(
            ['registration_number' => 'PPDB-2026-0001'],
            [
                'user_id' => $parentDemo->id,
                'student_name' => 'Bima Pratama',
                'nisn' => '1234567890',
                'birth_place' => 'Gunungkidul',
                'birth_date' => '2019-05-12',
                'gender' => 'L',
                'religion' => 'Kristen',
                'address' => 'Semayu, Gunungkidul',
                'previous_school' => 'TK Pertiwi Semayu',
                'parent_name' => 'Daniel Prasetyo',
                'parent_phone' => '081234567890',
                'parent_email' => 'orangtua@example.com',
                'birth_certificate_path' => 'sample/akta.pdf',
                'family_card_path' => 'sample/kk.pdf',
                'photo_path' => 'sample/foto.jpg',
                'verification_status' => Applicant::VERIFICATION_VERIFIED,
                'selection_status' => Applicant::SELECTION_ACCEPTED,
                'verification_note' => 'Data contoh untuk demo sistem.',
                'verified_at' => now(),
                'decided_at' => now(),
            ],
        );
    }
}
