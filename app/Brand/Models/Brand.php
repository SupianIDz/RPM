<?php

namespace App\Brand\Models;

use App\User\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Brand extends Model
{
    use HasUuids, HasSlug, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'logo', 'site', 'created_by',
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
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
