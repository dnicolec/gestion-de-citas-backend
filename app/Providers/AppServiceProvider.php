<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Policies\CitaPolicy;
use App\Policies\ExpedientePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        MedicalRecord::class => ExpedientePolicy::class,
        Appointment::class => CitaPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
    }
}