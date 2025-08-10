<?php

namespace App\Product\Filament\Resources;

use App\Product\Filament\Resources\ProductResource\Pages;
use App\Product\Models\Product;
use Filament\Resources\Resource;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $slug = 'products';

    protected static ?string $navigationIcon = 'lucide-package';

    protected static ?int $navigationSort = 3;

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
        ];
    }
}
