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
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('employee.create', ['role' =>currentUser()])}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr>
                        <th scope="col" width="20px">{{__('#SL')}}</th>
                        <th scope="col">{{__('Bangla')}}</th>
                        <th scope="col">{{__('English')}}</th>
                        <th class="white-space-nowrap" width="80px">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $e)
                    <tr>
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>
                            <p><strong>আবেদনকারীর নাম:</strong> {{$e->bn_applicants_name}}</p>
                            <p><strong>পিতার নাম:</strong> {{$e->bn_fathers_name}}</p>
                            <p><strong>মাতার নাম:</strong> {{$e->bn_mothers_name}}</p>
                        </td>
                        <td>
                            <p><strong>Applicant's Name:</strong> {{$e->en_applicants_name}}</p>
                            <p><strong>Father's Name:</strong> {{$e->en_fathers_name}}</p>
                            <p><strong>Mothers's Name:</strong> {{$e->en_mothers_name}}</p>
                        </td>
                        <td class="d-flex">
                            <!-- <a href="{{route('employee.show',encryptor('encrypt',$e->id))}}">
                                <i class="bi bi-eye"></i>
                            </a> -->
                            <a class="btn btn-sm btn-primary float-end ms-2" href="{{route('designation.edit',encryptor('encrypt',$e->id),['role' =>currentUser()])}}">
                                Certificate
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
