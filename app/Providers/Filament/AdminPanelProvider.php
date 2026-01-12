<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\Media\Pages\MediaFolderPage;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
class AdminPanelProvider extends PanelProvider
{

public function boot()
{
FilamentView::registerRenderHook(
        'panels::head.done',
        fn (): string => Blade::render('
            <style>
                @media print {
                    /* 1. إخفاء كل العناصر المحيطة بالجدول */
                    .fi-sidebar, .fi-topbar, .fi-header-actions, 
                    .fi-header, .fi-footer, .fi-tables-filters-trigger, 
                    .fi-tables-search-field, .fi-tables-pagination,
                    .fi-breadcrumbs {
                        display: none !important;
                    }

                    /* 2. إزالة الهوامش والقيود عن الجسم الرئيسي */
                    body, .fi-main, .fi-main-ctn, .fi-page, .fi-section {
                        margin: 0 !important;
                        padding: 0 !important;
                        background: white !important;
                        overflow: visible !important;
                    }

                    /* 3. إجبار حاوية الجدول على الظهور */
                    .fi-tables-container {
                        display: block !important;
                        border: none !important;
                        box-shadow: none !important;
                    }

                    /* 4. التأكد من أن الجدول نفسه يأخذ عرض الصفحة */
                    table {
                        width: 100% !important;
                        border-collapse: collapse !important;
                    }

                    /* 5. إظهار الصور */
                    img {
                        max-width: 80px !important;
                        height: auto !important;
                        display: inline-block !important;
                    }
                }
            </style>
        '),
    );
}
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                MediaFolderPage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
