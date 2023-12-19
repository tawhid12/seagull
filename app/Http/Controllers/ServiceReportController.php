<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ServiceReport;
use Illuminate\Http\Request;
use App\Http\Traits\ImageHandleTraits;
use Toastr;
class ServiceReportController extends Controller
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
        return view('service_report.create', compact('or'));
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
            $sr = New ServiceReport();
            if ($request->has('service_report')) $sr->file_name = 'uploads/service_report/'.$this->uploadImage($request->file('service_report'), 'uploads/service_report');
            $sr->order_id = $request->order_id;
            $sr->created_by = currentUserId();
            if ($sr->save()) {
                \LogActivity::addToLog('Upload Service Report', $request->getContent(), 'Service Report');
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
     * @param  \App\Models\ServiceReport  $serviceReport
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceReport $serviceReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServiceReport  $serviceReport
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceReport $serviceReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServiceReport  $serviceReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceReport $serviceReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServiceReport  $serviceReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServiceReport $serviceReport)
    {
        //
    }
}
