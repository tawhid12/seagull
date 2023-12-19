<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\DeliveryReport;
use Illuminate\Http\Request;
use App\Http\Traits\ImageHandleTraits;
use Toastr;

class DeliveryReportController extends Controller
{
    use ImageHandleTraits;
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
        $or = Order::with('service_report')->findOrFail($request->get('id'));
        return view('delivery_report.create', compact('or'));
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
            $dr = New DeliveryReport();
            if ($request->has('delivery_report')) $dr->file_name = 'uploads/delivery_report/'.$this->uploadImage($request->file('delivery_report'), 'uploads/delivery_report');
            $dr->order_id = $request->order_id;
            $dr->created_by = currentUserId();
            if ($dr->save()) {
                \LogActivity::addToLog('Upload Delivery Report', $request->getContent(), 'Delivery Report');
                return redirect()->route('order.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
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
     * @param  \App\Models\DeliveryReport  $deliveryReport
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryReport $deliveryReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryReport  $deliveryReport
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryReport $deliveryReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryReport  $deliveryReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryReport $deliveryReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryReport  $deliveryReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryReport $deliveryReport)
    {
        //
    }
}
