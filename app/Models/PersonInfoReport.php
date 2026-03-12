<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonInfoReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_user_id',
        'target_person_name',
        'message',
        'contacts',
        'image_path',
        'status',
    ];
}
