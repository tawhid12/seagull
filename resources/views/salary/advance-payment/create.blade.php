@extends('layout.app')

@section('pageTitle','Advance Salary')
@section('pageSubTitle','Advance Salary')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form class="form" method="post" enctype="multipart/form-data" action="{{route('salary-advance-payment.store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="tax">Select Employees</label>
                                <select name="employee_id" class="form-control">
                                    <option value="">Select</option>
                                    @forelse($employees as $e)
                                    <option value="{{$e->id}}">{{$e->employee_name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            @if($errors->has('employee_id'))
                            <span class="text-danger"> {{ $errors->first('employee_id') }}</span>
                            @endif
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select name="month" class="js-example-basic-single form-control me-3">
                                    <option></option>
                                    @php
                                    $months = array("Jan", "Feb", "Mar", "Apr","May","June","July","August","September","October","November","December");
                                    for($i=0;$i<count($months);$i++){ $monthValue=$i + 1; @endphp <option value="{{$monthValue}}" @if(request()->get('month') == $monthValue) selected @endif>{{$months[$i]}}</option>
                                        @php
                                        }
                                        @endphp
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select name="year" class="js-example-basic-single form-control me-3">
                                    <option></option>
                                    @php
                                    for($i=2023;$i<=2023;$i++){ @endphp <option value="{{$i}}" @if(request()->get('year') == $i) selected @endif>{{$i}}</option>
                                        @php
                                        }
                                        @endphp
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="deduction">Deduction (Per Month)</label>
                                <input type="text" class="form-control" name="deduction">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="adv_salary">Advance Salary Amount</label>
                                <input type="text" class="form-control" name="adv_salary">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="Category">{{__('Received Account')}}</label>
                                <select class="form-control form-select" name="credit">
                                    @if($paymethod)
                                    @foreach($paymethod as $d)
                                    <option value="{{$d['table_name']}}~{{$d['id']}}~{{$d['head_name']}}-{{$d['head_code']}}">{{$d['head_name']}}-{{$d['head_code']}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end my-2">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Advance Payment</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection