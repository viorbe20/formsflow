<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationRequest extends Model
{
    protected $fillable = [
        'reference_code',
        'name',
        'email',
        'phone',
        'organization',
        'unit',
        'subject',
        'statement',
        'request_text',
        'status',
        'category',
        'priority',
    ];
}