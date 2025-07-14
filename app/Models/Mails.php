<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    use HasFactory;
    protected $table = 'mails';
    protected $fillable = ['title', 'admin_id','status','role_id'];

   public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
