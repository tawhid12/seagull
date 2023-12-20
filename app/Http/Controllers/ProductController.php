<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\Product\AddNewRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use Toastr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $pro_types = ProductType::all();
        return view('product.create', compact('categories', 'pro_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddNewRequest $request)
    {
        try {
            $p = new Product();
            $p->product_name = $request->product_name;
            $p->category_id = $request->category_id;
            $p->pro_type_id = $request->pro_type_id;
            $p->product_item_code = $request->product_item_code;
            $p->product_model = $request->product_model;
            $p->manufacturer = $request->manufacturer;
            $p->description = $request->description;
            $p->brand = $request->brand;
            $p->manu_country = $request->manu_country;
            $p->created_by = currentUserId();
            if ($p->save()) {
                \LogActivity::addToLog('Add Product', $request->getContent(), 'Product');
                return redirect()->route('product.index')->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $p=Product::findOrFail(encryptor('decrypt',$id));
        $categories = Category::all();
        $pro_types = ProductType::all();
        return view('product.edit', compact('p','categories', 'pro_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request,$id)
    {
        try {
            $p = Product::findOrFail(encryptor('decrypt',$id));
            $p->product_name = $request->product_name;
            $p->category_id = $request->category_id;
            $p->pro_type_id = $request->pro_type_id;
            $p->product_item_code = $request->product_item_code;
            $p->product_model = $request->product_model;
            $p->manufacturer = $request->manufacturer;
            $p->description = $request->description;
            $p->brand = $request->brand;
            $p->manu_country = $request->manu_country;
            $p->updated_by = currentUserId();
            if ($p->save()) {
                \LogActivity::addToLog('Update Product', $request->getContent(), 'Product');
                return redirect()->route('product.index', ['role' => currentUser()])->with(Toastr::success('Data Saved!', 'Success', ["positionClass" => "toast-top-right"]));
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
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function allProducts(Request $request)
    {
        $products = Product::with('category')->where('product_name', 'like', '%' . $request->name . '%')->get();
        return json_encode($products);
    }

    public function productById(Request $request)
    {
        //$data_exists = DB::select("SELECT * FROM `student_batches` WHERE `batch_id`=$request->batchId and student_id=$request->student_id");
        //check student id with batch id exists in batch table
        //if(!$data_exists){

        $product = Product::find($request->pid);
        $suppliers = Supplier::all();
        $data = '<tr class="productlist" id="row_' . $request->rowcount . '" data-item-id="' . $product->id . '">';
//            $data.='<input name="order_id[]" type="hidden" value="'.$request->order_id.'">';
        $data .= '<td>' . $product->product_name . '<input name="product_id[]" type="hidden" value="' . $product->id . '"></td>';
        $data .= '
        <td>
            <select class="js-example-basic-single form-control" id="supplier_id" name="supplier_id[]" required>
                <option value="">Select</option>';
        foreach ($suppliers as $sup) {
            $data .= '<option value="'.$sup->id.'">'.$sup->supplier_name.'</option>';
        }
        $data .= '</select>
        </td>';
        $data .='<td><input type="text" class="per-unit-price form-control" placeholder="Product Per Unit Price" name="per_unit_price[]" required></td>';
        $data .='<td><input type="text" class="qty form-control" placeholder="Product Qty" name="qty[]" onkeyup="calc(this);total()" required></td>';
        $data .='<td><input type="text" class="sub-total form-control"></td>';
        $data .= '<td id="td_' . $request->rowcount . '" style="text-align: center;">
                <a class="bi bi-trash text-red" style="cursor: pointer;font-size: 14px;" onclick="removerow(' . $request->rowcount . ');" title="Delete ?" id="td_data_' . $request->rowcount . '"></a>
            </td>';
        return response()->json(array('data' =>$data));
    }
}

