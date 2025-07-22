<?php

namespace App\Foundation\Providers\Filament;

use App\Foundation\Config\ConfigurePanelTheme;
use Exception;
use Filament\Contracts\Plugin;
use Filament\FilamentManager;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Stringable;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Octopy\L3D\Domain;

class FilamentServiceProvider extends PanelProvider
{
    /**
     * @return void
     */
    public function boot() : void
    {
        Table::configureUsing(static function (Table $table) {
            $table::$defaultDateDisplayFormat = 'd M Y';
            $table::$defaultDateTimeDisplayFormat = 'd M Y  H:i'; // 29 Dec 2024 03:56

            $table
                ->striped()
                ->defaultSort('created_at', 'DESC');
        });

        TextColumn::macro('upper', function (bool $uppercase = true) : TextColumn {
            if ($uppercase) {
                $this->formatStateUsing(function ($state) {
                    return strtoupper($state);
                });
            }

            return $this;
        });

        TextColumn::macro('rupiah', function () : TextColumn {
            $this->formatStateUsing(function ($state) {
                return str($state)->rupiah();
            });

            return $this;
        });

        Stringable::macro('rupiah', function () {
            return number($this->value)->currency('Rp ');
        });
    }

    /**
     * @param  Panel $panel
     * @return Panel
     * @throws Exception
     */
    public function panel(Panel $panel) : Panel
    {
        $panel
            ->default()
            ->id('app')
            ->path('panel')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugins([
                new \Octopy\Filament\Palette\PaletteSwitcherPlugin,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ], isPersistent: true);

        pipeline($panel, [
            ConfigurePanelTheme::class,
        ])
            ->then(function (Panel $panel) {
                $this->registerFilamentFromDomains($panel);
            });

        return $panel;
    }

    /**
     * @throws BindingResolutionException
     */
    private function registerFilamentFromDomains(Panel $panel) : void
    {
        $domains = collect(l3d()->domains())->filter(function (Domain $domain) {
            return str_contains($domain->namespace, 'App\\');
        });

        $managers = [];
        $domains->each(function (Domain $domain) use (&$managers) {
            $manager = $domain->namespace(FilamentManager::class);

            if (class_exists($manager) && is_subclass_of($manager, Plugin::class)) {
                $managers[] = new $manager;
            }
        });

        $panel->plugins($managers);
    }
}
