@extends('layout.app')

@section('pageTitle','Create Other Requistion')
@section('pageSubTitle','Create Other Requisition')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('otherRequisition.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="title">Requistion Title</label>
                                        <input type="text" id="title" class="form-control" placeholder="Requisition Title" name="title">
                                    </div>
                                    @if($errors->has('title'))
                                    <span class="text-danger"> {{ $errors->first('title') }}</span>
                                    @endif
                                </div>
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
                                        <label for="amount">Amount</label>
                                        <input type="text" id="amount" class="form-control" placeholder="Amount" name="amount">
                                    </div>
                                    @if($errors->has('amount'))
                                    <span class="text-danger"> {{ $errors->first('amount') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="des">Description</label>
                                        <textarea id="des" class="form-control" placeholder="Description" name="des" rows="5"></textarea>
                                    </div>
                                    @if($errors->has('des'))
                                    <span class="text-danger"> {{ $errors->first('des') }}</span>
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