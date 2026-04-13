<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    public const STATUS_MASUK = 'masuk';
    public const STATUS_DIPROSES = 'diproses';
    public const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'ip',
        'user_agent',
        'admin_id',
        'processed_at',
        'completed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_MASUK,
            self::STATUS_DIPROSES,
            self::STATUS_SELESAI,
        ];
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
