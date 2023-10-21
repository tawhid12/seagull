@extends('layout.app')

@section('pageTitle','Create Master Account')
@section('pageSubTitle','Create Master Account')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('accountMaster.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="fcoa_master">Master Account</label>
                                        <input type="text" id="fcoa_master" class="form-control" placeholder="Master Account" name="fcoa_master">
                                    </div>
                                    @if($errors->has('fcoa_master'))
                                    <span class="text-danger"> {{ $errors->first('fcoa_master') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="master_code">Code</label>
                                        <input type="text" id="master_code" class="form-control" name="master_code">
                                    </div>
                                    @if($errors->has('master_code'))
                                    <span class="text-danger"> {{ $errors->first('master_code') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="master_balance">Balance</label>
                                        <input type="text" id="master_balance" class="form-control" placeholder="Balance" name="master_balance">
                                    </div>
                                    @if($errors->has('master_balance'))
                                    <span class="text-danger"> {{ $errors->first('master_balance') }}</span>
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