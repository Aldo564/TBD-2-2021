<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group_Synopsis extends Model
{
    use HasFactory;

    public function synopsis()
    {
      return $this->belongsTo(Synopsis::class);
    }

    public function group()
    {
      return $this->belongsTo(Group::class);
    }
}
