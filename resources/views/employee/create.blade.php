@extends('layout.app')
@section('pageTitle','Add Employee')
@section('pageSubTitle','New Employee')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('/assets/extensions/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/css/pages/filepond.css') }}">
<style>
    /* Overriding styles */
    ::-webkit-input-placeholder {
        font-size: 13px !important;
    }

    :-moz-placeholder {
        /* Firefox 18- */
        font-size: 13px !important;
    }

    ::-moz-placeholder {
        /* Firefox 19+ */
        font-size: 13px !important;
    }
</style>
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <form class="form" method="post" action="{{route('employee.store')}}" enctype="multipart/form-data">
                @csrf
                {{--<div class="row d-flex justify-content-end">
                    <div class="col-12 col-md-3">
                        <div class="card">
                            <div class="card-header p-1">
                                <h5 class="card-title">Photo</h5>
                            </div>
                            <div class="card-content">
                                <div class="card-body p-0">
                                    <!-- Basic file uploader -->
                                    <input type="file" class="" name="profile_img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}

                <div class="row">

                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="employee_name">Employee Name</label>
                            <input type="text" id="employee_name" value="{{old('employee_name')}}" class="form-control" placeholder="" name="employee_name" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_district_id">District</label>
                            <select name="district_id" class="form-control js-example-basic-single" id="district_id" required>
                                <option value="">Select</option>
                                @forelse($districts as $d)
                                <option value="{{$d->id}}" {{ old('district_id')==$d->id?"selected":""}}> {{ $d->name}}</option>
                                @empty
                                <option value="">No Data found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_parm_district_id">Designation</label>
                            <select name="designation_id" class="form-control js-example-basic-single" id="designation_id" required>
                                <option value="">Select</option>
                                @forelse($designation as $d)
                                <option value="{{$d->id}}" {{ old('designation_id')==$d->id?"selected":""}}> {{ $d->designation_name}}</option>
                                @empty
                                <option value="">No Data found</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" rows="4" name="address" id="address"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="fathers_name">Father's name</label>
                            <input type="text" id="fathers_name" value="{{old('fathers_name')}}" class="form-control" placeholder="" name="fathers_name">
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="mothers_name">Mather's Name</label>
                            <input type="text" id="mothers_name" value="{{old('mothers_name')}}" class="form-control" placeholder="" name="mothers_name">
                        </div>
                    </div>



                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="mobile_no">Mobile no</label>
                            <input type="text" id="mobile_no" value="{{old('mobile_no')}}" class="form-control" placeholder="Mobile No" name="mobile_no" required>
                        </div>
                        @if($errors->has('mobile_no'))
                        <span class="text-danger"> {{ $errors->first('mobile_no') }}</span>
                        @endif
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="education_qualification">Education Qualification</label>
                            <input type="text" id="education_qualification" value="{{old('education_qualification')}}" class="form-control" placeholder="Education Qualification" name="education_qualification">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="text" id="salary" value="{{old('salary')}}" class="form-control" placeholder="Salary" name="salary" required>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="joining_date">Joining Date</label>
                            <input type="date" id="joining_date" value="{{old('joining_date')}}" class="form-control" placeholder="Joining Date" name="joining_date" required>
                        </div>
                    </div>




                    {{--<div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="en_dob">Date of Birth</label>
                                <input type="date" id="en_dob" value="{{old('en_dob')}}" class="form-control" placeholder="" name="en_dob">
                </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group">
                <label for="en_age">Age</label>
                <input readonly type="text" id="en_age" value="{{old('en_age')}}" class="form-control" placeholder="" name="en_age">
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group">
                <label for="en_birth_certificate">Birth Registration No</label>
                <input type="text" id="en_birth_certificate" value="{{old('en_birth_certificate')}}" class="form-control" placeholder="" name="en_birth_certificate">
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group">
                <label for="en_nid_no">National Identity Card No</label>
                <input type="text" id="en_nid_no" value="{{old('en_nid_no')}}" class="form-control" placeholder="" name="en_nid_no">
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="form-group">
                <label for="en_marital_status">Marital Status</label>
                <select name="en_marital_status" class="form-control js-example-basic-single" onclick="engetMarriedInfo()" id="en_marital_status">
                    <option value="1">Unmarried</option>
                    <option value="2">Married</option>
                </select>
            </div>
        </div>--}}
    </div>



    <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    </form>
</div>
</div>
</div>


@endsection
@push('scripts')
<script>

</script>

<script src="{{ asset('/assets/extensions/filepond/filepond.js') }}"></script>
<script src="{{ asset('/assets/extensions/toastify-js/src/toastify.js') }}"></script>
<script src="{{ asset('/assets/js/pages/filepond.js') }}"></script>
@endpush