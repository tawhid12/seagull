<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;
use App\Http\Traits\ResponseTrait;
use App\Models\Employee\Employee;
use Exception;
use Toastr;
use Log;
class AttendanceController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //print_r($request->toArray());die;
        if (isset($request->date_range)) {
            $date_range = explode('-', $request->date_range);
            $from = \Carbon\Carbon::createFromTimestamp(strtotime($date_range[0]))->format('Y-m-d');
            $to = \Carbon\Carbon::createFromTimestamp(strtotime($date_range[1]))->format('Y-m-d');
            //print_r($date_range);die;
            $postingDate = Attendance::whereBetween('postingDate', [$from, $to]);
            //Log::info($postingDate->toSql(), $postingDate->getBindings());
        } elseif (isset($request->month)) {
            $postingDate = Attendance::whereMonth('postingDate', $request->month);
        } elseif (isset($request->year)) {
            $postingDate = Attendance::whereYear('postingDate', $request->year);
        } else {
            $postingDate = Attendance::whereMonth('postingDate', '=', now()->month);
        }
        $postingDate = $postingDate->orderBy('postingDate', 'asc')->groupBy('postingDate')->get();
        /*echo '<pre>';
        print_r($postingDate);
        echo '</pre>';*/
        $employees = Employee::whereNull('resign_date')->get();
        return view('attendance.report.month_wise', compact('postingDate', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendance.report.attendance_store');
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
        print_r($request->toArray());
        echo '</pre>';
        die;*/
        $attendance_exists = Attendance::where('postingDate', \Carbon\Carbon::createFromTimestamp(strtotime($request->postingDate))->format('Y-m-d'))->first();
        if ($attendance_exists) {
            return redirect()->back()->with($this->responseMessage(false, null, 'Attendance Already Exists For This Date'));
        }
        try {
            $employee_id       = $request->post('employee_id');
            $isPresent         = $request->post('isPresent');
            foreach ($employee_id as $key => $e) {
                $attendance['employee_id'] = $e;
                $attendance['postingDate'] = Carbon::parse($request->postingDate)->format('Y-m-d');
                $attendance['isPresent']   = isset($isPresent[$e]) ? $isPresent[$e] : 0;
                $attendance['created_by'] = currentUserId();
                $attendance['created_at'] = Carbon::now();
                DB::table('attendances')->insert($attendance);
            }
            \LogActivity::addToLog('Add Product', $request->getContent(), 'Product');
            return redirect()->route('attendance.index')->with(Toastr::success('Attendance Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $attendance = Attendance::where('batch_id', $id)->where('postingDate', \Carbon\Carbon::createFromTimestamp(strtotime($request->postingDate))->format('Y-m-d'))->first();
        if (!$attendance->edit_allow) {
            return redirect()->back()->with($this->responseMessage(false, null, 'Attendance Edit Not Allowed'));
        }
        $all_students = DB::table('student_batches')->where('batch_id', $id)->where('status', 2)->where('is_drop', 0)->get();
        return view('attendance.edit', compact('id', 'all_students'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            if ($request->type == 1)
                $attendance = DB::table('attendances')->where('batch_id', $id)->where('postingDate', \Carbon\Carbon::createFromTimestamp(strtotime($request->postingDate))->format('Y-m-d'))->update(['edit_allow' => 1]);
            else {
                $attendance = DB::table('attendances')->where('batch_id', $id)->where('postingDate', \Carbon\Carbon::createFromTimestamp(strtotime($request->postingDate))->format('Y-m-d'))->delete();
                /*echo '<pre>';
                print_r($attendance);
                die;*/
                $student_id       = $request->post('student_id');
                $batch_id         = $request->post('batch_id');
                $isPresent             = $request->post('isPresent');
                foreach ($student_id as $key => $st) {
                    $att['student_id'] = $st;
                    $att['postingDate'] = Carbon::parse($request->postingDate)->format('Y-m-d');
                    $att['batch_id']   = $batch_id[$key];
                    $att['trainer_id']   = currentUserId();
                    $att['isPresent']   = isset($isPresent[$st]) ? $isPresent[$st] : 0;
                    $att['created_by'] = currentUserId();
                    $att['created_at'] = Carbon::now();
                    DB::table('attendances')->insert($att);
                }
            }
            if ($attendance) return redirect(route(currentUser() . '.attendance.index'))->with($this->responseMessage(true, null, 'Attendance Updated'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with($this->responseMessage(false, 'error', 'Please try again!'));
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $attendance = DB::table('attendances')->where('batch_id', $id)->where('postingDate', \Carbon\Carbon::createFromTimestamp(strtotime($request->postingDate))->format('Y-m-d'))->delete();
            if ($attendance) return redirect(route(currentUser() . '.attendance.index'))->with($this->responseMessage(true, null, 'Attendance Deleted'));
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with($this->responseMessage(false, 'error', 'Please try again!'));
            return false;
        }
    }
}
