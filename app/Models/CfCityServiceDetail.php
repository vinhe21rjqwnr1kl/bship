<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;
use Stevebauman\Purify\Facades\Purify;

class CfCityServiceDetail extends Model
{
    use HasFactory;
    
    protected $table = 'cf_city_service_detail';
    protected $fillable = [
        'service_detail_id',
        'city',
        'city_search_name',
        'agency_id',
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
