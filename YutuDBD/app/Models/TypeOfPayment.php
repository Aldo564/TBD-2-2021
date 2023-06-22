<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfPayment extends Model
{
    use HasFactory;

    public function paymethod()
    {
      return $this->hasMany(PayMethod::class);
    }
}
