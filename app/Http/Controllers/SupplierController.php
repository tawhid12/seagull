<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use App\Http\Requests\Supplier\AddNewRequest;
use App\Http\Requests\Supplier\UpdateRequest;
use App\Models\Product;
use Toastr;
use DB;
class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(15);
        return view('supplier.index', compact('suppliers'));
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
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*echo '<pre>';
print_r($request->toArray());die;*/
        try {
            DB::beginTransaction();
            $sup = New Supplier();
            $sup->supplier_name = $request->supplier_name;
            $sup->phone = $request->phone;
            $sup->mobile = $request->mobile;
            $sup->email = $request->email;
            //$c->vessel_id = $request->vessel_id;
            $sup->fax = $request->fax;
            $sup->web = $request->web;
            $sup->address = $request->address;
            $sup->address = $request->address;
            $sup->tin = $request->tin;
            $sup->tin_name = $request->tin_name;
            $sup->bin = $request->bin;
            $sup->bin_name = $request->bin_name;
            $sup->contact_person_name = $request->contact_person_name;
            $sup->contact_person_phone = $request->contact_person_phone;
            $sup->contact_person_email = $request->contact_person_email;
            $sup->created_by=currentUserId();
            if($sup->save()){
                $id_child_one = Child_one::where('head_code','2130')/*->where(company())*/->first();
                $ach = new Child_two;
                $ach->child_one_id= $id_child_one->id;
                $ach->head_name=$request->supplier_name;
                $ach->head_code = '2130'.$sup->id;
                $ach->opening_balance =$request->openingAmount ?? 0;
                $ach->created_by=currentUserId();
                if($ach->save()) {
                    $sup->account_id = $ach->id;
                    $sup->save();
                    DB::commit();
                    \LogActivity::addToLog('Add Supplier', $request->getContent(), 'Supplier');
                    return redirect()->route('supplier.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
                }else
                    return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }else{
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
