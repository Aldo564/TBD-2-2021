<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function country() 
    {
        return $this->belongsTo(Country::class);
    }

    public function commune() 
    {
        return $this->hasMany(Commune::class);
    }
}
