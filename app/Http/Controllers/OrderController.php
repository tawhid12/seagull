<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Vessel;
use App\Models\Vouchers\JournalVoucher;
use App\Models\Vouchers\JournalVoucherBkdn;
use App\Models\Vouchers\GeneralLedger;
use App\Models\Vouchers\GeneralVoucher;
use Illuminate\Http\Request;
use App\Http\Requests\Order\AddOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\ProductRequisiton;
use App\Models\Requisition;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use Illuminate\Support\Carbon;
use Toastr;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['company', 'client', 'vessel'])->paginate(50);
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyData = company();
        $clients = Client::where('company_id', $companyData['company_id'])->get();
        $vessels = Vessel::where('company_id', $companyData['company_id'])->get();
        return view('order.create', compact('clients', 'vessels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $voucher_no = $this->create_voucher_no();
            $client_name = Client::where('id', $request->client_id)->first()->client_name;
            $order = new Order();
            $order->order_subject = $request->order_subject;
            $order->order_details = $request->order_details;
            $order->order_subject = $request->order_subject;
            $order->invoice_no = $request->invoice_no;
            $order->voyage_no = $request->voyage_no;
            $order->invoice_date = Carbon::parse($request->invoice_date)->format('Y-m-d');
            $order->po_no = $request->po_no;
            $order->po_date = Carbon::parse($request->po_date)->format('Y-m-d');
            $order->company_id = company()['company_id'];
            $order->client_id = $request->client_id;
            $order->vessel_id = $request->vessel_id;
            $order->currency = $request->currency;
            $order->amount = $request->amount;
            $order->posted_on = Carbon::parse($request->posted_on)->format('Y-m-d');
            $order->created_by = currentUserId();
            $order->remarks = $request->remarks;
            if ($order->save()) {
                if (!empty($voucher_no)) {
                    $jv = new JournalVoucher;
                    $jv->voucher_no = $voucher_no;
                    $jv->company_id = company()['company_id'];
                    $jv->current_date = Carbon::parse($request->posted_on)->format('Y-m-d');
                    $jv->pay_name = $client_name;
                    $jv->purpose = "Order Generated #".$order->id;
                    $jv->credit_sum = $request->amount;
                    $jv->debit_sum = $request->amount;
                    $jv->cheque_no = $request->cheque_no;
                    $jv->bank = $request->bank;
                    $jv->cheque_dt = $request->cheque_dt;
                    $jv->created_by = currentUserId();
                    if ($jv->save()) {
                        $child_one = Child_one::where('head_code', '4101')->first();
                        $child_two = Child_two::where('head_code', '1130' . $order->client_id)->first();
                        $account_codes = ['4101', $child_two->head_code];
                        $account_head = [ $child_one->head_name,$child_two->head_name];
                        $tables_name = ['child_ones','child_twos'];
                        $table_id = [$child_one->id,$child_two->id];
                        $credit = [0,$request->amount];
                        $debit = [$request->amount, 0];
                        if (sizeof($account_codes) > 0) {
                            foreach ($account_codes as $i => $acccode) {
                                $jvb = new JournalVoucherBkdn;
                                $jvb->journal_voucher_id = $jv->id;
                                $jvb->company_id = company()['company_id'];
                                $jvb->particulars = !empty($request->remarks[$i]) ? $request->remarks[$i] : "";
                                $jvb->account_code = !empty($acccode) ? $acccode : "";
                                $jvb->table_name = !empty($tables_name[$i]) ? $tables_name[$i] : "";
                                $jvb->table_id = !empty($table_id[$i]) ? $table_id[$i] : "";
                                //$jvb->debit = !empty($debit[$i]) ? $debit[$i] : 0;
                                //$jvb->credit = !empty($credit[$i]) ? $credit[$i] : 0;
                                $jvb->debit = !empty($request->amount) ? $request->amount : 0;
                                $jvb->credit = !empty($request->amount) ? $request->amount : 0;
                                
                                if ($jvb->save()) {
                                    $table_name = $tables_name[$i];
                                    if ($table_name == "master_accounts") {
                                        $field_name = "master_account_id";
                                    } else if ($table_name == "sub_heads") {
                                        $field_name = "sub_head_id";
                                    } else if ($table_name == "child_ones") {
                                        $field_name = "child_one_id";
                                    } else if ($table_name == "child_twos") {
                                        $field_name = "child_two_id";
                                    }
                                    $gl = new Generalledger;
                                    $gl->journal_voucher_id = $jv->id;
                                    $gl->company_id = company()['company_id'];
                                    $gl->journal_title = !empty($acccode) ? $acccode . '-' . $account_head[$i] : "";
                                    $gl->rec_date = Carbon::parse($request->posted_on)->format('Y-m-d');
                                    $gl->jv_id = $voucher_no;
                                    $gl->journal_voucher_bkdn_id = $jvb->id;
                                    $gl->created_by = currentUserId();
                                    $gl->dr = !empty($request->amount) ? $request->amount : 0;
                                    $gl->cr = !empty($request->amount) ? $request->amount: 0;
                                    $gl->{$field_name} = !empty($table_id[$i]) ? $table_id[$i] : "";
                                    $gl->save();
                                    
                                }
                            }
                        }
                    }
                }
                DB::commit();
                \LogActivity::addToLog('Add Order', $request->getContent(), 'Order');
                return redirect()->route('order.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            return redirect()->back()->withInput()->with($this->resMessageHtml(false, 'error', 'Please try again'));
        }
    }

    public function create_voucher_no()
    {
        $voucher_no = "";
        $query = GeneralVoucher::latest()->first();
        if (!empty($query)) {
            $voucher_no = $query->voucher_no;
            $voucher_no += 1;
            $gv = new GeneralVoucher;
            $gv->voucher_no = $voucher_no;
            if ($gv->save())
                return $voucher_no;
            else
                return $voucher_no = "";
        } else {
            $voucher_no = 10000001;
            $gv = new GeneralVoucher;
            $gv->voucher_no = $voucher_no;
            if ($gv->save())
                return $voucher_no;
            else
                return $voucher_no = "";
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clients = Client::where('company_id', company())->get();
        $vessels = Vessel::where('company_id', company())->get();
        $or = Order::with(['service_report', 'delivery_report', 'invoice_report', 'work_done_report'])->findOrFail(encryptor('decrypt', $id));
        return view('order.show', compact('or', 'clients', 'vessels'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companyData = company();
        $clients = Client::where('company_id', company())->get();
        $vessels = Vessel::where('company_id', company())->get();
        $or = Order::findOrFail(encryptor('decrypt', $id));
        return view('order.edit', compact('or', 'clients', 'vessels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        /*print_r($request->toArray());die;
        echo  $request->order_details;die;*/
        try {
            $order = Order::findOrFail(encryptor('decrypt', $id));
            $order->order_subject = $request->order_subject;
            $order->order_details = $request->order_details;
            $order->order_subject = $request->order_subject;
            $order->invoice_no = $request->invoice_no;
            $order->voyage_no = $request->voyage_no;
            $order->invoice_date = Carbon::parse($request->invoice_date)->format('Y-m-d');
            $order->po_no = $request->po_no;
            $order->po_date = Carbon::parse($request->po_date)->format('Y-m-d');
            $order->client_id = $request->client_id;
            $order->vessel_id = $request->vessel_id;
            $order->currency = $request->currency;
            $order->amount = $request->amount;
            $order->posted_on = Carbon::parse($request->posted_on)->format('Y-m-d');
            $order->created_by = currentUserId();
            $order->remarks = $request->remarks;
            if ($order->save()) {
                /*===== Update Fund Requisition Amount Need to Update Fund Requisition Total and Product Requisition Total*/
                if ($request->amount > $order->amount) {
                    Requisition::where('order_id', encryptor('decrypt', $id))->update(['order_amount' => $request->amount]);
                }
                \LogActivity::addToLog('Add Order', $request->getContent(), 'Order');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    
}
