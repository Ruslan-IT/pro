<?php

namespace App\Providers\Filament;

use App\Filament\Resources\AboutCompanyBlockResource;
use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\DrawingResource;
use App\Filament\Resources\NewsResource;
use App\Filament\Resources\PortfolioResource;
use App\Filament\Resources\UserResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->passwordReset()
            ->brandLogo('/img/logo_ffter.png')
            ->brandLogoHeight('40px')

            ->navigationGroups([
                NavigationGroup::make('Контент')
                    ->collapsed(),
            ])
             ->navigationGroups([
                NavigationGroup::make('Страницы')
                    ->collapsed(),
            ])

             ->navigationGroups([
                NavigationGroup::make('Настройки')
                    ->collapsed(),
            ])




                ->navigationItems([
                    NavigationItem::make('Статьи')
                        ->url(fn (): string => ArticleResource::getUrl('index'))
                        ->group('Контент')
                ])

                ->navigationItems([
                    NavigationItem::make('Новости')
                        ->url(fn (): string => NewsResource::getUrl('index'))
                        ->group('Контент')
                ])

                ->navigationItems([
                    NavigationItem::make('Портфолио')
                        ->url(fn (): string => PortfolioResource::getUrl('index'))
                        ->group('Контент')
                ])

                ->navigationItems([
                    NavigationItem::make('Виды нанесения')
                        ->url(fn (): string => DrawingResource::getUrl('index'))
                        ->group('Контент')
                ])






            ->colors([
                'primary' => Color::Rose
            ])
            ->font('Gilroy')
            ->favicon('/img/favicon.ico')

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ]);
    }
}
