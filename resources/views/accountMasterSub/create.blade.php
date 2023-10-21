@extends('layout.app')

@section('pageTitle','Create Master Sub Account')
@section('pageSubTitle','Create Master Sub Account')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('accountMasterSub.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Master Account</label>
                                        <select name="fcoa_master_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($accountMaster as $am)
                                            <option value="{{$am->master_id}}">{{$am->fcoa_master}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('fcoa_master_id'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_master_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="fcoa">Sub Account</label>
                                        <input type="text" id="fcoa" class="form-control" placeholder="Sub Account" name="fcoa">
                                    </div>
                                    @if($errors->has('fcoa'))
                                    <span class="text-danger"> {{ $errors->first('fcoa') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="fcoa_code">Code</label>
                                        <input type="text" id="fcoa_code" class="form-control" name="fcoa_code">
                                    </div>
                                    @if($errors->has('fcoa_code'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_code') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="fcoa_balance">Balance</label>
                                        <input type="text" id="fcoa_balance" class="form-control" placeholder="Balance" name="fcoa_balance">
                                    </div>
                                    @if($errors->has('fcoa_balance'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_balance') }}</span>
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