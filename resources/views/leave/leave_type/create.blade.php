@extends('layout.app')

@section('pageTitle','Add Leave Type')
@section('pageSubTitle','Add Leave Type')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('leave-type.store')}}">
                            @csrf
                            <div class="row">

                                <div class="col-sm-3">
                                    <label for="year">Type</label>
                                    <input type="text" name="leave_type" class="form-control">
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