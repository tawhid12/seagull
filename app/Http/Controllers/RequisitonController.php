<?php

namespace App\Http\Controllers;

use App\Models\Requisiton;
use Illuminate\Http\Request;
use App\Http\Requests\Requisition\AddNewRequest;
use App\Http\Requests\Requisition\UpdateRequest;
use App\Models\Product;
use App\Models\Client;
use App\Models\Vessel;
use Toastr;
class RequisitonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitions = Requisiton::latest()->paginate(15);
        return view('requisition.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyData = company();
        $products = Product::where('company_id',$companyData['company_id'])->get();
        $clients = Client::where('company_id',$companyData['company_id'])->get();
        $vessels = Vessel::where('company_id',$companyData['company_id'])->get();
        return view('requisition.create',compact('products','clients','vessels'));
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
            $r->postingDate = date('y-m-d',strtotime($request->postingDate));
            $r->client_id = $request->client_id;
            $r->vessel_id = $request->vessel_id;
            $r->product_id = $request->product_id;
            $r->qty = $request->qty;
            $r->amount = $request->amount;
            $r->des = $request->des;
            $r->req_type = 1;
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
