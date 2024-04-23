<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_items';

    protected $fillable = [
        'parent_id',
        'menu_id',
        'item_id',
        'type',
        'title',
        'attribute',
        'link',
        'menu_target',
        'css_classes',
        'description',
        'order',
    ];

    /**
     * MenuItem belongs to Menu.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function child_menu_items()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')->orderBy('order', 'asc');
    }

    public function parent_menu_item()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id', 'id');
    }

    public function getCreatedAtAttribute( $value ) {
        return (new Carbon($value))->format(config('Reading.date_time_format'));
    }

    public function setCreatedAtAttribute( $value ) {
        $this->attributes['created_at'] = (new Carbon($value))->format('Y-m-d H:i:.htaccess');
    }
}
