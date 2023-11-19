<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Models\TotalLeavePerYear;
use Illuminate\Http\Request;
use Toastr;
class TotalLeavePerYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_leave_per_year = TotalLeavePerYear::with('leave_type')->paginate(10);
        return view('leave.total_leave_per_year.index',compact('total_leave_per_year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leave_types = LeaveType::get();
        return view('leave.total_leave_per_year.create',compact('leave_types'));
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
            $tlpy = New TotalLeavePerYear();
            $tlpy->leave_type_id = $request->leave_type_id;
            $tlpy->leave_year = $request->leave_year;
            $tlpy->total_leave_days = $request->total_leave_days;
            
            if($tlpy->save()){
                \LogActivity::addToLog('Total Leave Days',$request->getContent(),'Total Leave Days');
                return redirect()->route('total-leave-per-year.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\TotalLeavePerYear  $totalLeavePerYear
     * @return \Illuminate\Http\Response
     */
    public function show(TotalLeavePerYear $totalLeavePerYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TotalLeavePerYear  $totalLeavePerYear
     * @return \Illuminate\Http\Response
     */
    public function edit(TotalLeavePerYear $totalLeavePerYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TotalLeavePerYear  $totalLeavePerYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TotalLeavePerYear $totalLeavePerYear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TotalLeavePerYear  $totalLeavePerYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(TotalLeavePerYear $totalLeavePerYear)
    {
        //
    }
}
