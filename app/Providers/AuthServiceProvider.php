<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $timeout = 600;
        Passport::routes();
        Passport::hashClientSecrets();
        Passport::tokensExpireIn(now()->addSeconds($timeout));
        Passport::refreshTokensExpireIn(now()->addSeconds($timeout));
        Passport::personalAccessTokensExpireIn(now()->addSeconds($timeout));
        // Passport::loadKeysFrom(__DIR__.'/../secrets/oauth'); 
    }
}
