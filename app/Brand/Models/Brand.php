<?php

namespace App\Brand\Models;

use App\Brand\Observers\BrandObserver;
use App\Product\Models\Product;
use App\User\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use LaravelIdea\Helper\App\Brand\Models\_IH_Brand_QB;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[ObservedBy([BrandObserver::class])]
class Brand extends Model
{
    use HasUuids, HasSlug, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'logo', 'site', 'status', 'created_by',
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
     * @return Attribute
     */
    protected function logoUrl() : Attribute
    {
        return
            Attribute::get(function () {
                return Storage::disk('brand:logo')->url($this->logo);
            });
    }

    /**
     * @param  Builder $query
     * @param  bool    $status
     * @return Builder|_IH_Brand_QB
     */
    #[Scope]
    protected function active(Builder $query, bool $status = true) : Builder|_IH_Brand_QB
    {
        return $query->where('status', $status);
    }

    /**
     * @return HasMany|Brand
     */
    public function products() : HasMany|Brand
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    /**
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
