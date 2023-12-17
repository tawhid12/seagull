<?php

namespace App\Http\Controllers;

use App\Models\TotalWorkingDay;
use Illuminate\Http\Request;
use Toastr;

class TotalWorkingDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_working_day = TotalWorkingDay::paginate(10);
        return view('leave.total_working_day.index', compact('total_working_day'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leave.total_working_day.create');
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
            $twd = New TotalWorkingDay();
            $twd->total_working_day = $request->total_working_day;
            $twd->month = $request->month;
            $twd->year = $request->year;
            if ($twd->save()) {
                \LogActivity::addToLog('Add Total Working Day', $request->getContent(), 'Total Wokring Day');
                return redirect()->route('total-working-day.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\TotalWorkingDay  $totalWorkingDay
     * @return \Illuminate\Http\Response
     */
    public function show(TotalWorkingDay $totalWorkingDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TotalWorkingDay  $totalWorkingDay
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $twd = TotalWorkingDay::findOrFail(encryptor('decrypt', $id));
        return view('leave.total_working_day.edit', compact('twd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TotalWorkingDay  $totalWorkingDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $twd = TotalWorkingDay::findorFail(encryptor('decrypt', $id));
            $twd->total_working_day = $request->total_working_day;
            $twd->month = $request->month;
            $twd->year = $request->year;
            if ($twd->save()) {
                \LogActivity::addToLog('Update Total Working Day', $request->getContent(), 'Total Wokring Day');
                return redirect()->route('total-working-day.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\TotalWorkingDay  $totalWorkingDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(TotalWorkingDay $totalWorkingDay)
    {
        //
    }
}
