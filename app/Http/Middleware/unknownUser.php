<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Models\User;
use App\Models\Role;
use App\Http\Traits\ResponseTrait;

class unknownUser
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('userId') && Session::get('userId') !== null && Session::has('roleId')) {
            $user = User::find(encryptor('decrypt', Session::get('userId')));
            $role = Role::find(encryptor('decrypt', Session::get('roleId')));

            if (!!$user && $role->identity == 'superadmin')
                return redirect(route('dashboard'));
            else if (!!$user && $role->identity == 'admin')
                return redirect(route('dashboard'));
            else if (!!$user && $role->identity == 'salesexecutive')
                return redirect(route('dashboard'));
            else if (!!$user && $role->identity == 'accountant')
                return redirect(route('dashboard'));
            else if (!!$user && $role->identity == 'hrexecutive')
                return redirect(route('dashboard'));
            else
                return redirect(route('login'))->with($this->responseMessage(false, "error", 'Log In faild'));

            return $next($request);
        }

        return $next($request);
    }
}
