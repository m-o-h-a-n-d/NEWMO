<?php

namespace App\Models;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autharization extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    
    public function admins()
    {
        return $this->hasMany(Admin::class, 'role_id');
    }
}
