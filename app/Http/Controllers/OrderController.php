<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Vessel;
use Illuminate\Http\Request;
use App\Http\Requests\Order\AddOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use Illuminate\Support\Carbon;
use Toastr;
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
    public function store(Request $request)
    {
        try {
            $order = new Order();
            $order->order_subject = $request->order_subject;
            $order->order_details = $request->order_details;
            $order->order_subject = $request->order_subject;
            $order->invoice_no = $request->invoice_no;
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
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
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
        $clients = Client::where('company_id', $companyData['company_id'])->get();
        $vessels = Vessel::where('company_id', $companyData['company_id'])->get();
        $or=Order::findOrFail(encryptor('decrypt',$id));
        return view('order.edit',compact('or','clients', 'vessels'));
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
            $order = Order::findOrFail(encryptor('decrypt',$id));
            $order->order_subject = $request->order_subject;
            $order->order_details = $request->order_details;
            $order->order_subject = $request->order_subject;
            $order->invoice_no = $request->invoice_no;
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
