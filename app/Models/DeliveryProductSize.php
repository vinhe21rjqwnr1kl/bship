<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryProductSize extends Model
{
    use HasFactory;

    protected $table = 'delivery_product_size';
    protected $fillable = ['name', 'ratio', 'description', 'length', 'width', 'height', 'weight'];



}
