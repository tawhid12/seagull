<?php

namespace App\Http\Controllers;

use App\Models\Requisiton;
use Illuminate\Http\Request;
use App\Http\Requests\OtherRequisition\AddNewRequest;
use App\Http\Requests\OtherRequisition\UpdateRequest;
use Toastr;

class OtherRequisitonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('otherRequisition.create');
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
            $r = New Requisiton();
            $r->req_slip_no = $request->req_slip_no;
            $r->title = $request->title;
            $r->postingDate = date('y-m-d',strtotime($request->postingDate));
            $r->client_id = 0;
            $r->vessel_id = 0;
            $r->product_id = 0;
            $r->qty = 0;
            $r->amount = $request->amount;
            $r->des = $request->des;
            $r->req_type = 2;
            $companyData = company();
            $r->company_id=$companyData['company_id'];
            $r->created_by=currentUserId();
            if($r->save()){
                \LogActivity::addToLog('Add Product Requisition',$request->getContent(),'Requisition');
                return redirect()->route('requisition.index', ['role' =>currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Requisiton  $requisiton
     * @return \Illuminate\Http\Response
     */
    public function show(Requisiton $requisiton)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Requisiton  $requisiton
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisiton $requisiton)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Requisiton  $requisiton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requisiton $requisiton)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Requisiton  $requisiton
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisiton $requisiton)
    {
        //
    }
}
