<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\InvoiceReport;
use Illuminate\Http\Request;
use App\Http\Traits\ImageHandleTraits;
use Toastr;

class InvoiceReportController extends Controller
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
        $or = Order::with('invoice_report')->findOrFail($request->get('id'));
        return view('invoice_report.create', compact('or'));
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
            $ir = New InvoiceReport();
            if ($request->has('invoice_report')) $ir->file_name = 'uploads/invoice_report/'.$this->uploadImage($request->file('invoice_report'), 'uploads/invoice_report');
            $ir->order_id = $request->order_id;
            $ir->created_by = currentUserId();
            if ($ir->save()) {
                \LogActivity::addToLog('Upload Invoice Report', $request->getContent(), 'Invoice Report');
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
     * @param  \App\Models\InvoiceReport  $invoiceReport
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceReport $invoiceReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceReport  $invoiceReport
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceReport $invoiceReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceReport  $invoiceReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceReport $invoiceReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceReport  $invoiceReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceReport $invoiceReport)
    {
        //
    }
}
