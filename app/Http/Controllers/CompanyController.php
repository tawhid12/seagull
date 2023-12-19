<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\Company\AddNewRequest;
use App\Http\Requests\Company\UpdateRequest;
use Toastr;
use Session;
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::with('banks')->latest()->paginate(15);
        return view('company.index', compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
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
            $c = New Company();
            $c->company_name = $request->company_name;
            $c->website = $request->website;
            $c->tax_no = $request->tax_no;
            $c->address = $request->address;
            $c->city = $request->city;
            $c->country = $request->country;
            $c->zip_code = $request->zip_code;
            $c->email = $request->email;
            $c->contact_no = $request->contact_no;
            $c->created_by=currentUserId();
            if($c->save()){
                \LogActivity::addToLog('Add Company',$request->getContent(),'Company');
                return redirect()->route('company.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $c=Company::findOrFail(encryptor('decrypt',$id));
        return view('company.edit',compact('c'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $c = Company::findOrFail(encryptor('decrypt',$id));
            $c->company_name = $request->company_name;
            $c->website = $request->website;
            $c->tax_no = $request->tax_no;
            $c->address = $request->address;
            $c->city = $request->city;
            $c->country = $request->country;
            $c->zip_code = $request->zip_code;
            $c->email = $request->email;
            $c->contact_no = $request->contact_no;
            $c->created_by=currentUserId();
            if($c->save()){
                \LogActivity::addToLog('Update Company',$request->getContent(),'Company');
                return redirect()->route('company.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }


    public function secretLogin($id){
        // Remove the 'companyId' key from the session
        Session::forget('companyId');
        $company = Company::find($id);
        if($company){
            request()->session()->put(
                ['companyId' => encryptor('encrypt', $company->id),]
            );
            /*echo '<pre>';
            print_r(\request()->session());die;*/
            if(Session::get('redirected_from'))
            return redirect()->to(Session::get('redirected_from'));
            //return redirect()->to($request->fullUrl());
            else
           return redirect(route('dashboard'))->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        }else
        return redirect()->back()->with($this->responseMessage(false, "error", 'Something Went Wrong!!'));
    }
}
