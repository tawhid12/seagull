<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompanyMiddleware
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
        if (currentUser() == 'salesexecutive') {
            $company = company()['company_id'];
            if ($company) {
                //return view('dashboard.salesexecutive');
                return $next($request);
            } else {
                return redirect()->route('salesExecutiveCompany');
            }
        } elseif (currentUser() == 'superadmin' || currentUser() == 'accountant') {
            $route = explode('.', $request->route()->getName());
            if ($route[1] == 'index' || $route[0] == 'company') {
                return $next($request);
            } elseif($request->route()->getName() == 'requisition.update'){
                return $next($request);
            }else {
                \Toastr::warning("You don't have permission to access this page");
                return redirect()->back();
            }
        } else {
            \Toastr::warning("You don't have permission to access this page");
            return redirect()->back();
        }
    }
}
