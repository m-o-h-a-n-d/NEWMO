<?php

namespace App\Models;

use App\Models\Autharization;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, Searchable;
    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'password',
        'image',
        'role_id',
        'status',

    ];
    // protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',

    ];
    public function posts()
    {
        return $this->hasMany(Post::class, 'admin_id', 'id');
    }
    public function mails()
    {
        return $this->hasMany(Mails::class, 'admin_id', 'id');
    }
    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('default-user.jpg');
        // ده Laravel بيفهم منه إنك بتعمل Accessor لحقل وهمي اسمه image_url، وده بيشتغل تلقائيًا لما تكتب:
        // $user->image_url
    }

    public function authorization()
    {
        return $this->belongsTo(Autharization::class, 'role_id');
    }

    public function hasPermission($config_permission)
    {
        $authorization = $this->authorization;

        if (!$authorization || !is_array($authorization->permissions)) {
            return false;
        }

        return in_array($config_permission, $authorization->permissions);
    }

    // customize the display of the user's id in channel
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'admins.' . $this->id;
    }
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

        ];
    }
}
