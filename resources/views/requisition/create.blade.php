@extends('layout.app')

@section('pageTitle','Create Product Requistion')
@section('pageSubTitle','Create Product Requisition')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('requisition.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="req_slip_no">Requistion Slip No</label>
                                        <input type="text" id="req_slip_no" class="form-control" placeholder="Requisition Slip No" name="req_slip_no">
                                    </div>
                                    @if($errors->has('req_slip_no'))
                                    <span class="text-danger"> {{ $errors->first('req_slip_no') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="postingDate">Requistion Date</label>
                                        <input type="date" id="postingDate" class="form-control" name="postingDate">
                                    </div>
                                    @if($errors->has('postingDate'))
                                    <span class="text-danger"> {{ $errors->first('postingDate') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Client</label>
                                        <select name="client_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($clients as $c)
                                            <option value="{{$c->id}}">{{$c->client_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('client_id'))
                                    <span class="text-danger"> {{ $errors->first('client_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Vessel</label>
                                        <select name="vessel_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($vessels as $v)
                                            <option value="{{$v->id}}">{{$v->vessel_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('vessel_id'))
                                    <span class="text-danger"> {{ $errors->first('vessel_id') }}</span>
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
                                        <label for="tax">Product Quantity</label>
                                        <input type="text" id="qty" class="form-control" placeholder="Quantity" name="qty">
                                    </div>
                                    @if($errors->has('qty'))
                                    <span class="text-danger"> {{ $errors->first('qty') }}</span>
                                    @endif
                                </div>
                                <!-- <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="amount">Product Price</label>
                                        <input type="text" id="amount" class="form-control" placeholder="Product Price" name="amount">
                                    </div>
                                    @if($errors->has('amount'))
                                    <span class="text-danger"> {{ $errors->first('amount') }}</span>
                                    @endif
                                </div> -->
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="Category">{{__('Received Account')}}</label>
                                        <select  class="form-control form-select" name="credit">
                                            @if($paymethod)
                                                @foreach($paymethod as $d)
                                                    <option value="{{$d['table_name']}}~{{$d['id']}}~{{$d['head_name']}}-{{$d['head_code']}}">{{$d['head_name']}}-{{$d['head_code']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
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