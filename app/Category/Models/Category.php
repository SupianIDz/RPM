<?php

namespace App\Category\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasUuids, HasSlug;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'parent_id', 'status',
    ];

    /**
     * @return SlugOptions
     */
    public function getSlugOptions() : SlugOptions
    {
        return
            SlugOptions::create()
                ->generateSlugsFrom('name')
                ->saveSlugsTo('slug');
    }

    /**
     * @return HasMany|Category
     */
    public function child() : HasMany|Category
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
