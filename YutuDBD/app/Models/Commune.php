<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    public function Region() 
    {
        return $this->belongsTo(Region::class);
    }

    public function user() 
    {
        return $this->hasMany(User::class);
    }
}
