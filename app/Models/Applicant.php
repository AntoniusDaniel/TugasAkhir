<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applicant extends Model
{
    public const VERIFICATION_PENDING = 'pending';

    public const VERIFICATION_VERIFIED = 'verified';

    public const VERIFICATION_REJECTED = 'rejected';

    public const SELECTION_WAITING = 'waiting';

    public const SELECTION_ACCEPTED = 'accepted';

    public const SELECTION_RESERVE = 'reserve';

    public const SELECTION_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        'registration_number',
        'student_name',
        'nisn',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'address',
        'previous_school',
        'parent_name',
        'parent_phone',
        'parent_email',
        'birth_certificate_path',
        'family_card_path',
        'photo_path',
        'verification_status',
        'selection_status',
        'selection_note',
        'verification_note',
        'verified_at',
        'decided_at',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'verified_at' => 'datetime',
            'decided_at' => 'datetime',
        ];
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function (Builder $query, string $search): void {
            $query->where(function (Builder $query) use ($search): void {
                $query
                    ->where('registration_number', 'like', "%{$search}%")
                    ->orWhere('student_name', 'like', "%{$search}%")
                    ->orWhere('parent_name', 'like', "%{$search}%")
                    ->orWhere('previous_school', 'like', "%{$search}%");
            });
        });
    }

    public static function verificationOptions(): array
    {
        return [
            self::VERIFICATION_PENDING => 'Menunggu',
            self::VERIFICATION_VERIFIED => 'Terverifikasi',
            self::VERIFICATION_REJECTED => 'Ditolak',
        ];
    }

    public static function selectionOptions(): array
    {
        return [
            self::SELECTION_WAITING => 'Menunggu',
            self::SELECTION_ACCEPTED => 'Diterima',
            self::SELECTION_RESERVE => 'Cadangan',
            self::SELECTION_REJECTED => 'Tidak diterima',
        ];
    }

    public function verificationLabel(): string
    {
        return self::verificationOptions()[$this->verification_status] ?? $this->verification_status;
    }

    public function selectionLabel(): string
    {
        return self::selectionOptions()[$this->selection_status] ?? $this->selection_status;
    }

    public function genderLabel(): string
    {
        return $this->gender === 'L' ? 'Laki-laki' : 'Perempuan';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
