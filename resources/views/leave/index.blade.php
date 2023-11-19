@extends('layout.app')

@section('pageTitle','Leave List')
@section('pageSubTitle','Leave List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
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
                            <label for="tax">Select Leave Type</label>
                            <select name="leave_type_id" class="form-control">
                                <option value="">Select</option>
                                @forelse($leave_types as $lt)
                                <option value="{{$lt->id}}">{{$lt->leave_type}}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        @if($errors->has('employee_id'))
                        <span class="text-danger"> {{ $errors->first('employee_id') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3 col-12">
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
                    <div class="col-sm-3">
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

                    <div class="col-12 d-flex justify-content-end my-2">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Find</button>

                    </div>
                </div>
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('leave.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Leave Type')}}</th>
                                <th scope="col">{{__('Leave Duration')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $l)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$l->employee->employee_name}}</td>
                                <td>{{$l->leave_type->leave_type}}</td>
                                <td>{{\Carbon\Carbon::createFromTimestamp(strtotime($l->from_date))->format('j M, Y')}}-{{\Carbon\Carbon::createFromTimestamp(strtotime($l->to_date))->format('j M, Y')}}</td>
                                <td>@if($l->status == 1) {{__('Approved') }} @else {{__('Un Approved') }} @endif</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('leave.edit',encryptor('encrypt',$l->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$l->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$l->id}}" action="{{route('leave.destroy',encryptor('encrypt',$l->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Leave Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $leaves->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection