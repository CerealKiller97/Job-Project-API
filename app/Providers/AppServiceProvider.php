<?php

namespace App\Providers;

use App\Contracts\{JobOffersServiceInterface,
    JobStatusServiceInterface,
    LoginServiceInterface,
    RegisterServiceInterface,
    RolesServiceInterface,
    VerificationMailServiceInterface,
    VerificationTokenServiceInterface};
use App\Services\{JobOffersService,
    JobStatusService,
    LoginService,
    RegisterService,
    RolesService,
    VerificationMailService,
    VerificationTokenService};
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
        $this->app->singleton(VerificationMailServiceInterface::class, VerificationMailService::class);
        $this->app->singleton(JobOffersServiceInterface::class, JobOffersService::class);
        $this->app->singleton(JobStatusServiceInterface::class, JobStatusService::class);

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
