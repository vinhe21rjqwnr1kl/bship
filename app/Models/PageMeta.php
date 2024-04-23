<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageMeta extends Model
{
    use HasFactory;

    protected $table = 'page_metas';
    protected $fillable = [
        'page_id',
        'title',
        'value',
    ];

    /**
     * PageMeta belongs to Page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('Reading.date_time_format'));
    }

    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:.htaccess');
    }
}
