<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial_User_Synopsis extends Model
{
    use HasFactory;

    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function synopsis()
    {
      return $this->belongsTo(Synopsis::class);
    }
}
