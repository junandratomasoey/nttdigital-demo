<?php

namespace App\Providers\Filament;

use App\Filament\Pages\ProfilSitus;
use App\Filament\Resources\ItemResource;
use App\Filament\Resources\KirimanResource;
use App\Filament\Resources\PostResource;
use App\Http\Middleware\TentukanDemo;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
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
            ->colors(['primary' => Color::hex('#0F6E56')])
            ->brandName(fn () => app()->bound('demo') ? app('demo')->nama : 'Demo NTT Digital')
            ->resources([PostResource::class, ItemResource::class, KirimanResource::class])
            ->pages([Pages\Dashboard::class, ProfilSitus::class])
            ->widgets([\App\Filament\Widgets\RingkasanDemo::class])
            ->navigationItems([
                NavigationItem::make('Lihat website')->url('/', shouldOpenInNewTab: true)->icon('heroicon-o-globe-alt')->sort(99),
            ])
            ->renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, fn () => view('filament.info-login'))
            ->renderHook(PanelsRenderHook::BODY_START, fn () => view('filament.pita-demo'))
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                TentukanDemo::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([Authenticate::class]);
    }
}
