@extends('layout.app')

@section('pageTitle','Edit Leave Type')
@section('pageSubTitle','Edit Leave Type')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('leave-type.update',encryptor('encrypt',$lt->id))}}">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$lt->id)}}">
                            <div class="row">

                                <div class="col-sm-3">
                                    <label for="year">Type</label>
                                    <input type="text" name="leave_type" class="form-control" value="{{$lt->leave_type}}">
                                </div>

                                <div class="col-12 d-flex justify-content-end my-2">
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