<?php

namespace App\Providers;

use App\Contracts\LoginServiceInterface;
use App\Contracts\RegisterServiceInterface;
use App\Contracts\RolesServiceInterface;
use App\Contracts\VerificationTokenServiceInterface;
use App\Services\LoginService;
use App\Services\RegisterService;
use App\Services\RolesService;
use App\Services\VerificationTokenService;
use Hashids\Hashids;
use Hashids\HashidsInterface;
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
        $this->app->singleton(LoginServiceInterface::class, LoginService::class);
        $this->app->singleton(RegisterServiceInterface::class, RegisterService::class);
        $this->app->singleton(RolesServiceInterface::class, RolesService::class);
        $this->app->singleton(VerificationTokenServiceInterface::class, VerificationTokenService::class);

        $this->app->singleton(HashidsInterface::class, function () {
            return new Hashids(getenv('HASHIDS_SALT'), getenv('HASHIDS_LENGTh'));
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
