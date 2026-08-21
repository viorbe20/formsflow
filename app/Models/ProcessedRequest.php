<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessedRequest extends Model
{
    /**
     * The attributes that can be mass assigned.
     */
    protected $fillable = [
        'reference_code',
        'organization',
        'unit',
        'subject',
        'normalized_text',
        'status',
        'category',
        'priority',
        'source_created_at',
        'processed_at',
    ];
}