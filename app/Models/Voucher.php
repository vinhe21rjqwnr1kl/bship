<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 't_discount';
    protected $fillable = [
		'services_detail_id',
		'discount_code',
        'discount_type',
        'discount_value',
		'start_date',
		'end_time',
		'times_of_uses',
		'times_of_used',
		'title',
		'description',
		'image',
		'status',
		'create_date',
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}
