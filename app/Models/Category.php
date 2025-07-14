<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'status',

    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
    public function scopeCategory_Active($query)
    {
        return $query->where('status', 1);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

        ];
    }
}
