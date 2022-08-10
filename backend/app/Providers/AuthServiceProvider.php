<?php

namespace App\Providers;

use App\Services\Auth\JwtGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::extend('jwt', function ($app, $name, array $config) {
            $guard = new JwtGuard(
                Auth::createUserProvider($config['provider']),
                $app['request']
            );

            $app->refresh('request', $guard, 'setRequest');

            return $guard;
        });

        // $this->app['auth']->extend('jwt', function ($app, $name, array $config) {
        //     $guard = new JwtGuard(
        //         $app['auth']->createUserProvider($config['provider']),
        //         $app['request']
        //     );

        //     $app->refresh('request', $guard, 'setRequest');

        //     return $guard;
        // });
    }
}
