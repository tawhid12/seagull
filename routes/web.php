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
use App\Http\Controllers\SalaryDetailController as salaryDetl;
use App\Http\Controllers\CompanyController as company;
use App\Http\Controllers\BankDetailController as bank;
use App\Http\Controllers\VesselController as vessel;
use App\Http\Controllers\VesselCategoryController as vessel_cat;
use App\Http\Controllers\ClientController as client;

use App\Http\Controllers\CategoryController as category;
use App\Http\Controllers\ProductController as product;
use App\Http\Controllers\ProductTypeController as producttype;
use App\Http\Controllers\SupplierController as supplier;


use App\Http\Controllers\RequisitionController as requisition;
use App\Http\Controllers\RequisitionDetailController as requisitiondetl;
use App\Http\Controllers\ProductRequisitonController as prorequisition;
use App\Http\Controllers\ProductRequisitionDetailsController as prorequisitiondetl;

use App\Http\Controllers\AutoDebitVoucherController as autodebitvoucher;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\TotalLeavePerYearController;
use App\Http\Controllers\TotalWorkingDayController;
use App\http\controllers\SalarySlipController;
use App\http\controllers\SalaryAdvancePaymentController;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\OrderController as order;
use App\Http\Controllers\ServiceReportController as service;
use App\Http\Controllers\DeliveryReportController as delivery;
use App\Http\Controllers\InvoiceReportController as invoice;
use App\Http\Controllers\WorkDoneReportController as workdone;

use App\Http\Controllers\PaymentController as payment;

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


//Route::middleware('checkRole')->group(function () {.
Route::middleware(['checkauth'])->group(function () {
    Route::get('/dashboard', [dash::class, 'dashboard'])->name('dashboard');
    Route::get('company/select', [dash::class, 'salesExecutiveCompany'])->name('salesExecutiveCompany');
    Route::post('assign/company/{id}',  [adminuser::class, 'assignCompany'])->name('assignCompany');
    Route::get('/date/wise/attendance', [ReportController::class, 'datewiseAttendance'])->name('datehwiseStudentAttnAdd');
    Route::get('incomeStatement_details', [statement::class, 'details'])->name('incomeStatement.details');
    Route::get('journal_get_head', [journal::class, 'get_head'])->name('journal_get_head');
    Route::get('get_head', [credit::class, 'get_head'])->name('get_head');
    Route::get('incomeStatement', [statement::class, 'index'])->name('incomeStatement');
    Route::get('/headreport', [headreport::class, 'index'])->name('headreport');

    /*== Secret Login ==*/
    Route::get('secret/login/{id}', [company::class, 'secretLogin'])->name('secretLogin');
    /*== Client By Company ==*/
    Route::get('company/client/{id}', [client::class, 'client_by_company'])->name('client_by_company');
    /*== Client By Company ==*/
    Route::get('company/vessel/{id}', [vessel::class, 'vessel_by_company'])->name('vessel_by_company');
    /*== Payment By Invoice ==*/
    Route::get('payment/order/', [payment::class, 'payment_by_order'])->name('payment_by_order');

    Route::get('product/all',  [product::class, 'allProducts'])->name('allProducts');
    Route::get('productbyId',  [product::class, 'productById'])->name('productById');
});
Route::middleware(['checkrole'])->prefix('admin')->group(function () {

    //Route::prefix('superadmin')->group(function(){
    //Route::prefix('/{rolePrefix}/')->group(function () {
    /*Route::post('assign/permissions/{id}',  [adminuser::class, 'assignPermissions'])->name('assignPermissions');*/

    /*Route::post('assign/role/permissions/{id}',  [role::class, 'rolePermission'])->name('rolePermission');
        Route::resource('permission', permission::class);
        Route::resource('role', role::class);*/


    Route::resource('role', role::class);
    Route::get('permission/{role}', [permission::class, 'index'])->name('permission.list');
    Route::post('permission/{role}', [permission::class, 'save'])->name('permission.save');


    Route::get('/profile', [userprofile::class, 'profile'])->name('profile');
    Route::post('/profile', [userprofile::class, 'store'])->name('profile.store');
    Route::get('/change_password', [userprofile::class, 'change_password'])->name('change_password');
    Route::post('/change_password', [userprofile::class, 'change_password_store'])->name('change_password.store');
    Route::resource('adminuser', adminuser::class);
    Route::resource('designation', designation::class);
    Route::resource('employee', employee::class);
    Route::resource('salaryDetl', salaryDetl::class);
    Route::resource('company', company::class)->middleware('company');
    Route::resource('bank', bank::class);
    Route::resource('vessel', vessel::class)->middleware('company');
    Route::resource('vessel-categories', vessel_cat::class)->middleware('company');
    Route::resource('client', client::class)->middleware('company');

    Route::resource('category', category::class);
    Route::resource('product', product::class);
    Route::resource('product-type', producttype::class);
    Route::resource('supplier', supplier::class);

    Route::resource('requisition', requisition::class)->middleware('company');
    Route::PUT('requisition-approve/{id}', [requisition::class,'approve_toggle'])->name('approve_toggle')->middleware('company');
    Route::resource('requisition-detl', requisitiondetl::class)->middleware('company');
    Route::resource('product-requisition', prorequisition::class)->middleware('company');
    Route::resource('product-requisition-detl', prorequisitiondetl::class)->middleware('company');
    Route::resource('autodebitvoucher', autodebitvoucher::class);

    /*Attendance Controller */
    Route::resource('attendance', AttendanceController::class);
    Route::resource('leave', LeaveController::class);
    Route::resource('leave-type', LeaveTypeController::class);
    Route::resource('total-leave-per-year', TotalLeavePerYearController::class);
    Route::resource('total-working-day', TotalWorkingDayController::class);
    Route::resource('salary-slip', SalarySlipController::class);
    Route::resource('salary-advance-payment', SalaryAdvancePaymentController::class);

    /* Order */
    Route::resource('order', order::class)->middleware('company');
    Route::resource('service-report', service::class)->middleware('company');
    Route::resource('delivery-report', delivery::class)->middleware('company');
    Route::resource('invoice-report', invoice::class)->middleware('company');
    Route::resource('work-done-report', workdone::class)->middleware('company');
    Route::resource('payment', payment::class)->middleware('company');

    //Accounts
    Route::resource('master', master::class);
    Route::resource('sub_head', sub_head::class);
    Route::resource('child_one', child_one::class);
    Route::resource('child_two', child_two::class);
    Route::resource('navigate', navigate::class);


    Route::get('/profitloss', [profitloss::class, 'index']);
    Route::get('/balancesheet', [balancesheet::class, 'index']);


    //Voucher
    Route::resource('credit', credit::class)->middleware('company');
    Route::resource('debit', debit::class)->middleware('company');
    Route::resource('journal', journal::class)->middleware('company');

    //});
});
