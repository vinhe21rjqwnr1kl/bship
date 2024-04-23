<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CfServicesOptionDetail extends Model
{
    use HasFactory;
    protected $table = 'cf_services_option_detail';
	protected $fillable = [
		'service_type',  
		'service_option',  
		'status',       
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}
