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
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('total-leave-per-year.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="leave_year">Year</label>
                                        <select name="leave_year" class="js-example-basic-single form-control me-3">
                                            <option></option>
                                            @php
                                            for($i=2023;$i<=2023;$i++){ @endphp <option value="{{$i}}" @if(request()->get('leave_year') == $i) selected @endif>{{$i}}</option>
                                                @php
                                                }
                                                @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="leave_type_id">Select Leave Type</label>
                                        <select name="leave_type_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($leave_types as $lt)
                                            <option value="{{$lt->id}}">{{$lt->leave_type}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('leave_type_id'))
                                    <span class="text-danger"> {{ $errors->first('leave_type_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="total_leave_days">Total Days</label>
                                        <input type="text" id="total_leave_days" name="total_leave_days" class="form-control">
                                    </div>
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