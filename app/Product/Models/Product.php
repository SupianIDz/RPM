<?php

namespace App\Product\Models;

use App\Brand\Models\Brand;
use App\Category\Models\Category;
use App\Product\Enums\Type;
use App\Product\Observers\ProductObserver;
use App\Unit\Models\Unit;
use App\User\Models\User;
use Database\Factories\ProductFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[UseFactory(ProductFactory::class)]
#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasUuids, HasFactory, HasSlug, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'description', 'type', 'price', 'stock', 'category_id', 'brand_id', 'unit_id', 'created_by',
    ];

    /**
     * @return \class-string[]
     */
    protected function casts() : array
    {
        return [
            'type' => Type::class,
        ];
    }

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
     * @param  Builder $builder
     * @param  bool    $status
     * @return Builder
     */
    #[Scope]
    protected function active(Builder $builder, bool $status = true) : Builder
    {
        if ($status) {
            return $builder->withoutTrashed();
        }

        return $builder->onlyTrashed();
    }

    /**
     * @return HasOne|Product
     */
    public function image() : Product|HasOne
    {
        return $this->hasOne(ProductImage::class, 'code', 'code');
    }

    /**
     * @return HasMany
     */
    public function images() : HasMany
    {
        return $this->hasMany(ProductImage::class, 'code', 'code');
    }

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return BelongsTo
     */
    public function unit() : BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * @return HasOne|Product
     */
    public function price() : HasOne|Product
    {
        return $this->hasOne(ProductPrice::class, 'code', 'code');
    }

    /**
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
