<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TRatings extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'ratings';
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'stars',
        'created_at',
        'updated_at',
        'comment',
        'status',
        'images',  
    ];
    // Thiết lập mối quan hệ với mô hình User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }



}