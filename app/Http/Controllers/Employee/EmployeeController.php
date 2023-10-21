<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeDetails;
use App\Models\Employee\SecurityPriorAcquaintance;
use Illuminate\Http\Request;

use App\Models\Settings\Location\District;
use App\Models\Settings\Location\Upazila;
use App\Models\Settings\Location\Union;
use App\Models\Settings\Location\Ward;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\Religion;

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
        return view('employee.index',compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts = District::all();
        $upazila = Upazila::all();
        $union = Union::all();
        $ward = Ward::all();
        $bloods = BloodGroup::all();
        $religions = Religion::all();
        return view('employee.create',compact('districts','upazila','union','ward','bloods','religions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());
            /*echo '<pre>';
        print_r($request->all());*/
            $employee = new Employee();
            $employee->bn_applicants_name = $request->bn_applicants_name;
            $employee->bn_fathers_name = $request->bn_fathers_name;
            $employee->bn_mothers_name = $request->bn_mothers_name;
            $employee->admission_id_no = $request->admission_id_no;
            // $employee->admission_id_no = 'AD-'.Carbon::now()->format('m-y').'-'. str_pad((Employee::whereYear('created_at', Carbon::now()->year)->count() + 1),4,"0",STR_PAD_LEFT);

            $employee->bn_parm_district_id = $request->bn_parm_district_id;
            $employee->bn_parm_upazila_id = $request->bn_parm_upazila_id;
            $employee->bn_parm_union_id = $request->bn_parm_union_id;
            $employee->bn_parm_ward_id = $request->bn_parm_ward_id;
            $employee->bn_parm_holding_name = $request->bn_parm_holding_name;
            $employee->bn_parm_village_name = $request->bn_parm_village_name;
            $employee->bn_parm_post_ofc = $request->bn_parm_post_ofc;
            $employee->bn_parm_phone_my = $request->bn_parm_phone_my;
            $employee->bn_parm_phone_alt = $request->bn_parm_phone_alt;

            $employee->bn_pre_district_id = $request->bn_pre_district_id;
            $employee->bn_pre_upazila_id = $request->bn_pre_upazila_id;
            $employee->bn_pre_union_id = $request->bn_pre_union_id;
            $employee->bn_pre_ward_no = $request->bn_pre_ward_no;
            $employee->bn_pre_holding_no = $request->bn_pre_holding_no;
            $employee->bn_pre_village_name = $request->bn_pre_village_name;
            $employee->bn_pre_post_ofc = $request->bn_pre_post_ofc;
            $employee->bn_identification_mark = $request->bn_identification_mark;
            $employee->bn_edu_qualification = $request->bn_edu_qualification;
            $employee->bn_blood_id = $request->bn_blood_id;
            $employee->bn_dob = $request->bn_dob;
            $employee->bn_age = $request->bn_age;
            $employee->bn_birth_certificate = $request->bn_birth_certificate;
            $employee->bn_nid_no = $request->bn_nid_no;
            $employee->bn_nationality = $request->bn_nationality;
            $employee->bn_religion = $request->bn_religion;
            $employee->bn_height_foot = $request->bn_height_foot;
            $employee->bn_height_inc = $request->bn_height_inc;
            $employee->bn_weight_kg = $request->bn_weight_kg;
            $employee->bn_weight_pounds = $request->bn_weight_pounds;
            $employee->bn_experience = $request->bn_experience;
            $employee->bn_marital_status = $request->bn_marital_status;
            $employee->bn_legacy_name = $request->bn_legacy_name;
            $employee->bn_legacy_relation = $request->bn_legacy_relation;
            $employee->bn_reference_admittee = $request->bn_reference_admittee;
            $employee->bn_reference_adm_phone = $request->bn_reference_adm_phone;
            $employee->bn_reference_adm_adress = $request->bn_reference_adm_adress;
            $employee->bn_applied_position = $request->bn_applied_position;

//   English
            $employee->en_applicants_name = $request->en_applicants_name;
            $employee->en_fathers_name = $request->en_fathers_name;
            $employee->en_mothers_name = $request->en_mothers_name;
            $employee->en_parm_district_id = $request->en_parm_district_id;
            $employee->en_parm_upazila_id = $request->en_parm_upazila_id;
            $employee->en_parm_union_id = $request->en_parm_union_id;
            $employee->en_parm_ward_id = $request->en_parm_ward_id;
            $employee->en_parm_holding_name = $request->en_parm_holding_name;
            $employee->en_parm_village_name = $request->en_parm_village_name;
            $employee->en_parm_post_ofc = $request->en_parm_post_ofc;
            $employee->en_parm_phone_my = $request->en_parm_phone_my;
            $employee->en_parm_phone_alt = $request->en_parm_phone_alt;

            $employee->en_pre_district_id = $request->en_pre_district_id;
            $employee->en_pre_upazila_id = $request->en_pre_upazila_id;
            $employee->en_pre_union_id = $request->en_pre_union_id;
            $employee->en_pre_ward_id = $request->en_pre_ward_id;
            $employee->en_pre_holding_no = $request->en_pre_holding_no;
            $employee->en_pre_village_name = $request->en_pre_village_name;
            $employee->en_pre_post_ofc = $request->en_pre_post_ofc;
            $employee->en_identification_mark = $request->en_identification_mark;
            $employee->en_edu_qualification = $request->en_edu_qualification;
            $employee->en_blood_id = $request->en_blood_id;
            $employee->en_dob = $request->en_dob;
            $employee->en_age = $request->en_age;
            $employee->en_birth_certificate = $request->en_birth_certificate;
            $employee->en_nid_no = $request->en_nid_no;
            $employee->en_nationality = $request->en_nationality;
            $employee->en_religion = $request->en_religion;
            $employee->en_height_foot = $request->en_height_foot;
            $employee->en_height_inc = $request->en_height_inc;
            $employee->en_weight_kg = $request->en_weight_kg;
            $employee->en_weight_pounds = $request->en_weight_pounds;
            $employee->en_experience = $request->en_experience;
            $employee->en_marital_status = $request->en_marital_status;
            $employee->en_legacy_name = $request->en_legacy_name;
            $employee->en_legacy_relation = $request->en_legacy_relation;
            $employee->en_reference_admittee = $request->en_reference_admittee;
            $employee->en_reference_adm_phone = $request->en_reference_adm_phone;
            $employee->en_reference_adm_adress = $request->en_reference_adm_adress;
            $employee->en_applied_position = $request->en_applied_position;
            $employee->bn_cer_gender = $request->bn_cer_gender;
            $employee->bn_cer_physical_ability = $request->bn_cer_physical_ability;

            $employee->bn_spouse_name = $request->bn_spouse_name;
            $employee->bn_song_name = $request->bn_song_name;
            $employee->bn_daughters_name = $request->bn_daughters_name;
            $employee->en_spouse_name = $request->en_spouse_name;
            $employee->en_song_name = $request->en_song_name;
            $employee->en_daughters_name = $request->en_daughters_name;
            if($request->has('concerned_person_sign'))
            $employee->concerned_person_sign=$this->uploadImage($request->concerned_person_sign,'uploads/concerned_person_sign/');
            if($request->has('bn_doctor_sign'))
            $employee->bn_doctor_sign=$this->uploadImage($request->bn_doctor_sign,'uploads/bn_doctor_sign/');

            if($request->has('profile_img'))
            $employee->profile_img=$this->uploadImage($request->profile_img,'uploads/profile_img/');
            if($request->has('signature_img'))
            $employee->signature_img=$this->uploadImage($request->signature_img,'uploads/signature_img/');

            if ($employee->save()) {
                return redirect()->route('employee.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }

            // if($employee->save()){
            //     if($request->bn_song_name || $request->bn_daughters_name){
            //         foreach($request->bn_spouse_name as $key => $value){
            //             // dd($request->all());
            //             if($value){
            //                 $details = new EmployeeDetails;
            //                 $details->employee_id=$employee->id;
            //                 $details->bn_song_name=$request->bn_song_name[$key];
            //                 $details->bn_daughters_name=$request->bn_daughters_name[$key];
            //                 $details->save();
            //             }
            //         }
            //     }
            // Toastr::success('Create Successfully!');
            // return redirect()->route('employee.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            // } else{
            // Toastr::warning('Please try Again!');
            // return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            // }
        } catch (Exception $e) {
            dd($e);
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
        $security=SecurityPriorAcquaintance::where('employee_id',encryptor('decrypt', $id))->first();
        return view('employee.show', compact('employees','security'));
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
        return view('employee.security-prior-acquaintance',compact('employees','districts','upazila'));
    }

    public function securityGuardsStore(Request $request)
    {
        try{
            $security=new SecurityPriorAcquaintance;
            $security->employee_id=$request->employee_id;
            $security->bn_in_laws_district_id=$request->bn_in_laws_district_id;
            $security->bn_in_laws_upazilla_id=$request->bn_in_laws_upazilla_id;
            $security->bn_in_laws_village_name=$request->bn_in_laws_village_name;
            $security->bn_in_laws_post_office=$request->bn_in_laws_post_office;
            $security->bn_husband_profession=$request->bn_husband_profession;
            $security->bn_father_profession=$request->bn_father_profession;
            $security->bn_landlord_name=$request->bn_landlord_name;
            $security->bn_landlord_mobile_no=$request->bn_landlord_mobile_no;
            $security->bn_living_dur=$request->bn_living_dur;
            $security->bn_passport_no=$request->bn_passport_no;
            $security->bn_old_office_name=$request->bn_old_office_name;
            $security->bn_old_office_address=$request->bn_old_office_address;
            $security->bn_resign_reason=$request->bn_resign_reason;
            $security->bn_resign_letter_status=$request->bn_resign_letter_status;
            $security->bn_service_book_status=$request->bn_service_book_status;
            $security->bn_service_book_no=$request->bn_service_book_no;
            $security->bn_old_job_salary=$request->bn_old_job_salary;
            $security->bn_old_job_last_desig=$request->bn_old_job_last_desig;
            $security->bn_old_job_experience=$request->bn_old_job_experience;
            $security->bn_new_job_transportation=$request->bn_new_job_transportation;
            $security->bn_current_living=$request->bn_current_living;
            $security->bn_total_member=$request->bn_total_member;
            $security->bn_mobile_no=$request->bn_mobile_no;
            $security->bn_solvent_person=$request->bn_solvent_person;
            $security->bn_sim_card_reg_status=$request->bn_sim_card_reg_status;
            $security->bn_case_filed_status=$request->bn_case_filed_status;
            $security->bn_old_job_officer_name=$request->bn_old_job_officer_name;
            $security->bn_old_job_officer_mobile=$request->bn_old_job_officer_mobile;
            $security->bn_old_job_officer_post=$request->bn_old_job_officer_post;
            $security->bn_identifier_name1=$request->bn_identifier_name1;
            $security->bn_identifier_occupation1=$request->bn_identifier_occupation1;
            $security->bn_identifier_address1=$request->bn_identifier_address1;
            $security->bn_identifier_phone1=$request->bn_identifier_phone1;
            $security->bn_identifier_name2=$request->bn_identifier_name2;
            $security->bn_identifier_occupation2=$request->bn_identifier_occupation2;
            $security->bn_identifier_address2=$request->bn_identifier_address2;
            $security->bn_identifier_phone2=$request->bn_identifier_phone2;
            if($request->has('informant_sing'))
            $security->informant_sing=$this->uploadImage($request->informant_sing,'uploads/informant_sing/');
            if($request->has('data_collector_sing'))
            $security->data_collector_sing=$this->uploadImage($request->data_collector_sing,'uploads/data_collector_sing/');
            if($request->has('executive_sing'))
            $security->executive_sing=$this->uploadImage($request->executive_sing,'uploads/executive_sing/');
            if($request->has('manager_sing'))
            $security->manager_sing=$this->uploadImage($request->manager_sing,'uploads/manager_sing/');
            if($security->save())
            return redirect()->route('employee.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            else
                return redirect()->back()->withInput()->with($this->resMessageHtml(false,'error','please try again'));
        }catch(Exception $e){
            // dd($e);
            return redirect()->back()->withInput()->with($this->resMessageHtml(false,'error','Please try again'));
        }
    }
}
