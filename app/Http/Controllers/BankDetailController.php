<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use App\Models\Company;
use Illuminate\Http\Request;
use Toastr;
class BankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = BankDetail::with('company')->latest()->paginate(15);
        return view('bank.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::get();
        return view('bank.create',compact('companies'));
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
            $bd = New BankDetail();
            $bd->bank_name = $request->bank_name;
            $bd->branch = $request->branch;
            $bd->district = $request->district;
            $bd->account_name = $request->account_name;
            $bd->account_no = $request->account_no;
            $bd->swift_code = $request->swift_code;
            $companyData = company();
            $bd->company_id=$companyData['company_id'];
            $bd->created_by=currentUserId();
            if($bd->save()){
                \LogActivity::addToLog('Add Bank Detail',$request->getContent(),'Bank Detail');
                return redirect()->route('bank.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function show(BankDetail $bankDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bd=BankDetail::findOrFail(encryptor('decrypt',$id));
        return view('bank.edit',compact('bd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $bd = BankDetail::findOrFail(encryptor('decrypt',$id));
            $bd->bank_name = $request->bank_name;
            $bd->branch = $request->branch;
            $bd->district = $request->district;
            $bd->account_name = $request->account_name;
            $bd->account_no = $request->account_no;
            $bd->swift_code = $request->swift_code;
            $companyData = company();
            $bd->company_id=$companyData['company_id'];
            $bd->created_by=currentUserId();
            if($bd->save()){
                \LogActivity::addToLog('Add Bank Detail',$request->getContent(),'Bank Detail');
                return redirect()->route('bank.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\BankDetail  $bankDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankDetail $bankDetail)
    {
        //
    }
}
