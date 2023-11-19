<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\Salary\SalaryAdvancePayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use Exception;
use Toastr;
use Log;

class SalaryAdvancePaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salary_adv_payments = SalaryAdvancePayment::with('employee')->paginate(10);
        $employees = Employee::all();
        return view('salary.advance-payment.index',compact('salary_adv_payments','employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::all();

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

        return view('salary.advance-payment.create', compact('employees', 'paymethod'));
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
            $employee = Employee::where('id', $request->employee_id)->first();
            $adv_payment = SalaryAdvancePayment::where(['employee_id' => $request->employee_id, 'month' => $request->month, 'year' => $request->year, 'status' => 0])->first();
            //print_r($employee->toArray());die;
            if ($request->adv_salary > $employee->salary)
                return redirect()->back()->with(Toastr::error('Advance Amount Can not be Greater than Salary', 'Error', ["positionClass" => "toast-top-right"]));
            if ($request->deduction > $employee->salary)
                return redirect()->back()->with(Toastr::error('Deduction Can not be Greater than Salary', 'Error', ["positionClass" => "toast-top-right"]));
            if ($adv_payment)
                return redirect()->back()->with(Toastr::error('Advance Already Exists', 'Error', ["positionClass" => "toast-top-right"]));

            $credit = explode('~', $request->credit);

            $sadvp = new SalaryAdvancePayment();
            $sadvp->employee_id = $request->employee_id;
            $sadvp->adv_salary = $request->adv_salary;
            $sadvp->deduction = $request->deduction;
            $sadvp->balance = $request->adv_salary;
            $sadvp->paid_date = Carbon::now()->format('Y-m-d');
            $sadvp->month = $request->month;
            $sadvp->year = $request->year;
            $sadvp->created_by = currentUserId();
            $sadvp->account_code = $credit[2];
            $sadvp->table_name = $credit[0];
            $sadvp->table_id = $credit[1];
            if ($sadvp->save()) {
                \LogActivity::addToLog('Add Salary Advance', $request->getContent(), 'Salary Advance');
                return redirect()->route('salary-advance-payment.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Salary\SalaryAdvancePayment  $salaryAdvancePayment
     * @return \Illuminate\Http\Response
     */
    public function show(SalaryAdvancePayment $salaryAdvancePayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salary\SalaryAdvancePayment  $salaryAdvancePayment
     * @return \Illuminate\Http\Response
     */
    public function edit(SalaryAdvancePayment $salaryAdvancePayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salary\SalaryAdvancePayment  $salaryAdvancePayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalaryAdvancePayment $salaryAdvancePayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salary\SalaryAdvancePayment  $salaryAdvancePayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalaryAdvancePayment $salaryAdvancePayment)
    {
        //
    }
}
