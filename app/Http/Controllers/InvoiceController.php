<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Company;
use App\Models\Client;
use App\Models\Vessel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Toastr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with(['company', 'client', 'vessel'])->paginate(50);
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$user = User::find(currentUserId()); // $userId is the ID of the user you're interested in
        //$assigned_companies = $user->company;
        //print_r($assignedCompanies->toArray());die;
        $companyData = company();
        $clients = Client::where('company_id', $companyData['company_id'])->get();
        $vessels = Vessel::where('company_id', $companyData['company_id'])->get();
        return view('invoice.create', compact('clients', 'vessels',));
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
            $inv = new Invoice();
            $inv->invoice_no = $request->invoice_no;
            $companyData = company();
            $inv->company_id = $companyData['company_id'];
            $inv->client_id = $request->client_id;
            $inv->vessel_id = $request->vessel_id;
            $inv->currency = $request->currency;
            $inv->amount = $request->amount;
            $inv->posted_on = Carbon::parse($request->posted_on)->format('Y-m-d');
            $inv->created_by = currentUserId();
            if ($inv->save()) {
                \LogActivity::addToLog('Add Invoice', $request->getContent(), 'Invoice');
                return redirect()->route('invoice.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
