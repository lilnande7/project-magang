<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'visited_on',
        'session_id',
        'user_id',
        'path',
        'ip',
        'user_agent',
        'referer',
    ];

    protected $casts = [
        'visited_on' => 'date',
    ];
}
