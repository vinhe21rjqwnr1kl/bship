<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageSeo extends Model
{
    use HasFactory;

    protected $table = 'page_seos';
    protected $fillable = [
        'page_id',
        'page_title',
        'meta_keywords',
        'meta_descriptions',
        'content_url',
    ];

    /**
     * PageSeo belongs to Page.
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
