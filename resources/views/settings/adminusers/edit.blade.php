@extends('layout.app')

@section('pageTitle',trans('Update Users'))
@section('pageSubTitle',trans('Update'))
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                @if(Session::has('response'))
                {!!Session::get('response')['message']!!}
                @endif
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('adminuser.update',encryptor('encrypt',$user->id))}}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$user->id)}}">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="userName">Name <span class="text-danger">*</span></label>
                                        <input type="text" id="userName" class="form-control" value="{{ old('userName',$user->name)}}" name="userName">
                                        @if($errors->has('userName'))
                                        <span class="text-danger"> {{ $errors->first('userName') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="userEmail">Email <span class="text-danger">*</span></label>
                                        <input type="text" id="userEmail" class="form-control" value="{{ old('userEmail',$user->email)}}" name="userEmail">
                                        @if($errors->has('userEmail'))
                                        <span class="text-danger"> {{ $errors->first('userEmail') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="contactNumber">Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" id="contactNumber" class="form-control" value="{{ old('contactNumber',$user->contact_no)}}" name="contactNumber">
                                        @if($errors->has('contactNumber'))
                                        <span class="text-danger"> {{ $errors->first('contactNumber') }}</span>
                                        @endif
                                    </div>
                                </div>



                                @if(currentUser() == 'superadmin' && $user->permission_type == 1)
                                <div class="col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="role_id">Role <span class="text-danger">*</span></label>
                                        <select id="role_id" class="form-control" name="role_id" required>
                                            <option value="">Select Role</option>
                                            @forelse($role as $data)
                                            <option {{old('role_id',$user->role_id)==$data->id?"selected":""}} value="{{$data->id}}">{{$data->type}}</option>
                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('role_id'))
                                    <span class="text-danger"> {{ $errors->first('role_id') }}</span>
                                    @endif
                                </div>
                                @endif

                                @if(currentUser() == 'superadmin' && $user->permission_type == 2)
                                <div class="col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="multiple_role_id">Multiple Role<span class="text-danger">*</span></label>
                                        <select id="multiple_role_id" class="form-control js-example-basic-multiple" multiple="multiple" name="multiple_role_id[]">
                                            <option value="">Select Role</option>
                                            @forelse($role as $data)
                                            <option {{ in_array($data->id, $userRoles) ? 'selected' : '' }} value="{{$data->id}}">{{$data->type}}</option>
                                            @empty
                                            <option value="">No Data Found</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                @endif

                                <div class="col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select id="status" class="form-control" name="status">
                                            <option value="">Select Status</option>
                                            <option {{old('status',$user->status)=="1"?"selected":""}} value="1">Active</option>
                                            <option {{old('status',$user->status)=="2"?"selected":""}} value="2">Inactive</option>
                                        </select>
                                    </div>
                                    @if($errors->has('status'))
                                    <span class="text-danger"> {{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                                {{--<div class="col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="permission_type">Permission Type<span class="text-danger">*</span></label>
                                        <select id="permission_type" class="form-control" name="permission_type">
                                            <option value="">Select Access</option>
                                            <option {{old('permission_type',$user->permission_type)=="1"?"selected":""}} value="1">User Based</option>
                                <!-- <option {{old('permission_type',$user->permission_type)=="2"?"selected":""}} value="2">Role Based</option> -->
                                </select>
                            </div>
                            @if($errors->has('all_company_access'))
                            <span class="text-danger"> {{ $errors->first('all_company_access') }}</span>
                            @endif
                    </div>--}}

                    <div class="col-sm-4 col-12 mt-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="full_access" name="full_access" value="1">
                            <label class="form-check-label" for="full_access">Full Access</label>
                        </div>
                        @if($errors->has('full_access'))
                        <span class="text-danger"> {{ $errors->first('full_access') }}</span>
                        @endif
                    </div>

                    <!-- <div class="col-sm-4 col-12">
                                    <div class="form-group">
                                        <label for="show_price">Product Price Access <span class="text-danger">*</span></label>
                                        <select id="show_price" class="form-control" name="show_price">
                                            <option value="">Select Access</option>
                                            <option {{old('show_price',$user->show_price)=="1"?"selected":""}} value="1">Active</option>
                                            <option {{old('show_price',$user->show_price)=="2"?"selected":""}} value="2">Inactive</option>
                                        </select>
                                    </div>
                                    @if($errors->has('show_price'))
                                    <span class="text-danger"> {{ $errors->first('show_price') }}</span>
                                    @endif
                                </div> -->

                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" class="form-control" placeholder="Image" name="image">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary m-1">Update</button>
                    </div>
                </div>
                </form>
                {{--@if(currentUser() == 'superadmin')--}}
                <h4>Company Assign</h4>
                <ul class="list-unstyled mb-0">
                    <form method="POST" action="{{ route('assignCompany', $user->id) }}">
                        @csrf
                        @forelse($company as $c)
                        <li class="d-inline-block me-2 mb-1">
                            <div class="form-check">
                                <div class="checkbox">
                                    <input type="checkbox" name="company_id[]" class="form-check-input" id="company_id" value="{{ $c->id }}" @if (in_array($c->id, $user->company->pluck('id')->toArray())) checked @endif>
                                    <label for="company">{{$c->company_name}}</label>
                                </div>
                            </div>
                        </li>
                        @empty
                        @endforelse
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success me-1 mb-1">Assign Company</button>
                            </div>
                        </div>
                    </form>
                </ul>
                <hr />
                {{--@endif--}}
                {{--<h4 class="border-bottom my-3">All Permissions</h4>
                        <ul class="list-unstyled mb-0">
                            <form method="POST" action="{{ route('assignPermissions', $user->id) }}">
                <div class="row">
                    @csrf
                    @forelse($permissions as $p)
                    <div class="col-12 col-md-2">
                        <li class="d-inline-block me-2 mb-1">
                            <div class="form-check">
                                <div class="checkbox">
                                    <input type="checkbox" name="permissions[]" class="form-check-input" id="permissions" value="{{ $p->id }}" @if (in_array($p->id, $user->permissions->pluck('id')->toArray())) checked @endif>
                                    <label for="permission">{{$p->name}}</label>
                                </div>
                            </div>
                        </li>
                    </div>
                    @empty
                    @endforelse
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Assign Permissions</button>
                        </div>
                    </div>
                </div>
                </form>
                </ul>--}}
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.js-example-basic-multiple').select2({
        placeholder: "Select Role"
    });

    function showBranch(e) {
        $('#branch_id .branchs').hide();
        $('#branch_id .branchs' + e.value).show();
    }

    function hideCompany(e) {
        if (e == "1" || e == "2") {
            $('.company_row').hide();
        } else {
            $('.company_row').show();
        }
    }
    if ($('#role_id').val() == "1" || $('#role_id').val() == "2") {
        $('.company_row').hide();
    } else {
        $('.company_row').show();
    }
</script>
@endpush