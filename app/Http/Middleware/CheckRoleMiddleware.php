<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Illuminate\Http\Request;
use App\Models\Role;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user has the specified role
        $role = Role::find(encryptor('decrypt', Session::get('roleId')));
        if ($role) {
            // Set the route prefix based on the role
            $request->attributes->set('rolePrefix', $role->identity);
            return $next($request);
        }

        // Redirect or handle unauthorized access
        return redirect()->route('unauthorized');
    }
}
