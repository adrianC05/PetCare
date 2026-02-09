<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Illuminate\Support\ServiceProvider;
use App\Policies\UserPolicy;
use App\Policies\OwnerPolicy;
use App\Policies\StaffPolicy;
use App\Models\User;
use App\Models\Owner;
use App\Models\Staff;
use Illuminate\Support\Facades\Gate;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Appointment::observe(AppointmentObserver::class);
        Gate::define('update', [OwnerPolicy::class, 'update']);
        Gate::policy(Owner::class, OwnerPolicy::class);
        Gate::policy(Staff::class, StaffPolicy::class);
    }
}
