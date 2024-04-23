<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CFServicesSub extends Model
{
    use HasFactory;
    protected $table = 'cf_services_sub';
	protected $fillable = [
		'name', 
		'type', 
		'cost',      
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}
