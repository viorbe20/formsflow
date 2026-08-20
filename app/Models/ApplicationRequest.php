<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationRequest extends Model
{
    use HasFactory;
    
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

    /**
    * Generate the application request reference code before creation.
    */
    protected static function booted(): void
    {
        static::creating(function (ApplicationRequest $applicationRequest) {
            $sequence = DB::selectOne(
                "SELECT nextval('application_request_reference_seq') AS value"
            )->value;

            $year = now()->format('Y');

            $applicationRequest->reference_code = sprintf(
                'FF-%s-%06d',
                $year,
                $sequence
            );
        });
    }
}