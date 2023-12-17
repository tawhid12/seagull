@extends('layout.app')

@section('pageTitle','Add Total Working Day')
@section('pageSubTitle','Add Total Working Day')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('total-working-day.update',encryptor('encrypt',$twd->id))}}">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$twd->id)}}">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="year">Working Day</label>
                                        <input type="text" name="total_working_day" class="form-control" value="{{$twd->total_working_day}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="month">Month</label>
                                        <select name="month" class="js-example-basic-single form-control me-3">
                                            <option></option>
                                            @php
                                            $months = array("Jan", "Feb", "Mar", "Apr","May","June","July","August","September","October","November","December");
                                            for($i=0;$i<count($months);$i++){ $monthValue=$i + 1; @endphp <option value="{{$monthValue}}" @if($twd->month == $monthValue) selected @endif>{{$months[$i]}}</option>
                                                @php
                                                }
                                                @endphp
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <select name="year" class="js-example-basic-single form-control me-3">
                                            <option></option>
                                            @php
                                            for($i=2023;$i<=2023;$i++){ @endphp <option value="{{$i}}" @if($twd->year == $i) selected @endif>{{$i}}</option>
                                                @php
                                                }
                                                @endphp
                                        </select>
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