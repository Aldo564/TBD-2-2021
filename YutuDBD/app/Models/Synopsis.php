<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Synopsis extends Model
{
    use HasFactory;

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

    public function video()
    {
      return $this->belongsTo(Video::class);
    }

    public function group_video()
    {
      return $this->hasMany(Group_Synopsis::class);
    }

    public function category__synopsis()
    {
      return $this->hasMany(Category_Synopsis::class);
    }
}
