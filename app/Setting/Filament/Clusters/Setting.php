<?php

namespace App\Setting\Filament\Clusters;

use Filament\Clusters\Cluster;

class Setting extends Cluster
{
    /**
     * @var string|null
     */
    protected static ?string $slug = 'settings';

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'lucide-settings';

    /**
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Settings';

    /**
     * @var int|null
     */
    protected static ?int $navigationSort = 5;
}
