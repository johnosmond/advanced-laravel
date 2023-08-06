<?php

namespace App\Providers;

use App\Models\User;
use App\Models\ScheduledClass;
use Illuminate\Support\Facades\Gate;
use App\Policies\ScheduledClassPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ScheduledClass::class => ScheduledClassPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('schedule-class', function(User $user){
            return $user->role === 'instructor';
        });
        Gate::define('book-class', function(User $user){
            return $user->role === 'member';
        });
    }
}
