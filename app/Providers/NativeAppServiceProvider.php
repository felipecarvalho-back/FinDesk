<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Native\Desktop\Contracts\ProvidesPhpIni;
use Native\Desktop\Facades\Window;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        Artisan::call('migrate', ['--force' => true]);

        Window::open()
            ->width(1280)
            ->height(850)
            ->minWidth(1000)
            ->minHeight(700)
            ->title('FinDesk - Gerenciador Financeiro')
            ->showDevTools((bool) config('app.debug', false))
            ->hideMenu()
            ->rememberState()
            ->maximized();
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
            'opcache.enable' => 1,
            'opcache.enable_cli' => 1,
            'opcache.memory_consumption' => 128,
            'opcache.interned_strings_buffer' => 16,
            'opcache.max_accelerated_files' => 10000,
            'opcache.validate_timestamps' => config('app.debug') ? 1 : 0,
            'opcache.revalidate_freq' => 0,
            'opcache.jit' => 'tracing',
            'opcache.jit_buffer_size' => '64M',
            'realpath_cache_size' => '4096k',
            'realpath_cache_ttl' => 600,
            'memory_limit' => '256M',
        ];
    }
}
