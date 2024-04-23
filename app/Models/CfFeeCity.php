<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class CfFeeCity extends Model
{
    use HasFactory;
    
    protected $table = 'cf_fee_city_ratio';
    protected $fillable = [
        'ratio',
        'service_detail_id',
        'city',
        'city_search_name',
    ];


    /**
     * Blog belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

  


}
