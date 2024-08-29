<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashSaleDetail extends Model
{
    use HasFactory;

    protected $table = 't_flash_sale_detail';
    protected $fillable = [
        'type',
        'max_usage',
        'flash_sale_id',
        'discount_id',
        'number_user_usage',
        'status',
        'restaurant_id',
    ];

    public $timestamps = false;

    public function flashSale(): BelongsTo
    {
        return $this->belongsTo(FlashSale::class, 'flash_sale_id', 'id');
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'discount_id', 'id');
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
}
