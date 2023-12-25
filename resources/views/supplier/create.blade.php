@extends('layout.app')

@section('pageTitle','Create Supplier')
@section('pageSubTitle','Create Supplier')

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data"
                                  action="{{route('supplier.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="supplier_name" class="form-control"
                                                   placeholder="Supplier Name" name="supplier_name">
                                        </div>
                                        @if($errors->has('supplier_name'))
                                            <span class="text-danger"> {{ $errors->first('supplier_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" id="phone" class="form-control" placeholder="Land Phone"
                                                   name="phone">
                                        </div>
                                        @if($errors->has('email'))
                                            <span class="text-danger"> {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" id="mobile" class="form-control" placeholder="Mobile No"
                                                   name="mobile">
                                        </div>
                                        @if($errors->has('mobile'))
                                            <span class="text-danger"> {{ $errors->first('mobile') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Email</label>
                                            <input type="text" id="email" class="form-control" placeholder="Email"
                                                   name="email">
                                        </div>
                                        @if($errors->has('email'))
                                            <span class="text-danger"> {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Fax</label>
                                            <input type="text" id="fax" class="form-control" placeholder="Fax"
                                                   name="fax">
                                        </div>
                                        @if($errors->has('fax'))
                                            <span class="text-danger"> {{ $errors->first('fax') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="web">Website</label>
                                            <input type="text" id="web" class="form-control" placeholder="Web"
                                                   name="web">
                                        </div>
                                        @if($errors->has('web'))
                                            <span class="text-danger"> {{ $errors->first('web') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="5" id="description" placeholder="description"
                                                      name="description"></textarea>
                                        </div>
                                        @if($errors->has('description'))
                                            <span class="text-danger"> {{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" rows="5" id="address" placeholder="Address"
                                                      name="address"></textarea>
                                        </div>
                                        @if($errors->has('address'))
                                            <span class="text-danger"> {{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="tin">TIN</label>
                                            <input type="text" id="tin" class="form-control" placeholder="TIN"
                                                   name="tin">
                                        </div>
                                        @if($errors->has('tin'))
                                            <span class="text-danger"> {{ $errors->first('tin') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="tin_name">TIN Name</label>
                                            <input type="text" id="tin_name" class="form-control" placeholder="Tin Name"
                                                   name="tin_name">
                                        </div>
                                        @if($errors->has('tin_name'))
                                            <span class="text-danger"> {{ $errors->first('tin_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="bin">BIN</label>
                                            <input type="text" id="tin" class="form-control" placeholder="BIN"
                                                   name="bin">
                                        </div>
                                        @if($errors->has('bin'))
                                            <span class="text-danger"> {{ $errors->first('bin') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="bin_name">BIN Name</label>
                                            <input type="text" id="bin_name" class="form-control" placeholder="Bin Name"
                                                   name="bin_name">
                                        </div>
                                        @if($errors->has('bin_name'))
                                            <span class="text-danger"> {{ $errors->first('bin_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="contact_person_name">Contact Person Name</label>
                                            <input type="text" id="contact_person_name" class="form-control"
                                                   placeholder="Contact Person Name" name="contact_person_name">
                                        </div>
                                        @if($errors->has('contact_person_name'))
                                            <span
                                                class="text-danger"> {{ $errors->first('contact_person_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="contact_person_phone">Contact Person Phone</label>
                                            <input type="text" id="contact_person_phone" class="form-control"
                                                   placeholder="Contact Person Phone" name="contact_person_phone">
                                        </div>
                                        @if($errors->has('contact_person_phone'))
                                            <span
                                                class="text-danger"> {{ $errors->first('contact_person_phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="contact_person_email">Contact Person Email</label>
                                            <input type="text" id="contact_person_email" class="form-control"
                                                   placeholder="Contact Person Email" name="contact_person_email">
                                        </div>
                                        @if($errors->has('contact_person_email'))
                                            <span
                                                class="text-danger"> {{ $errors->first('contact_person_email') }}</span>
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
