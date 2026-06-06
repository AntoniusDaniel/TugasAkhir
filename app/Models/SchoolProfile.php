<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'school_name',
        'tagline',
        'headmaster',
        'accreditation',
        'description',
        'vision',
        'mission',
        'address',
        'phone',
        'whatsapp',
        'email',
        'website',
        'map_url',
        'faq',
        'photo_path',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
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
            'website' => null,
            'map_url' => null,
            'faq' => implode("\n", [
                'Apa saja berkas yang perlu disiapkan?|Akta kelahiran, kartu keluarga, foto calon peserta didik, dan data asal sekolah/TK.',
                'Bagaimana cara mengecek status pendaftaran?|Gunakan nomor pendaftaran dan tanggal lahir pada halaman Cek Status.',
                'Kapan hasil seleksi diumumkan?|Hasil seleksi ditampilkan pada halaman Pengumuman setelah panitia mempublikasikannya.',
            ]),
        ]);
    }

    public function missionList(): array
    {
        return $this->lines($this->mission);
    }

    public function faqList(): array
    {
        return collect(explode("\n", (string) $this->faq))
            ->map(function (string $item): array {
                [$question, $answer] = array_pad(explode('|', $item, 2), 2, '');

                return [
                    'question' => trim($question),
                    'answer' => trim($answer),
                ];
            })
            ->filter(fn (array $item): bool => $item['question'] !== '' && $item['answer'] !== '')
            ->values()
            ->all();
    }

    private function lines(?string $value): array
    {
        return collect(explode("\n", (string) $value))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
