<?php

namespace App\Foundation\Config;

use Closure;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;

class ConfigurePanelTheme
{
    /**
     * @var array
     */
    protected array $theme = [
        'primary' => Color::Red,
        'gray'    => Color::Slate,
    ];

    protected array $icons = [
        'actions::modal.confirmation'                             => 'lucide-triangle-alert',
        'actions::delete-action.modal'                            => 'lucide-trash-2',
        'actions::delete-action'                                  => 'lucide-trash-2',
        'breadcrumbs.separator'                                   => 'lucide-minus',

        # FORM
        'forms::components.text-input.actions.hide-password'      => 'lucide-eye-off',
        'forms::components.text-input.actions.show-password'      => 'lucide-eye',
        'modal.close-button'                                      => 'lucide-x',
        'forms::components.repeater.actions.delete'               => 'lucide-trash-2',
        'forms::components.repeater.actions.reorder'              => 'lucide-arrow-up-down',

        # NOTIF
        'notifications::notification.danger'                      => 'lucide-circle-x',
        'notifications::notification.info'                        => 'lucide-info',
        'notifications::notification.success'                     => 'lucide-circle-check-big',
        'notifications::notification.warning'                     => 'lucide-circle-alert',

        # PANEL
        'panels::sidebar.collapse-button'                         => 'lucide-chevron-left',
        'panels::sidebar.expand-button'                           => 'lucide-chevron-right',
        'panels::sidebar.group.collapse-button'                   => 'lucide-chevron-down',
        'panels::theme-switcher.dark-button'                      => 'lucide-moon',
        'panels::theme-switcher.light-button'                     => 'lucide-sun',
        'panels::theme-switcher.system-button'                    => 'lucide-monitor-cog',
        'panels::topbar.open-database-notifications-button'       => 'lucide-bell-ring',
        'panels::user-menu.logout-button'                         => 'lucide-log-out',
        'panels::user-menu.profile-item'                          => 'lucide-user',
        'panels::widgets.account.logout-button'                   => 'lucide-log-out',
        'panels::widgets.filament-info.open-documentation-button' => 'lucide-book-text',
        'panels::widgets.filament-info.open-github-button'        => 'lucide-github',

        # TABLE
        'tables::actions.filter'                                  => 'lucide-filter',
        'tables::header-cell.sort-asc-button'                     => 'lucide-chevron-down',
        'tables::header-cell.sort-button'                         => 'lucide-arrow-up-down',
        'tables::header-cell.sort-desc-button'                    => 'lucide-chevron-up',
        'tables::search-field'                                    => 'lucide-search',
        'tables::actions.toggle-columns'                          => 'lucide-between-vertical-end',
        'pagination.next-button'                                  => 'lucide-chevron-right',
        'pagination.previous-button'                              => 'lucide-chevron-left',
    ];

    /**
     * @param  Panel   $panel
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Panel $panel, Closure $next) : mixed
    {
        $panel
            ->spa()
            ->topNavigation(true)
            ->icons($this->icons)
            ->colors($this->theme)
            ->viteTheme([
                'resources/theme/main.css',
            ])
            ->favicon(asset('images/rpm.png'))
            ->brandLogo(fn() => view('components.logo'))
            ->brandName('RPM Motor')
            ->maxContentWidth(MaxWidth::ScreenTwoExtraLarge);

        return $next($panel);
    }
}
