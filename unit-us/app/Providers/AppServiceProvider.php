<?php

namespace App\Providers;

use App\Models\Entreprise;
use App\Models\Profile;
use App\Models\User;
use App\Observers\EntrepriseObserver;
use App\Observers\ProfileObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Entreprise::observe(EntrepriseObserver::class);
        User::observe(UserObserver::class);
        Profile::observe(ProfileObserver::class);

        Gate::define('manage-employees', function ($user) {
            return $user->role === 'admin';
        });
    }
}
