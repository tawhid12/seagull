<?php

namespace App\Http\Controllers;

use App\Models\AccountMasterSubBkdn;
use App\Models\AccountMasterSubBkdnSub;
use Illuminate\Http\Request;
use App\Http\Requests\AccountMasterSubBkdnSub\AddNewRequest;
use App\Http\Requests\AccountMasterSubBkdnSub\UpdateRequest;
use Toastr;

class AccountMasterSubBkdnSubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accountMasterSubBkdnSub = AccountMasterSubBkdnSub::latest()->paginate(15);
        return view('accountMasterSubBkdnSub.index', compact('accountMasterSubBkdnSub'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accountMasterSubBkdn = AccountMasterSubBkdn::get();
        return view('accountMasterSubBkdnSub.create',compact('accountMasterSubBkdn'));
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
            $amsb = New AccountMasterSubBkdnSub();
            $amsb->fcoa_bkdn_id = $request->fcoa_bkdn_id;
            $amsb->fcoa_bkdn_sub = $request->fcoa_bkdn_sub;
            $amsb->sub_code = $request->sub_code;
            $amsb->sub_balance = $request->sub_balance;
            $amsb->created_by=currentUserId();
            if($amsb->save()){
                \LogActivity::addToLog('Add Master Sub Two',$request->getContent(),'Master Sub Two');
                return redirect()->route('accountMasterSubBkdnSub.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\AccountMasterSubBkdnSub  $accountMasterSubBkdnSub
     * @return \Illuminate\Http\Response
     */
    public function show(AccountMasterSubBkdnSub $accountMasterSubBkdnSub)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountMasterSubBkdnSub  $accountMasterSubBkdnSub
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountMasterSubBkdnSub $accountMasterSubBkdnSub)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountMasterSubBkdnSub  $accountMasterSubBkdnSub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountMasterSubBkdnSub $accountMasterSubBkdnSub)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountMasterSubBkdnSub  $accountMasterSubBkdnSub
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountMasterSubBkdnSub $accountMasterSubBkdnSub)
    {
        //
    }
}
