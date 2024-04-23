<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BlogSeo extends Model
{
    use HasFactory;

    protected $table = 'blog_seos';
    protected $fillable = [
        'blog_id',
        'page_title',
        'meta_keywords',
        'meta_descriptions',
        'blog_url',
    ];

    /**
     * BlogSeo belongs to Blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }

    /**
     * BlogSeo belongs to Blog_tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog_tag()
    {
        return $this->belongsTo(BlogTag::class, 'blog_tag_id', 'id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('Reading.date_time_format'));
    }

    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:.htaccess');
    }
}
