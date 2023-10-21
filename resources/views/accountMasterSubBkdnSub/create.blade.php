@extends('layout.app')

@section('pageTitle','Create Master Sub Two')
@section('pageSubTitle','Create Master Sub Two')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('accountMasterSubBkdnSub.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Master Sub One</label>
                                        <select name="fcoa_bkdn_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($accountMasterSubBkdn as $amsb)
                                            <option value="{{$amsb->fcoa_bkdn_id}}">{{$amsb->fcoa_bkdn}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('fcoa_bkdn_id'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_bkdn_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="fcoa_bkdn_sub">Sub Two Account</label>
                                        <input type="text" id="fcoa_bkdn_sub" class="form-control" placeholder="Sub Two" name="fcoa_bkdn_sub">
                                    </div>
                                    @if($errors->has('fcoa_bkdn_sub'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_bkdn_sub') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="sub_code">Code</label>
                                        <input type="text" id="sub_code" class="form-control" name="sub_code">
                                    </div>
                                    @if($errors->has('sub_code'))
                                    <span class="text-danger"> {{ $errors->first('sub_code') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="sub_balance">Balance</label>
                                        <input type="text" id="sub_balance" class="form-control" placeholder="Balance" name="sub_balance">
                                    </div>
                                    @if($errors->has('sub_balance'))
                                    <span class="text-danger"> {{ $errors->first('sub_balance') }}</span>
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