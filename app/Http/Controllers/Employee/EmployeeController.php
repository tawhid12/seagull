<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

use App\Models\Employee\Employee;
use App\Models\Settings\Designation;
use App\Models\Settings\District;
use Illuminate\Http\Request;
use App\Http\Requests\Employee\AddNewRequest;
use App\Http\Requests\Employee\UpdateRequest;


use Toastr;
use Carbon\Carbon;
use DB;
use File;
use App\Http\Traits\ImageHandleTraits;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use ImageHandleTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate(20);
        return view('employee.index', compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::all();
        $designation = Designation::all();
        return view('employee.create', compact('districts', 'designation'));
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
            //echo 
            // dd($request->all());
            //echo '<pre>';
            //print_r($request->all());
            DB::beginTransaction(); // <= Starting the transaction
            $employee = [
                'employee_id'      => 'E-' . Designation::where('id', $request->designation_id)->first()->id . '-' . str_pad((Employee::max('id') + 1), 4, "0", STR_PAD_LEFT),
                'employee_name'    => $request->employee_name,
                'address'          => $request->address,
                'district_id'      => $request->district_id,
                'fathers_name'     => $request->fathers_name,
                'mothers_name'     => $request->mothers_name,
                'education_qualification'     => $request->education_qualification,
                'mobile_no'        => $request->mobile_no,
                'salary'           => $request->salary,
                'joining_date'     => $request->joining_date,
                'created_by'       => currentUser(),
                'created_at'       => \Carbon\Carbon::now(),
            ];
            DB::table('employees')->insert($employee);
            $salary_detl = [
                'employee_id'      => 'E-' . Designation::where('id', $request->designation_id)->first()->id . '-' . str_pad((Employee::max('id') + 1), 4, "0", STR_PAD_LEFT),
                'final_salary'     => $request->salary,
                'created_by'       => currentUser(),
                'created_at'       => \Carbon\Carbon::now(),
            ];
            DB::table('salary_details')->insert($salary_detl);
            DB::commit();


            /*if($request->has('profile_img'))
            $employee->profile_img=$this->uploadImage($request->profile_img,'uploads/profile_img/');*/


            return redirect()->route('employee.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees = Employee::findOrFail(encryptor('decrypt', $id));
        $security = SecurityPriorAcquaintance::where('employee_id', encryptor('decrypt', $id))->first();
        return view('employee.show', compact('employees', 'security'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    public function securityGuards($id)
    {
        $employees = Employee::findOrFail(encryptor('decrypt', $id));
        $districts = District::all();
        $upazila = Upazila::all();
        return view('employee.security-prior-acquaintance', compact('employees', 'districts', 'upazila'));
    }

    public function securityGuardsStore(Request $request)
    {
        try {
            $security = new SecurityPriorAcquaintance;
            $security->employee_id = $request->employee_id;
            $security->bn_in_laws_district_id = $request->bn_in_laws_district_id;
            $security->bn_in_laws_upazilla_id = $request->bn_in_laws_upazilla_id;
            $security->bn_in_laws_village_name = $request->bn_in_laws_village_name;
            $security->bn_in_laws_post_office = $request->bn_in_laws_post_office;
            $security->bn_husband_profession = $request->bn_husband_profession;
            $security->bn_father_profession = $request->bn_father_profession;
            $security->bn_landlord_name = $request->bn_landlord_name;
            $security->bn_landlord_mobile_no = $request->bn_landlord_mobile_no;
            $security->bn_living_dur = $request->bn_living_dur;
            $security->bn_passport_no = $request->bn_passport_no;
            $security->bn_old_office_name = $request->bn_old_office_name;
            $security->bn_old_office_address = $request->bn_old_office_address;
            $security->bn_resign_reason = $request->bn_resign_reason;
            $security->bn_resign_letter_status = $request->bn_resign_letter_status;
            $security->bn_service_book_status = $request->bn_service_book_status;
            $security->bn_service_book_no = $request->bn_service_book_no;
            $security->bn_old_job_salary = $request->bn_old_job_salary;
            $security->bn_old_job_last_desig = $request->bn_old_job_last_desig;
            $security->bn_old_job_experience = $request->bn_old_job_experience;
            $security->bn_new_job_transportation = $request->bn_new_job_transportation;
            $security->bn_current_living = $request->bn_current_living;
            $security->bn_total_member = $request->bn_total_member;
            $security->bn_mobile_no = $request->bn_mobile_no;
            $security->bn_solvent_person = $request->bn_solvent_person;
            $security->bn_sim_card_reg_status = $request->bn_sim_card_reg_status;
            $security->bn_case_filed_status = $request->bn_case_filed_status;
            $security->bn_old_job_officer_name = $request->bn_old_job_officer_name;
            $security->bn_old_job_officer_mobile = $request->bn_old_job_officer_mobile;
            $security->bn_old_job_officer_post = $request->bn_old_job_officer_post;
            $security->bn_identifier_name1 = $request->bn_identifier_name1;
            $security->bn_identifier_occupation1 = $request->bn_identifier_occupation1;
            $security->bn_identifier_address1 = $request->bn_identifier_address1;
            $security->bn_identifier_phone1 = $request->bn_identifier_phone1;
            $security->bn_identifier_name2 = $request->bn_identifier_name2;
            $security->bn_identifier_occupation2 = $request->bn_identifier_occupation2;
            $security->bn_identifier_address2 = $request->bn_identifier_address2;
            $security->bn_identifier_phone2 = $request->bn_identifier_phone2;
            if ($request->has('informant_sing'))
                $security->informant_sing = $this->uploadImage($request->informant_sing, 'uploads/informant_sing/');
            if ($request->has('data_collector_sing'))
                $security->data_collector_sing = $this->uploadImage($request->data_collector_sing, 'uploads/data_collector_sing/');
            if ($request->has('executive_sing'))
                $security->executive_sing = $this->uploadImage($request->executive_sing, 'uploads/executive_sing/');
            if ($request->has('manager_sing'))
                $security->manager_sing = $this->uploadImage($request->manager_sing, 'uploads/manager_sing/');
            if ($security->save())
                return redirect()->route('employee.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            else
                return redirect()->back()->withInput()->with($this->resMessageHtml(false, 'error', 'please try again'));
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->withInput()->with($this->resMessageHtml(false, 'error', 'Please try again'));
        }
    }
}
