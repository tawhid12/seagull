<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee\Employee;
use App\Models\Leave\Leave;
use App\Models\Salary\SalaryAdvancePayment;
use App\Models\SalarySlip;
use App\Models\TotalWorkingDay;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Exception;
use Toastr;
use Log;

class SalarySlipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salary_slips = SalarySlip::with('employee')->paginate(10);
        $employees = Employee::all();
        return view('salary.slip.index', compact('salary_slips', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paymethod = array();
        $account_data = Child_one::whereIn('head_code', [1110])/*->where(company())*/->get();


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


        return view('salary.slip.create', compact('paymethod'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //try {
        //echo $request->from;
        //print_r($request->toArray());die;
        /*== Every Month Salary Create Day ==*/
        //$generate_monthly_day = 25;
        //$generate_month = 11;
        //$generate_year = 2023;
        //$salary_generate_to = Carbon::create($generate_year, $generate_month, $generate_monthly_day);

        // Create a Carbon instance for the specified month and year
        //$previousMonthDate = Carbon::create($generate_year, $generate_month, $generate_monthly_day);

        // Subtract one month from the target date
        //$previousMonthDate = $previousMonthDate->subMonth();

        //$previousMonthDate = $previousMonthDate->format('Y-m-d');


        /*$salary_generate_to = Carbon::create($request->to_date);
            $previousMonthDate = Carbon::create($request->from_date);
            $generate_year = $salary_generate_to->format('Y');
            $generate_month = $salary_generate_to->format('m');*/

        $generate_month = $request->month;
        $generate_year = $request->year;

        // Create a Carbon instance for the first day of the month
        $previousMonthDate = Carbon::createFromDate($generate_year, $generate_month, 1);

        $prev = Carbon::createFromDate($generate_year, $generate_month, 1);
        // Get the last day of the month
        $salary_generate_to = $prev->endOfMonth();

/*echo $previousMonthDate;
echo '<br>';
echo $salary_generate_to;
die;*/
        // Check if the duration is exactly 1 month
        if (/*$salary_generate_to->diffInMonths($previousMonthDate) === 1 &&*/$salary_generate_to->format('Y') === $previousMonthDate->format('Y')) {
            // The duration is 1 month
            //$recordsExist = SalarySlip::where('from_date', '>=', $previousMonthDate)->where('to_date', '<=', $salary_generate_to)->exists();
            $recordsExist = SalarySlip::where('month', $generate_month)->where('year', $generate_year)->exists();
            if ($recordsExist) {
                return redirect()->back()->with(Toastr::error('This Month Already Generated!', 'Error', ["positionClass" => "toast-top-right"]));
            } else {
                $total_working_day = TotalWorkingDay::where('month', $generate_month)->where('year', $generate_year)->first();
                //print_r($total_working_day->toArray());die;
                if (!isset($total_working_day)) {
                    return redirect()->back()->with(Toastr::error('Please Entry Total Working Day First!', 'Error', ["positionClass" => "toast-top-right"]));
                } else {
                    $employees = Employee::all();
                    foreach ($employees as $e) {
                        $leaveCount = Leave::where('from_date', '>=', $previousMonthDate)
                            ->where('to_date', '<=', $salary_generate_to)
                            ->where(['employee_id' => $e->id, 'status' => 1])
                            ->count();
                        
                        $attendance_count = Attendance::whereBetween('postingDate', [$previousMonthDate->format('Y-m-d'), $salary_generate_to->format('Y-m-d')])->where(['isPresent' => 1, 'employee_id' => $e->id])->count();
                        //echo $attendance_count;die;
                        $absent_count = Attendance::whereBetween('postingDate', [$previousMonthDate->format('Y-m-d'), $salary_generate_to->format('Y-m-d')])->where(['isPresent' => 0, 'employee_id' => $e->id])->count();
                        $sadvp = SalaryAdvancePayment::where(['month' => $generate_month, 'year' => $generate_year, 'employee_id' => $e->id])->first();
                        $sl = new SalarySlip();
                        $sl->employee_id = $e->id;
                        $sl->total_working_day = $total_working_day->total_working_day;
                        $sl->total_present = $attendance_count;
                        $sl->total_leave = $leaveCount;
                        $sl->total_absent = $absent_count;
                        $sl->month = $generate_month;
                        $sl->year = $request->year;
                        /*== Salary Calculation ==*/
                        $salary_amt_per_day = $e->salary / 30;
                        if ($absent_count > 0) {
                            $deduction_amt = $salary_amt_per_day * $absent_count;
                            $sl->absent_deduction = $deduction_amt;
                            $salary = $e->salary - $deduction_amt;
                        } else {
                            $salary = $e->salary;
                        }
                        if (isset($sadvp)) {
                            if ($sadvp->balance > 0 && $sadvp->status == 0) {
                                $salary -= $sadvp->deduction;
                                $balance = $sadvp->balance - $sadvp->deduction;
                                if ($balance == 0) {
                                    SalaryAdvancePayment::where(['month' => $generate_month, 'year' => $generate_year, 'employee_id' => $e->id])->update(['balance' => $balance, 'status' => 1, 'adjusted_on' => Carbon::now(), 'updated_by' => currentUserId()]);
                                } else {
                                    SalaryAdvancePayment::where(['month' => $generate_month, 'year' => $generate_year, 'employee_id' => $e->id])->update(['balance' => $balance]);
                                }
                                $sl->deduction = $sadvp->deduction;
                            }
                        }

                        $sl->salary = $salary;
                        $sl->created_by = currentUser();
                        $credit = explode('~', $request->credit);
                        $sl->account_code = $credit[2];
                        $sl->table_name = $credit[0];
                        $sl->table_id = $credit[1];
                        $sl->save();
                    }
                    \LogActivity::addToLog('Generate Salary Slip', $request->getContent(), 'Salary Slip');
                    return redirect()->route('salary-slip.index')->with(Toastr::success('Generated!', 'Success', ["positionClass" => "toast-top-right"]));
                }
            }
        } else {
            // The duration is not 1 month
            return redirect()->back()->with(Toastr::error('Duration Should Be One Month!', 'Error', ["positionClass" => "toast-top-right"]));
        }
        /*} catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SalarySlip  $salarySlip
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salary_slip = SalarySlip::findOrFail(encryptor('decrypt', $id));
        return view('salary.slip.show', compact('salary_slip'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SalarySlip  $salarySlip
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sl = SalarySlip::findOrFail(encryptor('decrypt', $id));
        return view('salary.slip.edit', compact('sl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SalarySlip  $salarySlip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $sl = SalarySlip::findOrFail(encryptor('decrypt', $id));
            if(currentUser() == 'superadmin'){
                $sl->status = !$sl->status;
            }
        }catch (Exception $e) {
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SalarySlip  $salarySlip
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalarySlip $salarySlip)
    {
        //
    }
}
