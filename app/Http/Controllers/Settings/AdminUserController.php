<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\AdminUser\AddNewRequest;
use App\Http\Requests\AdminUser\UpdateRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\ImageHandleTraits;
use App\Models\Permission;
use App\Models\Company;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use Exception;
use Toastr;
use DB;

class AdminUserController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('settings.adminusers.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        return view('settings.adminusers.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = new User;
            $user->name = $request->userName;
            $user->contact_no = $request->contactNumber;
            $user->email = $request->userEmail;
            if (currentUser() == 'salesexecutive') {
                $user->role_id = 4;
            } else {
                $user->role_id = $request->role_id;
            }

            $user->password = Hash::make($request->password);
            //$user->all_company_access = $request->all_company_access;
            $user->full_access = $request->full_access == 1 ? $request->full_access : 0;
           
            $user->created_by = currentUserId();
            /*if(Permission::where(['role_id'=> 4,'route_name' => 'assignCompany'])->doesntExist()){
                $p = new Permission();
                $p->role_id = 4;
                $p->route_name = 'assignCompany';
                $p->save();
                
            }*/
           
            if ($request->has('image')) $user->image = $this->uploadImage($request->file('image'), 'uploads/admin');

            if ($user->save())
                $child_one = Child_one::where('head_code','1150')->first();
                $ach = new Child_two;
                $ach->child_one_id= $child_one->id;
                $ach->head_name=$request->userName;
                $ach->head_code = '1150'.$user->id;
                $ach->opening_balance =$request->openingAmount ?? 0;
                $ach->created_by=currentUserId();
                if($ach->save()) {
                    //$c->account_id = $ach->id;
                    //$c->save();
                    DB::commit();
                    \LogActivity::addToLog('Add User', $request->getContent(), 'User');
                    return redirect()->route('adminuser.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
                }else
                    return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::all();
        $user = User::findOrFail(encryptor('decrypt', $id));
        $permissions = Permission::all();
        $company = Company::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        return view('settings.adminusers.edit', compact('user', 'role', 'permissions','userRoles','company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
       
            $user = User::findOrFail(encryptor('decrypt', $id));
            $user->name = $request->userName;
            $user->contact_no = $request->contactNumber;
            $user->role_id = $request->role_id;
            $user->permission_type = $request->permission_type;
            $user->full_access = $request->full_access == 1 ? $request->full_access : 0;
            $user->status = $request->status;

            if ($request->permission_type == 2) {
                $selectedRoleIds = $request->input('multiple_role_id', []);
                // Sync the selected roles for the user
                $user->roles()->sync($selectedRoleIds);
            }
            if ($request->has('image'))
                if ($this->deleteImage($user->image, 'uploads/admin'))
                    $user->image = $this->uploadImage($request->file('image'), 'uploads/admin');
                else
                    $user->image = $this->uploadImage($request->file('image'), 'uploads/admin');

            if ($request->has('password') && $request->password)
                $user->password = Hash::make($request->password);

            if ($user->save())
                return redirect()->route('adminuser.index')->with(Toastr::success('Successfully updated!', 'Success', ["positionClass" => "toast-top-right"]));
            else
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail(encryptor('decrypt', $id));
            if ($user->delete())
                return redirect()->back()->with(Toastr::success('Successfully deleted!', 'Success', ["positionClass" => "toast-top-right"]));
            else
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /* User Based Permission */
    public function assignPermissions(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $permissions = $request->input('permissions', []);
        $user->permissions()->sync($permissions);

        return redirect()->back()->with(Toastr::success('Updated!', 'Success', ["positionClass" => "toast-top-right"]));
    }
    public function assignCompany(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $company = $request->input('company_id', []);
        $user->company()->sync($company);

        return redirect()->back()->with(Toastr::success('Updated!', 'Success', ["positionClass" => "toast-top-right"]));
    }
    /* Role Based Permission */
    public function assignrolebasedPermissions(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $permissions = $request->input('permissions', []);
        $user->permissions()->sync($permissions);

        return redirect()->back()->with(Toastr::success('Successfully deleted!', 'Success', ["positionClass" => "toast-top-right"]));
    }
}
