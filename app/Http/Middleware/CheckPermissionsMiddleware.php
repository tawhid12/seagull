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

        // Extract resource and action from the required permission
        $permissionParts = explode('.', $requiredPermission);



        /* Get Permission type */
        if ($user->permission_type == 1) {
            
                // Check if there are at least two elements in the array
                if (count($permissionParts) >= 2) {
                    list($resource, $action) = $permissionParts;
                    
                    // Define the mapping of actions that imply each other
                    $impliedActions = [
                        'store' => 'create',
                        'update' => 'edit',
                        // Add more mappings as needed
                    ];
                   //echo "{$resource}.{$impliedActions[$action]}";die;
                    // Check if the user has permission for the required action or its implied action
                    if (($user->permissions->contains('route_name', $requiredPermission) || isset($impliedActions[$action]) && $user->permissions->contains('route_name', "{$resource}.{$impliedActions[$action]}"))
                    ) {
                        return $next($request);
                    }
                }else{
                    if ($user->permissions->contains('route_name', $requiredPermission)){
                        return $next($request);
                    }
                }
            
            // User doesn't have the required permission, handle accordingly
            //return redirect()->route('access.denied');
            abort(403, 'Unauthorized');
        } else {
            /*=== For Role Wise Permission=== */
            $roles = $user->roles;
            $routeName = $request->route()->getName();
            $hasPermission = false;
            foreach ($roles as $role) {
                /*echo '<pre>';
                print_r($role->permissions->toArray());die;*/
                if ($role->permissions->contains('route_name', $routeName)) {
                    $hasPermission = true;
                    break; // Exit the loop once permission is found
                }
            }
            if ($hasPermission) {
                return $next($request);
            } else {
                abort(403, 'Unauthorized');
            }
        }
    }
}
