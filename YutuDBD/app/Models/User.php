<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function user_paymethod()
    {
        return $this->hasMany(User_PayMethod::class);
    }

    public function donate()
    {
        return $this->hasMany(Donate::class);
    }

    public function follow()
    {
        return $this->hasMany(Follow::class);
    }

    public function comment()
    {
      return $this->hasMany(Comment::class);
    }

    public function historial__user__synopsis()
    {
      return $this->hasMany(Historial_User_Synopsis::class);
    }

    public function like__user__synopsis()
    {
      return $this->hasMany(Like_User_Synopsis::class);
    }

}
