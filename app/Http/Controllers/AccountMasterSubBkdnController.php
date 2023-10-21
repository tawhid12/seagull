<?php

namespace App\Http\Controllers;

use App\Models\AccountMasterSubBkdn;
use App\Models\AccountMasterSub;
use Illuminate\Http\Request;
use App\Http\Requests\AccountMasterSubBkdn\AddNewRequest;
use App\Http\Requests\AccountMasterSubBkdn\UpdateRequest;
use Toastr;

class AccountMasterSubBkdnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountMasterSubBkdn = AccountMasterSubBkdn::latest()->paginate(15);
        return view('accountMasterSubBkdn.index', compact('accountMasterSubBkdn'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountMasterSub = AccountMasterSub::get();
        return view('accountMasterSubBkdn.create',compact('accountMasterSub'));
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
            $amsb = New AccountMasterSubBkdn();
            $amsb->fcoa_id = $request->fcoa_id;
            $amsb->fcoa_bkdn = $request->fcoa_bkdn;
            $amsb->bkdn_code = $request->bkdn_code;
            $amsb->bkdn_balance = $request->bkdn_balance;
            $amsb->created_by=currentUserId();
            if($amsb->save()){
                \LogActivity::addToLog('Add Master Sub One',$request->getContent(),'Master Sub One');
                return redirect()->route('accountMasterSubBkdn.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\AccountMasterSubBkdn  $accountMasterSubBkdn
     * @return \Illuminate\Http\Response
     */
    public function show(AccountMasterSubBkdn $accountMasterSubBkdn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountMasterSubBkdn  $accountMasterSubBkdn
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountMasterSubBkdn $accountMasterSubBkdn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountMasterSubBkdn  $accountMasterSubBkdn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountMasterSubBkdn $accountMasterSubBkdn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountMasterSubBkdn  $accountMasterSubBkdn
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountMasterSubBkdn $accountMasterSubBkdn)
    {
        //
    }
}
