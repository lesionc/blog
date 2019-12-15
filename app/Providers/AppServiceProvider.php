<?php

namespace App\Providers;

use App\Contracts\IEmailService;
use App\Services\AliYunEmailService;
use App\Services\QiNiuEamilService;
use App\Services\TengXunEmailService;
use Illuminate\Support\ServiceProvider;
use mysql_xdevapi\Expression;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IEmailService::class, AliYunEmailService::class);
    }
}
