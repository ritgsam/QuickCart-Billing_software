<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class CheckRole {
   public function handle($request, Closure $next, $module)
{
    $roleId = Auth::user()->role_id;

    $hasPermission = Permission::where('role_id', $roleId)
        ->where('module', $module)
        ->where('view', true)
        ->exists();

    if (!$hasPermission) {
        abort(403, 'Unauthorized access');
    }

    return $next($request);
}
}
