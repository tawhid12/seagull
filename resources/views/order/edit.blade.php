@extends('layout.app')

@section('pageTitle','Create Order')
@section('pageSubTitle','Create Order')
@push('styles')
    <!-- Include stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/pages/summernote.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/summernote/summernote-lite.css')}}">
@endpush
@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data"
                                  action="{{route('order.update',encryptor('encrypt',$or->id))}}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$or->id)}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Order Subject</label>
                                            <textarea class="form-control" rows="3" name="order_subject"> {{$or->order_subject}}</textarea>
                                        </div>
                                        @if($errors->has('order_subject'))
                                            <span class="text-danger"> {{ $errors->first('order_subject') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name">Order Details</label>
                                            {{--                                            <textarea id="editor" name="order_details" class="form-control" rows="5"></textarea>--}}
                                            <textarea id="summernote" name="order_details">
                                                {!!  $or->order_details !!}
                                            </textarea>
                                        </div>
                                        @if($errors->has('order_title'))
                                            <span class="text-danger"> {{ $errors->first('order_details') }}</span>
                                        @endif
                                    </div>
                                    {{--<div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Select Company</label>
                                            <select name="company_id" class="form-control">
                                                <option value="">Select</option>
                                                @forelse($assigned_companies as $ac)
                                                <option value="{{$ac->id}}">{{$ac->company_name}}</option>
                                    @empty
                                    @endforelse
                                    </select>
                                </div>
                                @if($errors->has('company_id'))
                                <span class="text-danger"> {{ $errors->first('company_id') }}</span>
                                @endif
                        </div>--}}

                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="invoice_no">Invoice No</label>
                                            <input type="text" id="invoice_no" class="form-control"
                                                   placeholder="Invoice No" name="invoice_no"
                                                   value="{{ $or->invoice_no }}">
                                        </div>
                                        @if($errors->has('invoice_no'))
                                            <span class="text-danger"> {{ $errors->first('invoice_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="voyage_no">Voyage No</label>
                                            <input type="text" id="voyage_no" class="form-control"
                                                   placeholder="Voyage No" name="voyage_no"  value="{{ $or->voyage_no}}">
                                        </div>
                                        @if($errors->has('voyage_no'))
                                            <span class="text-danger"> {{ $errors->first('voyage_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="invoice_date">Invoice Date</label>
                                            <input type="text" id="invoice_date" name="invoice_date"
                                                   class="form-control"
                                                   placeholder="dd/mm/yyyy" value="{{ $or->invoice_date }}">
                                        </div>
                                        @if($errors->has('invoice_date'))
                                            <span class="text-danger"> {{ $errors->first('invoice_date') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="po_no">Po No</label>
                                            <input type="text" id="po_no" class="form-control"
                                                   placeholder="PO No" name="po_no" value="{{ $or->po_no }}">
                                        </div>
                                        @if($errors->has('invoice_no'))
                                            <span class="text-danger"> {{ $errors->first('invoice_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="po_date">PO Date</label>
                                            <input type="text" id="po_date" name="po_date" class="form-control"
                                                   placeholder="dd/mm/yyyy" value="{{ $or->po_date }}">
                                        </div>
                                        @if($errors->has('po_date'))
                                            <span class="text-danger"> {{ $errors->first('po_date') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Select Client</label>
                                            <select name="client_id" class="form-control">
                                                <option value="">Select</option>
                                                @forelse($clients as $c)
                                                    <option value="{{$c->id}}"
                                                            @if($c->id == $or->client_id) selected @endif>{{$c->client_name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @if($errors->has('client_id'))
                                            <span class="text-danger"> {{ $errors->first('client_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Select Vessel</label>
                                            <select name="vessel_id" class="form-control">
                                                <option value="">Select</option>
                                                @forelse($vessels as $v)
                                                    <option value="{{$v->id}}"
                                                            @if($v->id == $or->vessel_id) selected @endif>{{$v->vessel_name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @if($errors->has('vessel_id'))
                                            <span class="text-danger"> {{ $errors->first('vessel_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="currency">Select Currency</label>
                                            <select name="currency" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1" @if($or->currency == 1) selected @endif>BDT</option>
                                                <option value="2" @if($or->currency == 2) selected @endif>USD</option>
                                            </select>
                                        </div>
                                        @if($errors->has('currency'))
                                            <span class="text-danger"> {{ $errors->first('currency') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="text" id="amount" class="form-control" placeholder="Amount"
                                                   name="amount" value="{{$or->amount}}">
                                        </div>
                                        @if($errors->has('amount'))
                                            <span class="text-danger"> {{ $errors->first('amount') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="posted_on">Posted On</label>
                                            <input type="text" id="posted_on" name="posted_on" class="form-control"
                                                   placeholder="dd/mm/yyyy" required value="{{$or->posted_on}}">
                                        </div>
                                        @if($errors->has('posted_on'))
                                            <span class="text-danger"> {{ $errors->first('posted_on') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="remarks">Remarks</label>
                                            <textarea rows="5" id="remarks" name="remarks"
                                                      class="form-control">{{$or->remarks}}</textarea>
                                        </div>
                                        @if($errors->has('remarks'))
                                            <span class="text-danger"> {{ $errors->first('remarks') }}</span>
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
    <!-- Include the Summernote library -->
    <script src="{{ asset('assets/extensions/summernote/summernote-lite.min.js')}}"></script>
    <script src="{{ asset('assets/js/pages/summernote.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#posted_on,#invoice_date,#po_date").daterangepicker({
                singleDatePicker: true,
                startDate: new Date(),
                showDropdowns: true,
                autoUpdateInput: true,
                format: 'dd/mm/yyyy',
            }).on('changeDate', function (e) {
                var date = moment(e.date).format('YYYY/MM/DD');
                $(this).val(date);
            });
            /*$("select[name='company_id']").on('change', function() {
                var company_id = $(this).val();
                if (company_id) {
                    var url = "{{ url('company/client/') }}/" + company_id;
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res.data);
                        $('#clientData').append(res.data);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            } else {

            }

        });*/

        });
    </script>
@endpush
