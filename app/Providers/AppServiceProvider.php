<?php

namespace App\Providers;

use App\Services\MemoryService;
use App\Services\TelegramBot\TelegramBotApi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->singletonIf(MemoryService::class);
        }
        $this->app->singleton(TelegramBotApi::class, function ($app) {
            return new TelegramBotApi(config('telegramBot'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
