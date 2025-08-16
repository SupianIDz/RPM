<?php

namespace App\Unit\Models;

use App\Product\Models\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasUuids, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'symbol',
    ];

    /**
     * @return HasMany|Unit
     */
    public function products() : HasMany|Unit
    {
        return $this->hasMany(Product::class, 'unit_id');
    }
}
