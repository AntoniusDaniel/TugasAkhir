<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionSetting extends Model
{
    protected $fillable = [
        'school_name',
        'academic_year',
        'quota',
        'reserve_quota',
        'registration_start',
        'registration_end',
        'is_registration_open',
        'is_announcement_published',
        'requirements',
    ];

    protected function casts(): array
    {
        return [
            'quota' => 'integer',
            'reserve_quota' => 'integer',
            'registration_start' => 'date',
            'registration_end' => 'date',
            'is_registration_open' => 'boolean',
            'is_announcement_published' => 'boolean',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'school_name' => 'SD Negeri Semayu',
            'academic_year' => '2026/2027',
            'quota' => 28,
            'reserve_quota' => 5,
            'registration_start' => '2026-06-02',
            'registration_end' => '2026-08-02',
            'is_registration_open' => true,
            'is_announcement_published' => false,
            'requirements' => implode("\n", [
                'Akta kelahiran calon peserta didik',
                'Kartu keluarga',
                'Foto calon peserta didik',
                'Nomor telepon orang tua/wali yang aktif',
            ]),
        ]);
    }

    public function registrationIsActive(): bool
    {
        if (! $this->is_registration_open) {
            return false;
        }

        $today = now()->toDateString();

        if ($this->registration_start && $today < $this->registration_start->toDateString()) {
            return false;
        }

        if ($this->registration_end && $today > $this->registration_end->toDateString()) {
            return false;
        }

        return true;
    }

    public function requirementList(): array
    {
        return collect(explode("\n", (string) $this->requirements))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
