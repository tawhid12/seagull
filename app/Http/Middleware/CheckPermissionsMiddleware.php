<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use App\Http\Traits\ResponseTrait;

class CheckPermissionsMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('userId') || Session::has('userId') == null || !Session::has('roleIdentity')) {
            return redirect()->route('logOut');
        }
        //return $next($request);
        $user = User::find(currentUserId());
        // Get the required permission for the current route
        $requiredPermission = $request->route()->getName();

        /* Get Permission type */
        /*if ($user->permission_type == 1) {
            if ($user->permissions->contains('name', $requiredPermission)) {
                return $next($request);
            }*/
            // User doesn't have the required permission, handle accordingly
            //return redirect()->route('access.denied');
            /*abort(403, 'Unauthorized');
        } else {*/
            
            /*=== For Role Wise Permission=== */
            /*$roles = $user->roles;
            $routeName = $request->route()->getName();*/

            /*foreach ($roles as $role) {
                if ($role->permissions->contains('name', $routeName)) {*/
                    return $next($request);
                /*}else{
                    abort(403, 'Unauthorized');
                }
            }*/
            
        }
    //}
}
