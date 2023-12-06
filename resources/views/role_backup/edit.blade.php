@extends('layout.app')
@section('pageTitle','Edit Role')
@section('pageSubTitle','Update Role')
@push('styles')
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <!-- <form class="form" method="post" action="" enctype="multipart/form-data"> -->
                @csrf
                @method('patch')
                <div class="row">
                    <h5 class="text-center">Role Type {{$r->type}}</h5>
                    <h5>All Permissions</h5>
                    <ul class="list-unstyled mb-0">
                        <form method="POST" action="{{route('role.permission',encryptor('encrypt',$r->id))}}">
                            <div class="row">
                                @csrf
                                @forelse($permissions as $p)
                                <div class="col-12 col-md-2">
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <input type="checkbox" name="permissions[]" class="form-check-input" id="permissions" value="{{ $p->id }}" @if (in_array($p->id, $r->permissions->pluck('id')->toArray())) checked @endif>
                                                <label for="permission">{{$p->name}}</label>
                                            </div>
                                        </div>
                                    </li>
                                </div>
                                @empty
                                @endforelse
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save Permissions</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </ul>
                </div>
                <!-- <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div> -->
            <!-- </form> -->
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush