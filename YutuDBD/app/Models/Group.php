<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function group_synopsis()
    {
      return $this->hasMany(Group_Synopsis::class);
    }

    public function admin_user_group()
    {
      return $this->hasMany(Admin_User_Synopsis::class);
    }

    public function historial_user_synopsis()
    {
      return $this->hasMany(Historial_User_Synopsis::class);
    }

}
