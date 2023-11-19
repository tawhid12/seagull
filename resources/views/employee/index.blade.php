@extends('layout.app')
@section('pageTitle','Employee List')
@section('pageSubTitle','All Employee')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('employee.create')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr>
                        <th scope="col" width="20px">{{__('#SL')}}</th>
                        <th scope="col">{{__('Employee Name')}}</th>
                        <th scope="col">{{__('Address')}}</th>
                        <th scope="col">{{__('Father Name')}}</th>
                        <th scope="col">{{__('Mother Name')}}</th>
                        <th scope="col">{{__('Education Qualification')}}</th>
                        <th scope="col">{{__('Mobile')}}</th>
                        <th scope="col">{{__('Joining Date')}}</th>
                        <th scope="col">{{__('Salary')}}</th>
                        <th class="white-space-nowrap" width="80px">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $e)
                    <tr>
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$e->employee_name}}</td>
                        <td>{{$e->address}}</td>
                        <td>{{$e->fathers_name}}</td>
                        <td>{{$e->mothers_name}}</td>
                        <td>{{$e->education_qualification}}</td>
                        <td>{{$e->mobile_no}}</td>
                        <td>{{$e->salary}}</td>
                        <td>{{$e->joining_date}}</td>
                        <td class="d-flex">
                            <!-- <a href="{{route('employee.show',encryptor('encrypt',$e->id))}}">
                                <i class="bi bi-eye"></i>
                            </a> -->
                            <a class="btn btn-sm btn-primary float-end ms-2" href="{{route('salaryDetl.create')}}">
                                Increment
                            </a>
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
                {{$employees->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
