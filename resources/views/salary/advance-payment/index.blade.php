@extends('layout.app')

@section('pageTitle','Advance Salary')
@section('pageSubTitle','Advance Slip')

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
                        <a class="btn btn-sm btn-primary float-end" href="{{route('salary-advance-payment.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Advance Salary')}}</th>
                                <th scope="col">{{__('Deduction')}}</th>
                                <th scope="col">{{__('Balance')}}</th>
                                <th scope="col">{{__('Paid Date')}}</th>
                                <th scope="col">{{__('Month')}}</th>
                                <th scope="col">{{__('Year')}}</th>
                                <th scope="col">{{__('Adjusted On')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salary_adv_payments as $sadp)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$sadp->employee->employee_name}}</td>
                                <td>{{$sadp->adv_salary}}</td>
                                <td>{{$sadp->deduction}}</td>
                                <td>{{$sadp->balance}}</td>
                                <td>{{ \Carbon\Carbon::create($sadp->paid_date)->format('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::create($sadp->month)->format('M') }}</td>
                                <td>{{$sadp->year}}</td>
                                <td>{{ \Carbon\Carbon::create($sadp->adjusted_on)->format('d F Y') }}</td>
                                <td>@if($sadp->status == 1) {{__('Adjusted') }} @else {{__('Not Adjusted') }} @endif</td>
                                <td class="white-space-nowrap">
                                    <a class="btn btn-sm btn-success" href="{{route('salary-advance-payment.show',encryptor('encrypt',$sadp->id))}}">
                                        <span><i class="bi bi-eye"></i></span>
                                    </a>
                                    @if($sadp->status == 2 && currentUser() == 'accountant')
                                    <a class="btn btn-sm btn-success" href="{{route('autodebitvoucher.create',['id' => encryptor('encrypt',$sadp->id)])}}">
                                        <i class="bi bi-pencil-square"></i>Paid
                                    </a>
                                    @endif
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$sadp->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$sadp->id}}" action="{{route('salary-advance-payment.destroy',encryptor('encrypt',$sadp->id))}}" method="post">
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
                        {{ $salary_adv_payments->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection