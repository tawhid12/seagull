@extends('layout.app')

@section('pageTitle','Create Company')
@section('pageSubTitle','Create Company')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('company.store', ['role' =>currentUser()])}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="company_name" class="form-control" placeholder="Company Name" name="company_name">
                                    </div>
                                    @if($errors->has('company_name'))
                                    <span class="text-danger"> {{ $errors->first('company_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Website</label>
                                        <input type="text" id="website" class="form-control" placeholder="Company Website" name="website">
                                    </div>
                                    @if($errors->has('website'))
                                    <span class="text-danger"> {{ $errors->first('website') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Tax</label>
                                        <input type="text" id="tax_no" class="form-control" placeholder="Tax" name="tax_no">
                                    </div>
                                    @if($errors->has('tax_no'))
                                    <span class="text-danger"> {{ $errors->first('tax_no') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea rows="5" id="address" class="form-control" placeholder="Company Address" name="address"></textarea>
                                    </div>
                                    @if($errors->has('address '))
                                    <span class="text-danger"> {{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" id="city" class="form-control" placeholder="City" name="city">
                                    </div>
                                    @if($errors->has('city'))
                                    <span class="text-danger"> {{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" id="country" class="form-control" placeholder="Country" name="country">
                                    </div>
                                    @if($errors->has('country'))
                                    <span class="text-danger"> {{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="zip_code">Zip Code</label>
                                        <input type="text" id="zip_code" class="form-control" placeholder="Zip Code" name="zip_code">
                                    </div>
                                    @if($errors->has('zip_code'))
                                    <span class="text-danger"> {{ $errors->first('zip_code') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" class="form-control" placeholder="Email" name="email">
                                    </div>
                                    @if($errors->has('email'))
                                    <span class="text-danger"> {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="contact_no">Contact No</label>
                                        <input type="text" id="contact_no" class="form-control" placeholder="contact_no" name="contact_no">
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