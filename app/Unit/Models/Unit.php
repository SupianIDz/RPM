<?php

namespace App\Unit\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
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
}
