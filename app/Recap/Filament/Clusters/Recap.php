<?php

namespace App\Recap\Filament\Clusters;

use Filament\Clusters\Cluster;

class Recap extends Cluster
{
    /**
     * @var string|null
     */
    protected static ?string $slug = 'recaps';

    /**
     * @var string|null
     */
    protected static ?string $navigationIcon = 'lucide-pie-chart';

    /**
     * @var string|null
     */
    protected static ?string $navigationLabel = 'Recaps';

    /**
     * @var int|null
     */
    protected static ?int $navigationSort = 3;
}
