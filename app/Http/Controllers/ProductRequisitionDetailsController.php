<?php

namespace App\Http\Controllers;

use App\Models\ProductRequisitionDetails;
use Illuminate\Http\Request;
use Toastr;
use DB;
class ProductRequisitionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProductRequisitionDetails $productRequisitionDetails
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRequisitionDetails $productRequisitionDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProductRequisitionDetails $productRequisitionDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRequisitionDetails $productRequisitionDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductRequisitionDetails $productRequisitionDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRequisitionDetails $productRequisitionDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProductRequisitionDetails $productRequisitionDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $prd = ProductRequisitionDetails::findOrFail(encryptor('decrypt', $id));
            if (ProductRequisitionDetails::destroy(encryptor('decrypt', $id))) {
                $prd->updated_by = currentUserId();
                $prd->save();
                \LogActivity::addToLog('Delete Product Requisition', $request->getContent(), 'Product Requisition');
                return redirect()->back()->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }
}
