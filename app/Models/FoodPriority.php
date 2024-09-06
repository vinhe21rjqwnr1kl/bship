<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodPriority extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 't_food_priority';
    protected $fillable = [
        'product_id',
        'restaurant_id',
        'type', 
    ];

     // Thiết lập mối quan hệ với mô hình User
     public function food_product()
     {
         return $this->belongsTo(FoodProduct::class, 'product_id', 'id');
     }
 
     public function restaurant()
     {
         return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
     }
}