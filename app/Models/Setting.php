<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'side_name',
        'logo',
        'favicon',
        'facebook',
        'instagram',
        'linkedin',
        'youtube',
        'twitter',
        'email',
        'street',
        'city',
        'country',
        'phone',
    ];

    


}
