@extends('layout.app')
@section('pageTitle','Edit Permission')
@section('pageSubTitle','Edit Permission')
@push('styles')
@endpush
@section('content')
<!-- Bordered table start -->
<div class="col-12 p-3">
    <div class="border">
        <div class="p-3">
            <form class="form" method="post" action="{{route('permission.update',encryptor('encrypt',$p->id))}}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="bn_applicants_name">Permission Name</label>
                            <input type="text" id="name" value="{{old('name',$p->name)}}" class="form-control" placeholder="" name="name">
                        </div>
                    </div>
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

@endpush