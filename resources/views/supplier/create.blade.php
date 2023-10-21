@extends('layout.app')

@section('pageTitle','Create Supplier')
@section('pageSubTitle','Create Supplier')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('supplier.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="supplier_name" class="form-control" placeholder="Supplier Name" name="supplier_name">
                                    </div>
                                    @if($errors->has('supplier_name'))
                                    <span class="text-danger"> {{ $errors->first('supplier_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Product</label>
                                        <select name="product_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($products as $p)
                                            <option value="{{$p->id}}">{{$p->product_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('product_id'))
                                    <span class="text-danger"> {{ $errors->first('product_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    @if($errors->has('email'))
                                    <span class="text-danger"> {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="contact_no">Contact No</label>
                                        <input type="text" id="contact_no" class="form-control" placeholder="Contact No" name="contact_no">
                                    </div>
                                    @if($errors->has('contact_no'))
                                    <span class="text-danger"> {{ $errors->first('contact_no') }}</span>
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