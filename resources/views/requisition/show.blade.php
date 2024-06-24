@extends('layout.app')

@section('pageTitle','Requsition Details')
@section('pageSubTitle','Requisition Details')


@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                
    
                
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="requisition table table-bordered mb-0">
                       
                        <thead>
                            <tr>
                               
                                <th scope="col">{{__('Fund Requisition Info')}}</th>
                               
                              
                                <th scope="col">{{__('Requisition Amount')}}</th>
                                <th scope="col">{{__('Account Code')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                               
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
            
                                <td>
                                    <p class="m-0"><strong>Title:-</strong>{{$r->title}}</p>
                                    <p class="m-0"><strong>Fund Requisition:-</strong>{{$r->req_slip_no}}</p>
                                    <p class="m-0"><strong>Posting Date:-</strong>{{date('d M Y',strtotime($r->postingDate))}}</p>
                                   <p class="m-0"><strong>Posted By:-</strong>{{$r->posted_by?->name}}</p> 
                                   <p class="m-0"><strong>@if ($r->status ==0) Unapproved  @else Approved @endif By:-</strong>{{$r->approved?->name}}</p>
                                </td>
                               
                                <td>{{$r->approve_amount}}</td>
                                <td>{{$r->account_code}}</td>
                                <td>@if($r->status == 1) {{__('Approved') }} @else {{__('UnApproved') }} @endif</td>
                               
                               
                            </tr>
                     
                            
                        </tbody>
                    </table>

                   
                      <h5>Order Details</h5></th>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Order No') }}</th>
                                    <th scope="col">{{ __('Company') }}</th>
                                    <th scope="col">{{ __('Client') }}</th>
                                    <th scope="col">{{ __('Vessel') }}</th>
                                    <th scope="col">{{ __('Invoice') }}</th>
                                    <th scope="col">{{ __('Receive') }}</th>
                                    <th scope="col">{{ __('Due') }}</th>
                                    <th scope="col">{{ __('Posted On') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>{{ $or->id }}</td>
                                    <td>{{ $or->company?->company_name }}</td>
                                    <td>{{ $or->client?->client_name }}</td>
                                    <td>{{ $or->vessel?->vessel_name }}</td>
                                    <td>{{ $or->amount }}</td>
                                    <td>{{ $or->payments->sum('amount') }}</td>
                                    <td>{{ $or->amount - $or->payments->sum('amount') }}</td>
                                    <td>{{ $or->posted_on }}</td>
                                </tr>
                                <tr>
                                    <td colspan="8">{!! $or->order_details !!}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($or->service_report->count() > 0)
                        <div class="row">
                            <h5 class="text-center my-2">Service Report (Attachments)</h5>
                            @forelse ($or->service_report as $sr)
                                <div class="col-md-3"><iframe src="{{ asset($sr->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                        @endif
                        @if($or->delivery_report->count() > 0)
                        <div class="row">
                            <h5 class="text-center my-2">Delivery Report (Attachments)</h5>
                            @forelse ($or->delivery_report as $dr)
                                <div class="col-md-3"><iframe src="{{ asset($dr->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                        @endif
                        @if($or->invoice_report->count() > 0)
                        <div class="row">
                            <h5 class="text-center my-2">Invoice Report (Attachments)</h5>
                            @forelse ($or->invoice_report as $ir)
                                <div class="col-md-3"><iframe src="{{ asset($ir->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                        @endif
                        @if($or->work_done_report->count() > 0)
                        <div class="row">
                            <h5 class="text-center my-2">Work Done (Certificates)</h5>
                            @forelse ($or->work_done_report as $sr)
                                <div class="col-md-3"><iframe src="{{ asset($sr->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection
@push('scripts')
<script src="{{asset('assets/multiselect/jquery.multi-select.js')}}"></script>
<script src="{{asset('assets/select2/select2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script>
    $('.js-example-basic-single').select2({
        placeholder: 'Select Option',
        allowClear: true
    });
    /*=========== Approve ============*/
    $('.approve').on('click', function(event) {
        var title = $(this).data("title");
        var status = $(this).data("status");
        if(status == 1){
            var text = `Are want to  UnApprove  this ${title}?`;
            var icon = 'error';
            var mode = true;
        }else{
            var text = `Are want to  Approve  this ${title}?`;
            var icon = 'success';
            var mode = false;
        }
        event.preventDefault();
        swal({
                title: text,
                icon: icon,
                buttons: true,
                dangerMode: mode,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parent().submit();
                }
            });
    });
</script>
@endpush
