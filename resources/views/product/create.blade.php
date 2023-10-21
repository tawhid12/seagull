@extends('layout.app')

@section('pageTitle','Create Product')
@section('pageSubTitle','Create Product')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('product.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="product_name" class="form-control" placeholder="Product Name" name="product_name">
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
                                            <option value="{{$c->id}}">{{$c->category_name}}</option>
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
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>

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