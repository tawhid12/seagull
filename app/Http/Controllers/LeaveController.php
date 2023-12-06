<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\Leave\Leave;
use App\Models\LeaveType;
use App\Models\TotalLeavePerYear;
use Illuminate\Http\Request;
use App\http\Requests\Leave\AddNewRequest;
use App\http\Requests\Leave\UpdateNewRequest;
use App\Models\Attendance;
use Toastr;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::whereNull('resign_date')->get();
        $leave_types = LeaveType::get();
        $leaves = Leave::with(['leave_type', 'employee'])->paginate(15);
        return view('leave.index', compact('leaves', 'employees', 'leave_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leave_types = LeaveType::get();
        $employees = Employee::whereNull('resign_date')->get();
        return view('leave.create', compact('employees', 'leave_types'));
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
            $date_range = explode('-', $request->date_range);
            $from = \Carbon\Carbon::createFromTimestamp(strtotime($date_range[0]))->format('Y-m-d');
            $to = \Carbon\Carbon::createFromTimestamp(strtotime($date_range[1]))->format('Y-m-d');

            $l = new Leave();
            $l->employee_id = $request->employee_id;
            $l->leave_type_id  = $request->leave_type_id;
            $l->from_date = $from;
            $l->to_date = $to;
            $l->created_by = currentUser();
            if ($l->save()) {
                \LogActivity::addToLog('Add Leave', $request->getContent(), 'Leave');
                return redirect()->route('leave.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Leave\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Leave\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $l = Leave::findOrFail(encryptor('decrypt', $id));
        $leave_types = LeaveType::get();
        $employees = Employee::whereNull('resign_date')->get();
        return view('leave.edit', compact('l', 'employees', 'leave_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Leave\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewRequest $request, $id)
    {
        try {
            $date_range = explode('-', $request->date_range);
            $from = \Carbon\Carbon::createFromTimestamp(strtotime($date_range[0]))->format('Y-m-d');
            $to = \Carbon\Carbon::createFromTimestamp(strtotime($date_range[1]))->format('Y-m-d');
            $year = \Carbon\Carbon::createFromTimestamp(strtotime($date_range[0]))->format('Y');

            $l = Leave::findOrFail(encryptor('decrypt', $id));
            $l->employee_id = $request->employee_id;
            $l->leave_type_id  = $request->leave_type_id;
            $l->from_date = $from;
            $l->to_date = $to;
            $l->updated_by = currentUserId();
            /*Determine Type of Leave */
            $total_leave_allow_per_year = TotalLeavePerYear::where(function ($query) use ($year, $request) {
                $query->where('leave_year', '=', $year)
                    ->where('leave_type_id', '=', $request->leave_type_id);
            })->first();
            /*===== Count Particular Employee Taken Leave ======*/
            $leave_use = Leave::whereYear('from_date', $year)
                ->whereYear('to_date', $year)
                ->where('leave_type_id', $request->leave_type_id)
                ->selectRaw('DATEDIFF(`to_date`, `from_date`) + 1 AS days_in_range');

            /*$sql = $leave_use->toSql();
            $bindings = $leave_use->getBindings();
            
            \Log::info("Generated SQL: " . $sql);
            \Log::info("Bindings: " . json_encode($bindings));*/

            $leave_use = $leave_use->first();


            $leave_use = Leave::whereYear('from_date', $year)
                ->whereYear('to_date', $year)
                ->where('leave_type_id', $request->leave_type_id)
                ->selectRaw('DATEDIFF(`to_date`, `from_date`) + 1 AS days_in_range')
                ->first();

            if ($leave_use->days_in_range <= $total_leave_allow_per_year->total_leave_days) {
                // Create Carbon instances from the formatted dates
                $from_date = \Carbon\Carbon::parse($from);
                $to_date = \Carbon\Carbon::parse($to);
                $all_dates = [];
                while ($from_date->lte($to_date)) {
                    $all_dates[] = $from_date->toDateString();
                    $from_date->addDay();
                }
                //print_r($all_dates);die;
                $recordsExist = Attendance::where('employee_id', $request->employee_id)->whereIn('postingDate', $all_dates)->exists();
                if ($recordsExist) {
                    Attendance::where('employee_id', $request->employee_id)->whereIn('postingDate', $all_dates)->update(['isPresent' => 4]);
                    $l->status = 1;
                } else {
                    $l->status = 1;
                }
            } else {
            }
            if ($l->save()) {
                \LogActivity::addToLog('Update Leave', $request->getContent(), 'Leave');
                return redirect()->route('leave.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Leave\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
