@extends('layout.app')

@section('pageTitle','Salary Slip')
@section('pageSubTitle','Salary Slip')

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
                        <a class="btn btn-sm btn-primary float-end" href=""><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Working Day')}}</th>
                                <th scope="col">{{__('Present')}}</th>
                                <th scope="col">{{__('Leave')}}</th>
                                <th scope="col">{{__('Absent')}}</th>
                                <th scope="col">{{__('From Date')}}</th>
                                <th scope="col">{{__('To Date')}}</th>
                                <th scope="col">{{__('Payable Salary')}}</th>
                                <th scope="col">{{__('Paid Date')}}</th>
                                <th scope="col">{{__('Absent Deduction')}}</th>
                                <th scope="col">{{__('Advance Deduction')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salary_slips as $salary_slip)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$salary_slip->employee->employee_name}}</td>
                                <td>{{$salary_slip->total_working_day}}</td>
                                <td>{{$salary_slip->total_present}}</td>
                                <td>{{$salary_slip->total_leave}}</td>
                                <td>{{$salary_slip->total_absent}}</td>
                                <td>{{ \Carbon\Carbon::create($salary_slip->from_date)->format('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::create($salary_slip->to_date)->format('d F Y') }}</td>
                                <td>{{$salary_slip->salary}}</td>
                                <td>{{$salary_slip->paid_date}}</td>
                                <td>{{$salary_slip->absent_deduction}}</td>
                                <td>{{$salary_slip->deduction}}</td>
                                <td>@if($salary_slip->status == 1) {{__('Paid') }} @else {{__('UnPaid') }} @endif</td>
                                <td class="white-space-nowrap">
                                    <a class="btn btn-sm btn-success" href="{{route('salary-slip.show',encryptor('encrypt',$salary_slip->id))}}">
                                        <span><i class="bi bi-eye"></i></span>
                                    </a>
                                    @if($salary_slip->status == 2 && currentUser() == 'accountant')
                                    <a class="btn btn-sm btn-success" href="{{route('autodebitvoucher.create',['id' => encryptor('encrypt',$salary_slip->id)])}}">
                                        <i class="bi bi-pencil-square"></i>Paid
                                    </a>
                                    @endif
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$salary_slip->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$salary_slip->id}}" action="{{route('salary-slip.destroy',encryptor('encrypt',$salary_slip->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $salary_slips->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection