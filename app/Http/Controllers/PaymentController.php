<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Toastr;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::with('order')->paginate(50);
        return view('payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            /*$inv = Invoice::find($request->invoice_id);
            if($inv->amount > $inv->amount-$inv->payments->sum('amount')){

            }else{

            }*/
            $p = new Payment();
            $p->order_id = $request->order_id;
            $p->company_id = company()['company_id'];
            $p->amount = $request->amount;
            //$p->posted_on = Carbon::parse($request->posted_on)->format('Y-m-d');
            $p->created_by = currentUserId();
            if ($p->save()) {
                \LogActivity::addToLog('Add Payment', $request->getContent(), 'Payment');
                return redirect()->route('payment.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
    public function payment_by_order(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $data = '<div class="row">';
        $data .= '<div class="col-md-3 col-12">';
        $data .= '<div class="form-group">';
        $data .= '<label for="">Order No</label>';
        $data .= '<input type="text" class="form-control" value="' . $order->id . '" readonly>';
        $data .= '</div>';
        $data .= '</div>';


        $data .= '<div class="col-md-3 col-12">';
        $data .= '<div class="form-group">';
        $data .= '<label for="amount">Amount</label>';
        $data .= '<input type="text" name="amount" class="form-control" required>';
        $data .= '</div>';
        $data .= '</div>';

        $data .= '</div>';

        return response()->json(['data' => $data]);
    }
}
