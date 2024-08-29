<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    use HasFactory;

    const BANNER_TYPE = [
        'Home' => 'Trang chủ',
        'MustVisitSpot' => 'Điểm hot nên đi',
    ];

    protected $table = 'banner';
    protected $fillable = [
        'title',
        'direct_url',
        'type',
        'url',
        'index',
        'status',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
