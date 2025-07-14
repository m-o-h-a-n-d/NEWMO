<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Sluggable,  Searchable;
    protected $fillable = [
        'id',
        'title',
        'small_desc',
        'description',
        'slug',
        'comment_able',
        'admin_id',
        'status',
        'user_id',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'post_id', 'id');
    }

    public function views()
    {
        return $this->hasMany(NumberOfView::class, 'post_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
