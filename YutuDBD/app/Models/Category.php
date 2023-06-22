<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    public function category_synopsis()
    {
      return $this->hasMany(Category_Synopsis::class);
    }
}
