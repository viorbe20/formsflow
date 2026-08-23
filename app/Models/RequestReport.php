<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestReport extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'generated_at',
        'total_requests',
        'by_organization',
        'by_status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'generated_at' => 'datetime',
        'by_organization' => 'array',
        'by_status' => 'array',
    ];
}
