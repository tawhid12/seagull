<?php

namespace App\Http\Controllers;

use App\Models\ProductRequisitionDetails;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductRequisiton;
use App\Models\Requisition;
use Illuminate\Http\Request;
use Toastr;
use DB;
class ProductRequisitonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_requisitions = ProductRequisiton::latest()->paginate(15);
        return view('product_requisition.index', compact('product_requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_requisiton = ProductRequisiton::pluck('order_id')->toArray();
        $orders = Order::whereNotIn('id', $product_requisiton)->get();
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('product_requisition.create', compact('orders', 'suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $order = Order::where('id', $request->order_id)->first();
            if($order->amount == 0.00){
                return redirect()->back()->withInput()->with(Toastr::error('Order Amount should Be greater than Zero', 'Fail', ["positionClass" => "toast-top-right"]));
            }
            /* Product Requisition Can Not Greater Than Order Amount */
            $pr = new ProductRequisiton();
            $pr->title = $request->title;
            $pr->req_slip_no = $this->req_slip_no();
            $pr->order_id = $request->order_id;
            $pr->postingDate = date('y-m-d', strtotime($request->postingDate));
            $pr->des = $request->des;
            $pr->company_id = company()['company_id'];
            $total = 0;
            if ($pr->save()) {
                if ($request->product_id) {
                    foreach ($request->product_id as $i => $product_id) {
                        $prd = new ProductRequisitionDetails();
                        $prd->product_requisition_id = $pr->id;
                        $prd->product_id = $request->product_id[$i];
                        $prd->supplier_id = $request->supplier_id[$i];
                        $prd->per_unit_price = $request->per_unit_price[$i];
                        $prd->qty = $request->qty[$i];
                        $prd->total_payable = $request->per_unit_price[$i] * $request->qty[$i];
                        $total += $request->per_unit_price[$i] * $request->qty[$i];
                        $prd->created_by = currentUserId();
                        if ($prd->save()) {
                        } else
                            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
                    }
                    if($total > $order->amount){
                        return redirect()->back()->withInput()->with(Toastr::error($total'', 'Fail', ["positionClass" => "toast-top-right"]));
                    }else{
                        DB::commit();
                    } 
                    \LogActivity::addToLog('Add Product Requisition', $request->getContent(), 'Product Requisition');
                    return redirect()->route('product-requisition.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
                }
               
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProductRequisiton $productRequisiton
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRequisiton $productRequisiton)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProductRequisiton $productRequisiton
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orders = Order::all();
        $products = Product::all();
        $suppliers = Supplier::all();
        $prwd=ProductRequisiton::with('product_requistion_details')->findOrFail(encryptor('decrypt',$id));
        /*echo '<pre>';
        print_r($prwd);*/
        return view('product_requisition.edit',compact('prwd','orders','products','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductRequisiton $productRequisiton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $pr =  ProductRequisiton::findOrFail(encryptor('decrypt',$id));
            $pr->title = $request->title;
            $pr->req_slip_no = $request->req_slip_no;
            $pr->order_id = $request->order_id;
            $pr->postingDate = date('y-m-d', strtotime($request->postingDate));
            $pr->des = $request->des;
            $pr->company_id = company()['company_id'];
            if ($pr->save()) {
                if ($request->product_id) {
                    foreach ($request->product_id as $i => $product_id) {
                        if (ProductRequisitionDetails::where(['product_requisition_id'=> $pr->id,'product_id'=> $request->product_id[$i],'supplier_id'=> $request->supplier_id[$i]])->doesntExist()) {
                            //$test = ProductRequisitionDetails::where(['product_requisition_id'=> $pr->id,'product_id'=> $request->product_id[$i],'supplier_id'=> $request->supplier_id[$i]]);
                            // Log the SQL query
                            //\Log::info($test->toSql());

                            // Optionally, log the bindings
                            //\Log::info($test->getBindings());
                            //dd($test->toSql(), $test->getBindings());

                            $prd = new ProductRequisitionDetails();
                            $prd->product_requisition_id = $pr->id;
                            $prd->product_id = $request->product_id[$i];
                            $prd->supplier_id = $request->supplier_id[$i];
                            $prd->per_unit_price = $request->per_unit_price[$i];
                            $prd->qty = $request->qty[$i];
                            $prd->total_payable = $request->per_unit_price[$i] * $request->qty[$i];
                            $prd->created_by = currentUserId();
                            $prd->save();
                        }else{
                            $prd = ProductRequisitionDetails::find($request->product_requisition_id[$i]);
                            /*echo '<pre>';
                            print_r($prd);die;*/
                            $prd->product_id = $request->product_id[$i];
                            $prd->supplier_id = $request->supplier_id[$i];
                            $prd->per_unit_price = $request->per_unit_price[$i];
                            $prd->qty = $request->qty[$i];
                            $prd->total_payable = $request->per_unit_price[$i] * $request->qty[$i];
                            $prd->updated_by = currentUserId();
                            $prd->save();
                        }
                        DB::commit();
                    }
                    \LogActivity::addToLog('Add Product Requisition', $request->getContent(), 'Product Requisition');
                    return redirect()->route('product-requisition.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
                }
            } else {
                return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
            }
        } catch (Exception $e) {
            DB::rollback();
            //dd($e);
            return redirect()->back()->withInput()->with(Toastr::error('Please try again!', 'Fail', ["positionClass" => "toast-top-right"]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProductRequisiton $productRequisiton
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRequisiton $productRequisiton)
    {
        //
    }
    public function req_slip_no()
    {
        $req_slip_no = "";
        $query = ProductRequisiton::latest()->first();
        if (!empty($query)) {
            $req_slip_no = $query->req_slip_no;
            $req_slip_no += 1;
            return $req_slip_no;
        } else {
            $req_slip_no = 10000001;
            return $req_slip_no;
        }
    }
}
