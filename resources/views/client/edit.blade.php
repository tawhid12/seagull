@extends('layout.app')

@section('pageTitle','Edit Client')
@section('pageSubTitle','Edit Client')

@section('content')

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('client.update',encryptor('encrypt',$c->id), ['role' =>currentUser()])}}">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$c->id)}}">
                            <div class="row">
                                {{--<div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Company</label>
                                        <select name="company_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($assigned_companies as $ac)
                                            <option value="{{$ac->id}}" @if($ac->id == $c->company_id) selected @endif>{{$ac->company_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('company_id'))
                                    <span class="text-danger"> {{ $errors->first('company_id') }}</span>
                                    @endif
                                </div>--}}
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="client_name" class="form-control" value="{{old('client_name',$c->client_name)}}" placeholder="Client Name" name="client_name">
                                    </div>
                                    @if($errors->has('client_name'))
                                    <span class="text-danger"> {{ $errors->first('client_name') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Email</label>
                                        <input type="text" id="email" class="form-control" value="{{old('email',$c->email)}}" placeholder="Email" name="email">
                                    </div>
                                    @if($errors->has('email'))
                                    <span class="text-danger"> {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="contact_no">Contact</label>
                                        <input type="text" id="contact_no" class="form-control" value="{{old('contact_no',$c->contact_no)}}" placeholder="Contact No" name="contact_no">
                                    </div>
                                    @if($errors->has('contact_no'))
                                    <span class="text-danger"> {{ $errors->first('contact_no') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->
</div>
@endsection