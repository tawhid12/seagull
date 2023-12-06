@extends('layout.app')

@section('pageTitle','Create Invoice')
@section('pageSubTitle','Create Invoice')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('invoice.store')}}">
                            @csrf
                            <div class="row">
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
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="name">Invoice No</label>
                            <input type="text" id="invoice_no" class="form-control" placeholder="Invoice No" name="invoice_no">
                        </div>
                        @if($errors->has('invoice_no'))
                        <span class="text-danger"> {{ $errors->first('invoice_no') }}</span>
                        @endif
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="tax">Select Client</label>
                            <select name="client_id" class="form-control">
                                <option value="">Select</option>
                                @forelse($clients as $c)
                                <option value="{{$c->id}}">{{$c->client_name}}</option>
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
                                <option value="{{$v->id}}">{{$v->vessel_name}}</option>
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
                                <option value="1">BDT</option>
                                <option value="2">USD</option>
                            </select>
                        </div>
                        @if($errors->has('currency'))
                        <span class="text-danger"> {{ $errors->first('currency') }}</span>
                        @endif
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" id="amount" class="form-control" placeholder="Amount" name="amount">
                        </div>
                        @if($errors->has('amount'))
                        <span class="text-danger"> {{ $errors->first('amount') }}</span>
                        @endif
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="posted_on">Posted On</label>
                            <input type="text" id="posted_on" name="posted_on" class="form-control" placeholder="dd/mm/yyyy" required>
                        </div>
                        @if($errors->has('posted_on'))
                        <span class="text-danger"> {{ $errors->first('posted_on') }}</span>
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
    $(document).ready(function() {
        $("#posted_on").daterangepicker({
            singleDatePicker: true,
            startDate: new Date(),
            showDropdowns: true,
            autoUpdateInput: true,
            format: 'dd/mm/yyyy',
        }).on('changeDate', function(e) {
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