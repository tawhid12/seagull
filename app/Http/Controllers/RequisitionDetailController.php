<?php

namespace App\Http\Controllers;

use App\Models\ORder;
use App\Models\Requisition;
use App\Models\RequisitionDetail;
use Illuminate\Http\Request;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use Toastr;
use DB;

class RequisitionDetailController extends Controller
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
    public function create(Request $request)
    {
        $r = Requisition::withSum('requisition_detl', 'approve_amount')->findOrFail(encryptor('decrypt', $request->id));
        $orders = Order::where(company())->get();
        $paymethod = array();
        $account_data = Child_one::whereIn('head_code', [4101])/*->where(company())*/->get();


        if ($account_data) {
            foreach ($account_data as $ad) {
                $shead = Child_two::where('child_one_id', $ad->id);
                if ($shead->count() > 0) {
                    $shead = $shead->get();
                    foreach ($shead as $sh) {
                        $paymethod[] = array(
                            'id' => $sh->id,
                            'head_code' => $sh->head_code,
                            'head_name' => $sh->head_name,
                            'table_name' => 'child_twos'
                        );
                    }
                } else {
                    $paymethod[] = array(
                        'id' => $ad->id,
                        'head_code' => $ad->head_code,
                        'head_name' => $ad->head_name,
                        'table_name' => 'child_ones'
                    );
                }
            }
        }
        return view('requisition-detl.create', compact('r', 'orders','paymethod'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $r = Requisition::withSum('requisition_detl', 'approve_amount')->findOrFail(encryptor('decrypt', $request->requisition_id));
        if ($request->approve_amount == 0) {
            return redirect()->back()->withInput()->with(Toastr::error('Approve Amount should Be greater than Zero', 'Fail', ["positionClass" => "toast-top-right"]));
        }
        DB::beginTransaction();
        try {
            $rd = new RequisitionDetail();
            $rd->requisition_id = encryptor('decrypt', $request->requisition_id);
            $rd->approve_amount = $request->approve_amount;
            $rd->postingDate = date('y-m-d', strtotime($request->postingDate));
            $rd->des = $request->des;
            $rd->created_by = currentUserId();
            if ($rd->save()) {
                if ($request->approve_amount < ($r->order_amount - $r->requisition_detl_sum_approve_amount))
                    $status = 2;
                elseif ($request->approve_amount == ($r->order_amount - $r->requisition_detl_sum_approve_amount)) {
                    $status = 1;
                }
                Requisition::where('id', encryptor('decrypt', $request->requisition_id))->update(['status' => $status, 'updated_by' => currentUserId()]);

                DB::commit();
                \LogActivity::addToLog('Add Rquisition Detail', $request->getContent(), 'Requisition Detail');
                return redirect()->route('requisition.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
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
     * @param  \App\Models\RequisitionDetail  $requisitionDetail
     * @return \Illuminate\Http\Response
     */
    public function show(RequisitionDetail $requisitionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequisitionDetail  $requisitionDetail
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequisitionDetail  $requisitionDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $rd = RequisitionDetail::findOrFail($id);
            if ($request->approve == 1) {
                $rd->status = 1;
                $rd->approved_by = currentUserId();
            }
            if ($rd->save()) {
                \LogActivity::addToLog('Requisition Approved', $request->getContent(), 'Requisition');
                return redirect()->back()->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
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
     * @param  \App\Models\RequisitionDetail  $requisitionDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequisitionDetail $requisitionDetail)
    {
        //
    }
}
