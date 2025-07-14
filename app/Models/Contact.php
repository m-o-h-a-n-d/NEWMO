<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'title',
        'body',
        'ip_address',
        'status',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'name' => $this->name,
            
        ];
    }
}
