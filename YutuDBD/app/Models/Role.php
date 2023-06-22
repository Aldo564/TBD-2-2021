<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    public function userRole() 
    {
        return $this->hasMany(User_role::class);
    }

    public function rolePermission() 
    {
        return $this->hasMany(Role_permission::class);
    }
}
