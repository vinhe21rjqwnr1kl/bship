<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    use HasFactory;

    protected $table = 'delivery_type';
    protected $fillable = ['name', 'status', 'ratio', 'service_detail_id'];

    public function cfServiceDetail(){
        return $this->belongsTo(CfServiceDetail::class, 'service_detail_id');
    }

}
