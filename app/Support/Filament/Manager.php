<?php

namespace App\Support\Filament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Manager implements Plugin
{
    /**
     * @return string
     */
    public function getId() : string
    {
        return str(static::class)->replace('\\', '-')->beforeLast('-')->beforeLast('-')->lower()->remove('panel')->deduplicate('-');
    }

    /**
     * @throws BindingResolutionException
     */
    public function register(Panel $panel) : void
    {
        $this->discover($panel);
    }

    /**
     * @param  Panel $panel
     * @return void
     */
    public function boot(Panel $panel) : void
    {
        // TODO: Implement boot() method.
    }

    /**
     * @param  Panel $panel
     * @return $this
     * @throws BindingResolutionException
     */
    public function discover(Panel $panel) : static
    {
        $domain = l3d()->domain(str(static::class)->before('\Filament'));

        // Automatically discover and register Filament components
        // based on predefined folder structure and namespaces
        $panel
            ->discoverPages($domain->basepath('Filament/Pages'), $domain->namespace('Filament\Pages'))
            ->discoverWidgets($domain->basepath('Filament/Widgets'), $domain->namespace('Filament\Widgets'))
            ->discoverClusters($domain->basepath('Filament/Clusters'), $domain->namespace('Filament\Clusters'))
            ->discoverResources($domain->basepath('Filament/Resources'), $domain->namespace('Filament\Resources'))
            ->discoverLivewireComponents($domain->basepath('Filament/Livewire'), $domain->namespace('Filament/Livewire'));

        // Get all widget folders within Resources directory
        // to register additional widgets located in Resources subfolders
        $widgets =
            $this->getWidgetFolders(
                $domain->basepath('Filament/Resources'),
                $domain->namespace('Filament\Resources'),
            );

        foreach ($widgets as $folderPath => $namespace) {
            $panel->discoverWidgets($folderPath, $namespace);
        }

        return $this;
    }

    /**
     * @param  string $basepath
     * @param  string $namespace
     * @return array
     */
    private function getWidgetFolders(string $basepath, string $namespace) : array
    {
        $map = [];

        $folders = File::glob($basepath . '/*/Widgets') ?? [];
        foreach ($folders as $path) {
            $map[$path] = $namespace . '\\' . str_replace(['/', '\\'], ['\\', '\\'], Str::after($path, $basepath . DIRECTORY_SEPARATOR));
        }

        return $map;
    }
}
