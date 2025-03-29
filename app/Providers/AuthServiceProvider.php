<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users', function (User $user) {
        return $user->role === 'Admin';
    });

       Gate::define('view-reports', function (User $user) {
        return in_array($user->role, ['Admin', 'Manager']);
    });

Gate::define('assign-permissions', function (User $user) {
        return $user->role === 'Admin';
    });

        Gate::define('assign-roles', function (User $user) {
            return $user->role === 'Admin';
        });

        Gate::define('admin-only', function (User $user) {
    return $user->role === 'Admin';
});
        Gate::define('manager-access', function (User $user) {
    return in_array($user->role, ['Admin', 'Manager']);
});

Gate::define('accountant-access', function (User $user) {
    return in_array($user->role, ['Admin', 'Accountant']);
});

Gate::define('sales-access', function (User $user) {
    return in_array($user->role, ['Admin', 'Sales']);
});
    }
}
