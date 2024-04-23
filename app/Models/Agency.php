<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agency extends Model
{
    use HasFactory;
    protected $table = 'agency';
    protected $fillable = [
		'name',
		'phone',
        'email',
        'address',
        'info'
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}
 
}
