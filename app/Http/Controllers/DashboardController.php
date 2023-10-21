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
    public function superadminDashboard(){
        return view('dashboard.superadmin');
    }
    /*
    * admin dashboard
    */
    public function adminDashboard(){
        return view('dashboard.admin');
    }

    /*
    * owner dashboard
    */
    public function userDashboard(){
        return view('dashboard.user');
    }
    
    /*
    * sales manager dashboard
    */
    public function salesExecutivecountry(){
        $company = DB::table('user_company')
        ->join('companies','user_company.company_id','companies.id')
        ->where('user_company.user_id',currentUserId())
        ->select('companies.id','companies.company_name')
        ->get();
        return view('dashboard.sales-company-select',compact('company'));
    }
    public function salesexecutiveDashboard (){
        return view('dashboard.salesexecutive');
    }

    /*
    * sales man dashboard
    */
    public function salesmanDashboard(){
        return view('dasbhoard.salesman');
    }
}
