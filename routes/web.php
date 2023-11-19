<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController as auth;
use App\Http\Controllers\DashboardController as dash;
use App\Http\Controllers\PermissionController as permission;
use App\Http\Controllers\RoleController as role;

use App\Http\Controllers\Settings\Designation\DesignationController as designation;




use App\Http\Controllers\Settings\AdminUserController as adminuser;
use App\Http\Controllers\Settings\District as district;
use App\Http\Controllers\Settings\UserProfileController as userprofile;






use App\Http\Controllers\TestController as test;


use App\Http\Controllers\Employee\EmployeeController as employee;
use App\Http\Controllers\Employee\SalaryDetailController as salaryDetl;
use App\Http\Controllers\CompanyController as company;
use App\Http\Controllers\VesselController as vessel;
use App\Http\Controllers\ClientController as client;

use App\Http\Controllers\CategoryController as category;
use App\Http\Controllers\ProductController as product;
use App\Http\Controllers\SupplierController as supplier;


use App\Http\Controllers\RequisitonController as requisition;
use App\Http\Controllers\OtherRequisitonController as otherrequisition;
use App\Http\Controllers\AutoDebitVoucherController as autodebitvoucher;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\TotalLeavePerYearController;
use App\Http\Controllers\TotalWorkingDayController;
use App\http\controllers\SalarySlipController;
use App\http\controllers\SalaryAdvancePaymentController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\Accounts\MasterAccountController as master;
use App\Http\Controllers\Accounts\SubHeadController as sub_head;
use App\Http\Controllers\Accounts\ChildOneController as child_one;
use App\Http\Controllers\Accounts\ChildTwoController as child_two;
use App\Http\Controllers\Accounts\NavigationHeadViewController as navigate;
use App\Http\Controllers\Accounts\IncomeStatementController as statement;
use App\Http\Controllers\Accounts\Report\HeadReportController as headreport;
use App\Http\Controllers\Accounts\Report\BalanceSheetController as balancesheet;
use App\Http\Controllers\Accounts\Report\ProfitLossController as profitloss;

use App\Http\Controllers\Vouchers\CreditVoucherController as credit;
use App\Http\Controllers\Vouchers\DebitVoucherController as debit;
use App\Http\Controllers\Vouchers\JournalVoucherController as journal;

/* Middleware */
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isSuperadmin;
use App\Http\Middleware\isSalesexecutive;
use App\Http\Middleware\isUser;
use App\Models\Salary\SalaryAdvancePayment;
use App\Models\TotalLeavePerYear;

/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*Test controler */

Route::get('/mail', [test::class, 'index'])->name('mail');


Route::group(['middleware' => 'unknownUser'], function () {



    Route::get('/register', [auth::class, 'signUpForm'])->name('register');
    Route::post('/register', [auth::class, 'signUpStore'])->name('register.store');
    Route::get('/signin', [auth::class, 'signInForm'])->name('signIn');
    Route::get('/', [auth::class, 'signInForm'])->name('login');
    Route::post('/login', [auth::class, 'signInCheck'])->name('login.check');
});

Route::get('/logout', [auth::class, 'singOut'])->name('logOut');


//Route::middleware('checkRole')->group(function () {

Route::middleware('chcekpermission')->group(function () {
    //Route::prefix('superadmin')->group(function(){
    // Route::prefix('{role}')->group(function () {
    Route::post('assign/permissions/{id}',  [adminuser::class, 'assignPermissions'])->name('assign.permissions');
    Route::post('assign/company/{id}',  [adminuser::class, 'assignCompany'])->name('assign.company');
    Route::post('assign/role/permissions/{id}',  [role::class, 'rolePermission'])->name('role.permission');
    Route::resource('permission', permission::class);
    Route::resource('role', role::class);

    Route::get('superadmin/dashboard', [dash::class, 'superadminDashboard'])->name('superadminDashboard');
    Route::get('salesexecutive/country/select', [dash::class, 'salesExecutivecountry'])->name('salesExecutivecountry');
    Route::get('salesexecutive/dashboard', [dash::class, 'salesexecutiveDashboard'])->name('salesexecutiveDashboard');
    Route::get('accountant/dashboard', [dash::class, 'accountantDashboard'])->name('accountantDashboard');
    /*== Secret Login ==*/
    Route::get('secret/login/{id}', [company::class, 'secretLogin'])->name('secretLogin');

    Route::get('/profile', [userprofile::class, 'profile'])->name('profile');
    Route::post('/profile', [userprofile::class, 'store'])->name('profile.store');
    Route::get('/change_password', [userprofile::class, 'change_password'])->name('change_password');
    Route::post('/change_password', [userprofile::class, 'change_password_store'])->name('change_password.store');
    Route::resource('adminuser', adminuser::class);
    Route::resource('designation', designation::class);
    Route::resource('employee', employee::class);
    Route::resource('salaryDetl', salaryDetl::class);
    Route::resource('company', company::class);
    Route::resource('vessel', vessel::class);
    Route::resource('client', client::class);

    Route::resource('category', category::class);
    Route::resource('product', product::class);
    Route::resource('supplier', supplier::class);

    Route::resource('requisition', requisition::class);
    Route::resource('otherRequisition', otherrequisition::class);
    Route::resource('autodebitvoucher', autodebitvoucher::class);

    /*Attendance Controller */
    Route::resource('/attendance', AttendanceController::class);
    Route::resource('/leave', LeaveController::class);
    Route::resource('/leave-type', LeaveTypeController::class);
    Route::resource('/total-leave-per-year', TotalLeavePerYearController::class);
    Route::resource('/total-working-day', TotalWorkingDayController::class);
    Route::resource('/salary-slip', SalarySlipController::class);
    Route::resource('/salary-advance-payment', SalaryAdvancePaymentController::class);
    Route::get('/date/wise/attendance', [ReportController::class, 'datewiseAttendance'])->name('datehwiseStudentAttnAdd');

    //Accounts
    Route::resource('master', master::class);
    Route::resource('sub_head', sub_head::class);
    Route::resource('child_one', child_one::class);
    Route::resource('child_two', child_two::class);
    Route::resource('navigate', navigate::class);

    Route::get('incomeStatement', [statement::class, 'index'])->name('incomeStatement');
    Route::get('incomeStatement_details', [statement::class, 'details'])->name('incomeStatement.details');
    Route::get('/profitloss', [profitloss::class, 'index']);
    Route::get('/balancesheet', [balancesheet::class, 'index']);
    Route::get('/headreport', [headreport::class, 'index'])->name('headreport');

    //Voucher
    Route::resource('purchase_voucher', PurchaseVoucher::class);
    Route::resource('sales_voucher', SalesVoucher::class);
    Route::resource('credit', credit::class);
    Route::resource('debit', debit::class);
    Route::get('get_head', [credit::class, 'get_head'])->name('get_head');
    Route::resource('journal', journal::class);
    Route::get('journal_get_head', [journal::class, 'get_head'])->name('journal_get_head');


    //});
});
Route::group(['middleware' => isAdmin::class], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [dash::class, 'adminDashboard'])->name('admin.dashboard');
        /* settings */
    });
});
