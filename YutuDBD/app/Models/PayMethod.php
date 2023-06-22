<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    use HasFactory;

    public function bank()
    {
      return $this->belongsTo(Bank::class);
    }

    public function typeofpayment()
    {
      return $this->belongsTo(TypeOfPayment::class);
    }
}
