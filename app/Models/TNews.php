<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TNews extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 't_news';
    protected $fillable = [
        'find_index',
        'image',
        'news_url',
        'title',
        'status',
    ];



}
