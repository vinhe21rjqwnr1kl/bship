<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CfDriverPercent extends Model
{
    use HasFactory;
    protected $table = 'cf_driver_percent';
	protected $fillable = [
		'driver_id', 
		'service_detail_id', 
		'percent',      
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}
