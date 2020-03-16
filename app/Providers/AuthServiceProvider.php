<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('changepost', function($user, $post) {
            return ($post->user && $post->user->id === $user->id) || ($user->role === 'admin');
        });

        Gate::define('dostuff', function($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });
    }
}
