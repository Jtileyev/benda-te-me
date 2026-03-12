<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissingPersonRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_user_id',
        'full_name',
        'birth_date',
        'last_seen_place',
        'description',
        'contacts',
        'image_path',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}
