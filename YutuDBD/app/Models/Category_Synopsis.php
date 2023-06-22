<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Synopsis extends Model
{
    use HasFactory;

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function synopsis()
    {
      return $this->belongsTo(Synopsis::class);
    }
}
