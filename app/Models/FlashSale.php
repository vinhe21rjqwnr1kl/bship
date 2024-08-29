<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
enum FlashSaleType : string
{
    case Discount = 'Discount';
    case Restaurant = 'Restaurant';
    case GiveDiscount = 'GiveDiscount';
    case GoldenHours = 'GoldenHours';
}

class FlashSale extends Model
{
    use HasFactory;

    const FLASH_SALE_TYPE = [
        'Discount' => 'Bship ưu đãi',
        'GiveDiscount' => 'Bship tặng bạn',
//        'Restaurant' => 'Quán ngon gần bạn',
    ];

    protected $table = 't_flash_sale';
    protected $fillable = [
        'title',
        'type',
        'status',
        'banner',
        'start_date',
        'end_date',
        'create_date',
    ];

    protected $dates = ['start_date', 'end_date', 'create_date'];

    public $timestamps = false;

    public function flashSaleDetails() : HasMany {
        return $this->hasMany(FlashSaleDetail::class, 'flash_sale_id', 'id');
    }
}
