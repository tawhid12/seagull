<?php

namespace App\Http\Controllers;

use App\Models\AccountMaster;
use App\Models\AccountMasterSub;
use Illuminate\Http\Request;
use App\Http\Requests\AccountMasterSub\AddNewRequest;
use App\Http\Requests\AccountMasterSub\UpdateRequest;
use Toastr;

class AccountMasterSubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountMasterSub = AccountMasterSub::latest()->paginate(15);
        return view('accountMasterSub.index', compact('accountMasterSub'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountMaster = AccountMaster::get();
        return view('accountMasterSub.create',compact('accountMaster'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewRequest $request)
    {
        //print_r($request->all());die;
        try {
            $ams = New AccountMasterSub();
            $ams->fcoa_master_id = $request->fcoa_master_id;
            $ams->fcoa = $request->fcoa;
            $ams->fcoa_code = $request->fcoa_code;
            $ams->fcoa_balance = $request->fcoa_balance;
            $ams->created_by=currentUserId();
            if($ams->save()){
                \LogActivity::addToLog('Add Master Sub Account',$request->getContent(),'Master Sub Account');
                return redirect()->route('accountMasterSub.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\AccountMasterSub  $accountMasterSub
     * @return \Illuminate\Http\Response
     */
    public function show(AccountMasterSub $accountMasterSub)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountMasterSub  $accountMasterSub
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountMasterSub $accountMasterSub)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountMasterSub  $accountMasterSub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountMasterSub $accountMasterSub)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountMasterSub  $accountMasterSub
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountMasterSub $accountMasterSub)
    {
        //
    }
}
