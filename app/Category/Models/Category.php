<?php

namespace App\Category\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasUuids;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'parent_id', 'status',
    ];

    /**
     * @return HasMany|Category
     */
    public function child() : HasMany|Category
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }
}
