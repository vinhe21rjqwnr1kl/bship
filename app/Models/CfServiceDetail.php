<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class CfServiceDetail extends Model
{
    use HasFactory;
    protected $table = 'cf_services_detail';
	protected $fillable = [
		'status',
		'whole_km'
	];

	public function users()
	{
	    return $this->belongsToMany(User::class, 'model_has_roles', 'model_id', 'role_id');
	}

    public function service() : BelongsTo {
        return $this->belongsTo(CfServiceMain::class, 'service_id', 'id');
    }

    public function serviceType() : BelongsTo {
        return $this->belongsTo(CfServiceType::class, 'service_type', 'id');
    }

}
