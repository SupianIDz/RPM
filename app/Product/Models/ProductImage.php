<?php

namespace App\Product\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'code',
    ];
}
