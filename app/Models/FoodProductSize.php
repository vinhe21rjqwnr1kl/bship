<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodProductSize extends Model
{
    use HasFactory;
    protected $table = 'food_product_sizes';
    protected $fillable = [];

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id', 'id');
    }

}
