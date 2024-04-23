<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VoucherCondition extends Model
{
    use HasFactory;
    protected $table = 't_discount_condition_join';
    protected $fillable = [
		'services_detail_id',
		'discount_id',
        'user_taget_type',
        'user_data_id',
		'city_name',
		'number_of_uses',
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}
