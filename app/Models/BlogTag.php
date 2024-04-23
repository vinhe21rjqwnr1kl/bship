<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BlogTag extends Model
{
    use HasFactory;

    protected $table = 'blog_tags';
    protected $fillable = [
        'user_id',
        'title',
        'slug',
    ];

    /**
     * BlogTag belongs to Blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsToMany(Blog::class, 'blog_blog_tags', 'blog_tag_id', 'blog_id');
    }

    public function generateSlug($title){

        $slug = \Str::slug($title);
        return $slug;
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('Reading.date_time_format'));
    }
    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:.htaccess');
    }
    public function setSlugAttribute( $value ) {
        return $this->attributes['slug'] = $this->generateSlug($value);
    }
}
