<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('firebase.messaging', function ($app) {
            $firebaseCredentialsPath = config('app.firebase_credentials');

            $factory = (new Factory)
                ->withServiceAccount($firebaseCredentialsPath);

            return $factory->createMessaging();
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
