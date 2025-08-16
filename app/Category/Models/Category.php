<?php

namespace App\Category\Models;

use App\Product\Models\Product;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use HasUuids, HasSlug, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'parent_id', 'status', 'created_by',
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
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return HasMany|Category
     */
    public function child() : HasMany|Category
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    /**
     * @return HasMany|Category
     */
    public function products() : HasMany|Category
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
