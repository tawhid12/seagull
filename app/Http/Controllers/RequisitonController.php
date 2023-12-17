<?php

namespace App\Http\Controllers;

use App\Models\Requisiton;
use Illuminate\Http\Request;
use App\Http\Requests\Requisition\AddNewRequest;
use App\Http\Requests\Requisition\UpdateRequest;
use App\Models\Product;
use App\Models\Client;
use App\Models\Vessel;
use App\Models\Order;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use Toastr;

class RequisitonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitions = Requisiton::latest()->paginate(15);
        return view('requisition.index', compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where(company())->get();
        $clients = Client::where(company())->get();
        $vessels = Vessel::where(company())->get();
        /* need to implement a check for order amount is greater approve amount */
        $orders = Order::where(company())->get();

        $paymethod = array();
        $account_data = Child_one::whereIn('head_code', [4101])/*->where(company())*/ ->get();


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

        return view('requisition.create', compact('products', 'clients', 'vessels', 'orders', 'paymethod'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $credit = explode('~', $request->credit);
        $r = new Requisiton();
        $r->title = $request->title;
        $r->req_slip_no = $request->req_slip_no;
        $r->postingDate = date('y-m-d', strtotime($request->postingDate));
        /*$r->client_id = $request->client_id;
        $r->vessel_id = $request->vessel_id;
        $r->product_id = $request->product_id;
        $r->qty = $request->qty;
        $product = Product::where('id',$request->product_id)->first();*/
        $order = Order::where('id', $request->order_id)->first();
        if($order->amount == 0.00){
            return redirect()->back()->withInput()->with(Toastr::error('Order Amount should Be greater than Zero', 'Fail', ["positionClass" => "toast-top-right"]));
        }
        $r->order_amount = $order->amount;
        $r->des = $request->des;
//            $r->req_type = 1;
        /*$r->company_id = company()['company_id'];
        $r->created_by = currentUserId();
        $r->account_code = $credit[2];
        $r->table_name = $credit[0];
        $r->table_id = $credit[1];*/
        if ($r->save()) {
            \LogActivity::addToLog('Add Requisition', $request->getContent(), 'Requisition');
            return redirect()->route('requisition.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
        } else {
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Requisiton $requisiton
     * @return \Illuminate\Http\Response
     */
    public function show(Requisiton $requisiton)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Requisiton $requisiton
     * @return \Illuminate\Http\Response
     */
    public function edit(Requisiton $requisiton)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Requisiton $requisiton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $r = Requisiton::findOrFail(encryptor('decrypt', $id));
            if (currentUser() == 'superadmin') {
                $r->status = !$r->status;
            }
            $r->updated_by = currentUserId();
            if ($r->save()) {
                \LogActivity::addToLog('requisition Approved', $request->getContent(), 'Requisition');
                return redirect()->route('requisition.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param \App\Models\Requisiton $requisiton
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisiton $requisiton)
    {
        //
    }
}
