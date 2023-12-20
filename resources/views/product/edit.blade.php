@extends('layout.app')

@section('pageTitle','Edit Product')
@section('pageSubTitle','Edit Product')

@section('content')

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('product.update',encryptor('encrypt',$p->id))}}">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$p->id)}}">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="product_name" class="form-control"
                                               placeholder="Product Name" name="product_name" value="{{ $p->product_name }}">
                                    </div>
                                    @if($errors->has('product_name'))
                                        <span class="text-danger"> {{ $errors->first('product_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Category</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($categories as $c)
                                                <option value="{{$c->id}}" @if($c->id == $p->category_id) selected @endif>{{$c->category_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('category_id'))
                                        <span class="text-danger"> {{ $errors->first('category_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="pro_type_id">Select Product Type</label>
                                        <select name="pro_type_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($pro_types as $pt)
                                                <option value="{{$pt->id}}" @if($pt->id == $p->pro_type_id) selected @endif>{{$pt->product_type_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('pro_type_id'))
                                        <span class="text-danger"> {{ $errors->first('pro_type_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="product_item_code">Product Item Code</label>
                                        <input type="text" id="product_item_code" class="form-control"
                                               placeholder="Product Item Code" name="product_item_code" value="{{ $p->product_item_code }}">
                                    </div>
                                    @if($errors->has('product_item_code'))
                                        <span class="text-danger"> {{ $errors->first('product_item_code') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="manufacturer">Manufacturer</label>
                                        <input type="text" id="manufacturer" class="form-control"
                                               placeholder="Product Manufacturer" name="manufacturer" value="{{ $p->manufacturer }}">
                                    </div>
                                    @if($errors->has('manufacturer'))
                                        <span class="text-danger"> {{ $errors->first('manufacturer') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="manufacturer">Product Model</label>
                                        <input type="text" id="product_model" class="form-control"
                                               placeholder="Product Model" name="product_model" value="{{ $p->product_model }}">
                                    </div>
                                    @if($errors->has('product_model'))
                                        <span class="text-danger"> {{ $errors->first('product_model') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="brand">Product Brand</label>
                                        <input type="text" id="brand" class="form-control"
                                               placeholder="Product Brand" name="brand" value="{{ $p->brand }}">
                                    </div>
                                    @if($errors->has('product_model'))
                                        <span class="text-danger"> {{ $errors->first('product_model') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="manu_country">Manufacturer Country</label>
                                        <input type="text" id="manu_country" class="form-control"
                                               placeholder="Manufacturer Country" name="manu_country" value="{{ $p->manu_country }}">
                                    </div>
                                    @if($errors->has('manu_country'))
                                        <span class="text-danger"> {{ $errors->first('manu_country') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea rows=5" id="description" class="form-control"
                                                  placeholder="Product Description" name="description">{{ $p->description }}</textarea>
                                    </div>
                                    @if($errors->has('description'))
                                        <span class="text-danger"> {{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                                {{--<div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Quantity</label>
                                        <input type="text" id="qty" class="form-control" placeholder="Quantity" name="qty">
                                    </div>
                                    @if($errors->has('qty'))
                                    <span class="text-danger"> {{ $errors->first('qty') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="per_unit_price">Per Unit Price</label>
                                        <input type="text" id="per_unit_price" class="form-control" placeholder="Per Unit Price" name="per_unit_price">
                                    </div>
                                    @if($errors->has('per_unit_price'))
                                    <span class="text-danger"> {{ $errors->first('per_unit_price') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="opening_balance">Opening Balance</label>
                                        <input type="text" id="opening_balance" class="form-control" placeholder="opening Balance" name="opening_balance">
                                    </div>
                                    @if($errors->has('opening_balance'))
                                    <span class="text-danger"> {{ $errors->first('opening_balance') }}</span>
                                    @endif
                                </div>--}}

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->
</div>
@endsection