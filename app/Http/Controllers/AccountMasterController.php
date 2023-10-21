<?php

namespace App\Http\Controllers;

use App\Models\AccountMaster;
use Illuminate\Http\Request;
use App\Http\Requests\AccountMaster\AddNewRequest;
use App\Http\Requests\AccountMaster\UpdateRequest;
use Toastr;
class AccountMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountMaster = AccountMaster::latest()->paginate(15);
        return view('accountMaster.index', compact('accountMaster'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accountMaster.create');
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
            $am = New AccountMaster();
            $am->fcoa_master = $request->fcoa_master;
            $am->master_code = $request->master_code;
            $am->master_balance = $request->master_balance;
            $am->created_by=currentUserId();
            if($am->save()){
                \LogActivity::addToLog('Add Master Account',$request->getContent(),'Master Account');
                return redirect()->route('accountMaster.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\AccountMaster  $accountMaster
     * @return \Illuminate\Http\Response
     */
    public function show(AccountMaster $accountMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountMaster  $accountMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountMaster $accountMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountMaster  $accountMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountMaster $accountMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountMaster  $accountMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountMaster $accountMaster)
    {
        //
    }
}
