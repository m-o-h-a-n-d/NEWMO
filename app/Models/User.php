<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'phone',
        'status',
        'image',
        'country',
        'city',
        'street',
        'password',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }
    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
    public function views()
    {
        return $this->hasMany(NumberOfView::class, 'user_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('default-user.jpg');
        // ده Laravel بيفهم منه إنك بتعمل Accessor لحقل وهمي اسمه image_url، وده بيشتغل تلقائيًا لما تكتب:
        // $user->image_url
    }


    // customize the display of the user's id in channel
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

        ];
    }
}
