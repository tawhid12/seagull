<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController as auth;
use App\Http\Controllers\DashboardController as dash;
use App\Http\Controllers\PermissionController as permission;
use App\Http\Controllers\RoleController as role;

use App\Http\Controllers\Settings\Designation\DesignationController as designation;




use App\Http\Controllers\Settings\AdminUserController as adminuser;
use App\Http\Controllers\Settings\UserProfileController as userprofile;






use App\Http\Controllers\TestController as test;


use App\Http\Controllers\Employee\EmployeeController as employee;
use App\Http\Controllers\CompanyController as company;
use App\Http\Controllers\VesselController as vessel;
use App\Http\Controllers\ClientController as client;

use App\Http\Controllers\CategoryController as category;
use App\Http\Controllers\ProductController as product;
use App\Http\Controllers\SupplierController as supplier;


use App\Http\Controllers\RequisitonController as requisition;
use App\Http\Controllers\OtherRequisitonController as otherrequisition;

use App\Http\Controllers\AccountMasterController as accmaster;
use App\Http\Controllers\AccountMasterSubController as accmastersub;
use App\Http\Controllers\AccountMasterSubBkdnController as accmastersubbkdn;
use App\Http\Controllers\AccountMasterSubBkdnSubController as accmastersubbkdnsub;
use App\Http\Controllers\AccountHeadController as accounthead;
/* Middleware */
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isSuperadmin;
use App\Http\Middleware\isSalesexecutive;
use App\Http\Middleware\isUser;


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
Route::get('/mail', [test::class,'index'])->name('mail');


Route::group(['middleware' => 'unknownUser'], function () {



Route::get('/register', [auth::class,'signUpForm'])->name('register');
Route::post('/register', [auth::class,'signUpStore'])->name('register.store');
Route::get('/signin', [auth::class,'signInForm'])->name('signIn');
Route::get('/', [auth::class,'signInForm'])->name('login');
Route::post('/login', [auth::class,'signInCheck'])->name('login.check');


});

Route::get('/logout', [auth::class,'singOut'])->name('logOut');


//Route::middleware('checkRole')->group(function () {

Route::middleware('chcekpermission')->group(function () {
    //Route::prefix('superadmin')->group(function(){
        // Route::prefix('{role}')->group(function () {
            Route::post('assign/permissions/{id}',  [adminuser::class,'assignPermissions'])->name('assign.permissions');
            Route::post('assign/company/{id}',  [adminuser::class,'assignCompany'])->name('assign.company');
            Route::post('assign/role/permissions/{id}',  [role::class,'rolePermission'])->name('role.permission');
            Route::resource('permission', permission::class);
            Route::resource('role', role::class);

        Route::get('superadmin/dashboard', [dash::class,'superadminDashboard'])->name('superadminDashboard');
        Route::get('salesexecutive/country/select', [dash::class,'salesExecutivecountry'])->name('salesExecutivecountry');
        Route::get('salesexecutive/dashboard', [dash::class,'salesexecutiveDashboard'])->name('salesexecutiveDashboard');
        /*== Secret Login ==*/
        Route::get('secret/login/{id}', [company::class, 'secretLogin'])->name('secretLogin');

        Route::get('/profile', [userprofile::class,'profile'])->name('profile');
        Route::post('/profile', [userprofile::class,'store'])->name('profile.store');
        Route::get('/change_password', [userprofile::class,'change_password'])->name('change_password');
        Route::post('/change_password', [userprofile::class,'change_password_store'])->name('change_password.store');
        Route::resource('adminuser', adminuser::class);
        Route::resource('designation', designation::class);
        Route::resource('employee', employee::class);
        Route::resource('company', company::class);
        Route::resource('vessel', vessel::class);
        Route::resource('client', client::class);

        Route::resource('category', category::class);
        Route::resource('product', product::class);
        Route::resource('supplier', supplier::class);

        Route::resource('requisition', requisition::class);
        Route::resource('otherRequisition', otherrequisition::class);

        Route::resource('accountMaster', accmaster::class);
        Route::resource('accountMasterSub', accmastersub::class);
        Route::resource('accountMasterSubBkdn', accmastersubbkdn::class);
        Route::resource('accountMasterSubBkdnSub', accmastersubbkdnsub::class);

        Route::resource('accountHead', accounthead::class);

    //});
});
Route::group(['middleware'=>isAdmin::class],function(){
    Route::prefix('admin')->group(function(){
        Route::get('/dashboard', [dash::class,'adminDashboard'])->name('admin.dashboard');
        /* settings */


    });
});




