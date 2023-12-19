@extends('layout.app')

@section('pageTitle','Edit Company')
@section('pageSubTitle','Edit Company')

@section('content')

<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('company.update',encryptor('encrypt',$c->id))}}">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$c->id)}}">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" value="{{ $c->company_name }}" class="form-control" placeholder="Comapny Name" name="company_name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Website</label>
                                        <input type="text" id="website" value="{{ $c->website }}" class="form-control" placeholder="Company Website" name="website">
                                    </div>
                                    @if($errors->has('website'))
                                    <span class="text-danger"> {{ $errors->first('website') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Tax</label>
                                        <input type="text" id="tax_no" value="{{ $c->tax_no }}" class="form-control" placeholder="Tax" name="tax_no">
                                    </div>
                                    @if($errors->has('tax_no'))
                                    <span class="text-danger"> {{ $errors->first('tax_no') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea rows="5" id="address" class="form-control" placeholder="Company Address" name="address">{{ $c->address }}</textarea>
                                    </div>
                                    @if($errors->has('address '))
                                    <span class="text-danger"> {{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" id="city" value="{{ $c->city }}" class="form-control" placeholder="City" name="city">
                                    </div>
                                    @if($errors->has('city'))
                                    <span class="text-danger"> {{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" id="country" value="{{ $c->country }}" class="form-control" placeholder="Country" name="country">
                                    </div>
                                    @if($errors->has('country'))
                                    <span class="text-danger"> {{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="zip_code">Zip Code</label>
                                        <input type="text" id="zip_code" value="{{ $c->zip_code }}" class="form-control" placeholder="Zip Code" name="zip_code">
                                    </div>
                                    @if($errors->has('zip_code'))
                                    <span class="text-danger"> {{ $errors->first('zip_code') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" value="{{ $c->email }}" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    @if($errors->has('email'))
                                    <span class="text-danger"> {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="contact_no">Contact No</label>
                                        <input type="text" id="contact_no" value="{{ $c->contact_no }}" class="form-control" placeholder="contact_no" name="contact_no">
                                    </div>
                                    @if($errors->has('contact_no'))
                                    <span class="text-danger"> {{ $errors->first('contact_no') }}</span>
                                    @endif
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary mb-1">Update</button>
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