<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'restaurants';

    protected $fillable = [];
    public function food_product()
    {
        return $this->hasMany(FoodProduct::class); // Hoặc hasOne, depends on your relationship
    }
 
}