@extends('layout.app')

@section('pageTitle','Create Bank')
@section('pageSubTitle','Create Bank')

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data"
                                  action="{{route('bank.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Select Company</label>
                                            <select name="company_id" class="form-control">
                                                <option value="">Select</option>
                                                @forelse($companies as $c)
                                                    <option value="{{$c->id}}">{{$c->company_name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @if($errors->has('company_id'))
                                            <span class="text-danger"> {{ $errors->first('company_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="name">Bank Name</label>
                                            <input type="text" id="bank_name" class="form-control"
                                                   placeholder="Bank Name" name="bank_name">
                                        </div>
                                        @if($errors->has('bank_name'))
                                            <span class="text-danger"> {{ $errors->first('bank_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="name">Branch</label>
                                            <input type="text" id="branch" class="form-control"
                                                   placeholder="Branch" name="branch">
                                        </div>
                                        @if($errors->has('branch'))
                                            <span class="text-danger"> {{ $errors->first('branch') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="account_name">Account Name</label>
                                            <input type="text" id="account_name" class="form-control" placeholder="Account Name"
                                                   name="account_name">
                                        </div>
                                        @if($errors->has('account_name'))
                                            <span class="text-danger"> {{ $errors->first('account_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="account_no">Account No</label>
                                            <input type="text" id="account_no" class="form-control" placeholder="Account No"
                                                   name="account_no">
                                        </div>
                                        @if($errors->has('account_no'))
                                            <span class="text-danger"> {{ $errors->first('account_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="swift_code">Swift Code</label>
                                            <input type="text" id="swift_code" class="form-control" placeholder="Swift Code"
                                                   name="swift_code">
                                        </div>
                                        @if($errors->has('swift_code'))
                                            <span class="text-danger"> {{ $errors->first('swift_code') }}</span>
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
@push('scripts')
    <script>
        $(document).ready(function () {
        });
    </script>
@endpush
