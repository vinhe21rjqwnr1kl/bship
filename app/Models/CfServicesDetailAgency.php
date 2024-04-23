<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CfServicesDetailAgency extends Model
{
    use HasFactory;
    protected $table = 'cf_services_detail_agency';
	protected $fillable = [
		'service_detail_id',  
		'agency_id'	     
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}
