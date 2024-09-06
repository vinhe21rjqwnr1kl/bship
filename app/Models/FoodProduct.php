<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodProduct extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'food_products';
    protected $fillable = [];
    // Quan hệ một-nhiều với FoodProduct
  
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}