<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use DB;

class DashboardController extends Controller
{
    /*
    * admin dashboard
    */
    public function dashboard()
    {
        if (currentUser() == 'superadmin') {
            //return redirect()->route('superadminDashboard')->with($this->resMessageHtml(true,null,'Successfully login'));
            return view('dashboard.superadmin');
        } elseif (currentUser() == 'admin') {
            //return redirect()->route('adminDashboard')->with($this->resMessageHtml(true,null,'Successfully login'));
            return view('dashboard.admin');
        } elseif (currentUser() == 'salesexecutive') {
            //return redirect()->route('salesExecutiveCompany')->with($this->resMessageHtml(true,null,'Successfully login'));
            $company = company()['company_id'];
            if ($company) {
                return view('dashboard.salesexecutive');
            } else {
                return redirect()->route('salesExecutiveCompany');
            }
        } elseif (currentUser() == 'accountant') {
            //return redirect()->route('accountantDashboard')->with($this->resMessageHtml(true, null, 'Successfully login'));
            return view('dashboard.accountant');
        }
    }
    public function superadminDashboard()
    {
        return view('dashboard.superadmin');
    }
    /*
    * admin dashboard
    */
    public function adminDashboard()
    {
        return view('dashboard.admin');
    }

    /*
    * owner dashboard
    */
    public function userDashboard()
    {
        return view('dashboard.user');
    }

    /*
    * sales manager dashboard
    */
    public function salesExecutiveCompany()
    {
        $company = DB::table('user_company')
            ->join('companies', 'user_company.company_id', 'companies.id')
            ->where('user_company.user_id', currentUserId())
            ->select('companies.id', 'companies.company_name')
            ->get();
        return view('dashboard.sales-company-select', compact('company'));
    }
    public function salesexecutiveDashboard()
    {
        $company = company()['company_id'];
        if ($company) {
            return view('dashboard.salesexecutive');
        } else {
            return redirect()->route('salesExecutiveCompany');
        }
    }
    public function accountantDashboard()
    {
        return view('dashboard.accountant');
    }

    /*
    * sales man dashboard
    */
    public function salesmanDashboard()
    {
        return view('dasbhoard.salesman');
    }
}
