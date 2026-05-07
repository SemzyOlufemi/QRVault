<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FileMedia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'uuid',
        'original_name',
        'storage_name',
        'disk',
        'path',
        'mime_type',
        'extension',
        'size_bytes',
        'type',
        'title',
        'description',
        'qr_code_path',
        'qr_code_url',
        'scan_count',
        'download_count',
        'is_public',
        'requires_password',
        'access_password',
        'expires_at',
        'metadata',
        'status',
    ];

    protected $hidden = [
        'access_password',
        'path',
        'storage_name',
    ];

    protected $casts = [
        'expires_at'        => 'datetime',
        'is_public'         => 'boolean',
        'requires_password' => 'boolean',
        'metadata'          => 'array',
    ];

    // auto-generate uuid when creating
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (FileMedia $model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at?->isPast() ?? false;
    }

    public function getSizeHumanAttribute(): string
    {
        $bytes = $this->size_bytes;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}