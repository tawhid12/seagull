@extends('layout.app')

@section('pageTitle','Create Master Sub One')
@section('pageSubTitle','Create Master Sub One')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('accountMasterSubBkdn.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Master Sub</label>
                                        <select name="fcoa_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($accountMasterSub as $ams)
                                            <option value="{{$ams->fcoa_id}}">{{$ams->fcoa}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('fcoa_id'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="fcoa">Sub One Account</label>
                                        <input type="text" id="fcoa_bkdn" class="form-control" placeholder="Sub One" name="fcoa_bkdn">
                                    </div>
                                    @if($errors->has('fcoa_bkdn'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_bkdn') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="bkdn_code">Code</label>
                                        <input type="text" id="bkdn_code" class="form-control" name="bkdn_code">
                                    </div>
                                    @if($errors->has('bkdn_code'))
                                    <span class="text-danger"> {{ $errors->first('bkdn_code') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="bkdn_balance">Balance</label>
                                        <input type="text" id="bkdn_balance" class="form-control" placeholder="Balance" name="bkdn_balance">
                                    </div>
                                    @if($errors->has('bkdn_balance'))
                                    <span class="text-danger"> {{ $errors->first('bkdn_balance') }}</span>
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