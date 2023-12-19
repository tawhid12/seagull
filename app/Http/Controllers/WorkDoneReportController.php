<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\WorkDoneReport;
use Illuminate\Http\Request;
use App\Http\Traits\ImageHandleTraits;
use Toastr;

class WorkDoneReportController extends Controller
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
        $or = Order::with('work_done_report')->findOrFail($request->get('id'));
        return view('work_done.create', compact('or'));
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
            $wrk = New WorkDoneReport();
            if ($request->has('work_done_report')) $wrk->file_name = 'uploads/work_done_report/'.$this->uploadImage($request->file('work_done_report'), 'uploads/work_done_report');
            $wrk->order_id = $request->order_id;
            $wrk->created_by = currentUserId();
            if ($wrk->save()) {
                \LogActivity::addToLog('Upload Work Report', $request->getContent(), 'Work Report');
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
     * @param  \App\Models\WorkDoneReport  $workDoneReport
     * @return \Illuminate\Http\Response
     */
    public function show(WorkDoneReport $workDoneReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkDoneReport  $workDoneReport
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkDoneReport $workDoneReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkDoneReport  $workDoneReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkDoneReport $workDoneReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkDoneReport  $workDoneReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkDoneReport $workDoneReport)
    {
        //
    }
}
