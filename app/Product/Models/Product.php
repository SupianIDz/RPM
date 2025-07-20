<?php

namespace App\Product\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasUuids, HasSlug, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'stock', 'status', 'category_id', 'brand_id', 'unit_id',
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
}
