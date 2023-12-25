@extends('layout.app')

@section('pageTitle', 'Edit Client')
@section('pageSubTitle', 'Edit Client')

@section('content')

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data"
                                action="{{ route('client.update', encryptor('encrypt', $c->id)) }}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="uptoken" value="{{ encryptor('encrypt', $c->id) }}">
                                <div class="row">
                                    {{-- <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Company</label>
                                        <select name="company_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($assigned_companies as $ac)
                                            <option value="{{$ac->id}}" @if ($ac->id == $c->company_id) selected @endif>{{$ac->company_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if ($errors->has('company_id'))
                                    <span class="text-danger"> {{ $errors->first('company_id') }}</span>
                                    @endif
                                </div> --}}
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" id="client_name" class="form-control"
                                                value="{{ old('client_name', $c->client_name) }}" placeholder="Client Name"
                                                name="client_name">
                                        </div>
                                        @if ($errors->has('client_name'))
                                            <span class="text-danger"> {{ $errors->first('client_name') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="client_short_name">Client Short Name</label>
                                            <input type="text" id="client_short_name" class="form-control" value="{{ old('client_short_name', $c->client_short_name) }}"
                                                placeholder="Client Short Name" name="client_short_name">
                                        </div>
                                        @if ($errors->has('client_short_name'))
                                            <span class="text-danger"> {{ $errors->first('client_short_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" id="phone" class="form-control" value="{{ old('phone', $c->phone) }}"
                                                placeholder="Land Phone" name="phone">
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="text-danger"> {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" id="mobile" class="form-control" value="{{ old('mobile', $c->mobile) }}"
                                                placeholder="Mobile No" name="mobile">
                                        </div>
                                        @if ($errors->has('mobile'))
                                            <span class="text-danger"> {{ $errors->first('mobile') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Email</label>
                                            <input type="text" id="email" class="form-control" value="{{ old('email', $c->email) }}" placeholder="Email"
                                                name="email">
                                        </div>
                                        @if ($errors->has('email'))
                                            <span class="text-danger"> {{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Fax</label>
                                            <input type="text" id="fax" class="form-control" value="{{ old('fax', $c->fax) }}" placeholder="Fax"
                                                name="fax">
                                        </div>
                                        @if ($errors->has('fax'))
                                            <span class="text-danger"> {{ $errors->first('fax') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="web">Website</label>
                                            <input type="text" id="web" class="form-control" value="{{ old('web', $c->web) }}" placeholder="Web"
                                                name="web">
                                        </div>
                                        @if ($errors->has('web'))
                                            <span class="text-danger"> {{ $errors->first('web') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="5" id="description" value="{{ old('description', $c->description) }}" placeholder="Description" name="description"></textarea>
                                        </div>
                                        @if ($errors->has('description'))
                                            <span class="text-danger"> {{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <textarea class="form-control" rows="5" id="address" placeholder="Address" name="address">{{ old('address', $c->address)}}</textarea>
                                        </div>
                                        @if ($errors->has('address'))
                                            <span class="text-danger"> {{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="tin">TIN</label>
                                            <input type="text" id="tin" class="form-control" placeholder="TIN"
                                                name="tin" value="{{ old('tin', $c->tin) }}">
                                        </div>
                                        @if ($errors->has('tin'))
                                            <span class="text-danger"> {{ $errors->first('tin') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="tin_name">TIN Name</label>
                                            <input type="text" id="tin_name" class="form-control"
                                                placeholder="Tin Name" name="tin_name" value="{{ old('tin_name', $c->tin_name) }}">
                                        </div>
                                        @if ($errors->has('tin_name'))
                                            <span class="text-danger"> {{ $errors->first('tin_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="bin">BIN</label>
                                            <input type="text" id="tin" class="form-control" placeholder="Bin"
                                                name="bin" value="{{ old('bin', $c->bin) }}">
                                        </div>
                                        @if ($errors->has('bin'))
                                            <span class="text-danger"> {{ $errors->first('bin') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="bin_name">BIN Name</label>
                                            <input type="text" id="bin_name" class="form-control"
                                                placeholder="Bin Name" name="bin_name">
                                        </div>
                                        @if ($errors->has('bin_name'))
                                            <span class="text-danger"> {{ $errors->first('bin_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="contact_person_name">Contact Person Name</label>
                                            <input type="text" id="contact_person_name" class="form-control"
                                                placeholder="Contact Person Name" name="contact_person_name" value="{{ old('contact_person_name', $c->contact_person_name) }}">
                                        </div>
                                        @if ($errors->has('contact_person_name'))
                                            <span class="text-danger"> {{ $errors->first('contact_person_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="contact_person_phone">Contact Person Phone</label>
                                            <input type="text" id="contact_person_phone" class="form-control"
                                                placeholder="Contact Person Phone" name="contact_person_phone" value="{{ old('contact_person_phone', $c->contact_person_phone) }}">
                                        </div>
                                        @if ($errors->has('contact_person_phone'))
                                            <span class="text-danger"> {{ $errors->first('contact_person_phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="contact_person_email">Contact Person Email</label>
                                            <input type="text" id="contact_person_email" class="form-control"
                                                placeholder="Contact Person Email" name="contact_person_email" value="{{ old('contact_person_email', $c->contact_person_email) }}">
                                        </div>
                                        @if ($errors->has('contact_person_email'))
                                            <span class="text-danger"> {{ $errors->first('contact_person_email') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="taxId">Tax Id</label>
                                            <input type="text" id="taxId" class="form-control" placeholder="Tax Id" name="taxId">
                                        </div>
                                        @if($errors->has('taxId'))
                                            <span class="text-danger"> {{ $errors->first('taxId') }}</span>
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
