@extends('layout.app')

@section('pageTitle','Requsition List')
@section('pageSubTitle','Requsition List')

@push('styles')
<link href="{{asset('assets/multiselect/multi-select.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                {{--<div class="row my-2">

                    <div class="col-md-6">
                        <a class="btn btn-sm btn-primary me-3" href="{{route('requisition.create')}}">Fund Requisition</a>
                        <a class="btn btn-sm btn-primary" href="{{route('product-requisition.create')}}">Product Requisition</a>

                    </div>
                    <div class="col-md-6">

                        <div class="row">

                            <div class="col-sm-4">
                                <label for="req_type" class="">Requisition Type</label>
                                <select name="req_type" class="js-example-basic-single form-control me-3">
                                    <option></option>
                                    <option value="1" @if(request()->get('req_type') == 1) selected @endif>Product</option>
                                    <option value="2" @if(request()->get('req_type') == 2) selected @endif>Other</option>
                                </select>
                            </div>
                            <div class="col-sm-8 mt-3">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
                                <button type="submit" class="reset-btn btn-sm btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i></button>
                            </div>

                        </div>


                    </div>
                </div>--}}
                <div class="row">
                    <div class="col-md-2 col-12">
                        <label for="month">Month</label>
                        <select name="month" class="js-example-basic-single form-control me-3">
                            <option></option>
                            @php
                            $months = array("Jan", "Feb", "Mar", "Apr","May","June","July","August","September","October","November","December");
                            for($i=0;$i<count($months);$i++){ $monthValue=$i + 1; @endphp <option value="{{$monthValue}}" @if(request()->get('month') == $monthValue) selected @endif>{{$months[$i]}}</option>
                                @php
                                }
                                @endphp
                        </select>
                    </div>
                    <div class="col-md-2 col-12">
                        <label for="year">Year</label>
                        <select name="year" class="js-example-basic-single form-control me-3">
                            <option></option>
                            @php
                            for($i=2024;$i<=date('Y');$i++){ @endphp <option value="{{$i}}" @if(request()->get('year') == $i) selected @endif>{{$i}}</option>
                                @php
                                }
                                @endphp
                        </select>
                    </div>
                    <div class="col-md-1 col-12">
                        <label for="year">Type</label>
                        <select name="year" class="js-example-basic-single form-control me-3">
                            <option></option>
                            <option value="0">UnApprove</option>
                            <option value="1">Approve</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-flex justify-content-end my-2">
                        
                        <button type="submit" class="btn btn-primary me-1 mt-1">Find</button>

                    </div>
                </div>

                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="requisition table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('requisition.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Fund Requisition Info')}}</th>
                                <th scope="col">{{__('Company')}}</th>
                                <th scope="col">{{__('Client')}}</th>
                                <th scope="col">{{__('Vessel')}}</th>
                                {{-- <th scope="col">{{__('Order Amount')}}</th> --}}
                                <th scope="col">{{__('Requisition Amount')}}</th>
                                <th scope="col">{{__('Account Code')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requisitions as $r)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>
                                    <p class="m-0"><strong>Title:-</strong>{{$r->title}}</p>
                                    <p class="m-0"><strong>Fund Requisition:-</strong>{{$r->req_slip_no}}</p>
                                    <p class="m-0"><strong>Posting Date:-</strong>{{date('d M Y',strtotime($r->postingDate))}}</p>
                                   <p class="m-0"><strong>Posted By:-</strong>{{$r->posted_by?->name}}</p> 
                                   <p class="m-0"><strong>@if ($r->status ==0) Unapproved  @else Approved @endif By:-</strong>{{$r->approved?->name}}</p>
                                </td>
                                <td>{{$r->company?->company_name}}</td>
                                <td>{{$r->order?->client?->client_name}}</td>
                                <td>{{$r->order?->vessel?->vessel_name}}</td>
                                {{-- <td>{{$r->order_amount}}</td> --}}
                                <td>{{$r->approve_amount}}</td>
                                <td>{{$r->account_code}}</td>
                                <td>@if($r->status == 1) {{__('Approved') }} @else {{__('UnApproved') }} @endif</td>
                               
                                <td class="white-space-nowrap">
                                    <a class="btn btn-sm btn-info" href="">
                                        Order Details
                                    </a>
                                    @if($r->status == 1 && $r->v_status == 0  ){{--&& currentUser() == 'accountant'--}}
                                    <a class="btn btn-sm btn-success" href="{{route('autodebitvoucher.create',['id' => encryptor('encrypt',$r->id),'op' => 'Requisiton'])}}">
                                        <i class="bi bi-pencil-square"></i>Post Voucher
                                    </a>
                                    @endif
                                    <a class="btn btn-sm btn-warning" href="{{route('requisition.edit',encryptor('encrypt',$r->id))}}">
                                        Edit
                                    </a>
                                    {{-- <a class="btn btn-sm btn-primary" href="{{route('requisition-detl.create',['id' => encryptor('encrypt',$r->id)])}}">
                                        Add Amount
                                    </a> --}}
                                    @if($r->status ==0 ){{--&& currentUser() == 'superadmin'--}}
                                    <form id="approve-form" action="{{route('approve_toggle',encryptor('encrypt',$r->id))}}" style="display: inline;" method="post">
                                        @csrf
                                        @method('PUT')
                                        <a href="javascript:void(0)" data-status="{{$r->status}}" data-title="{{$r->title}}" class="approve btn btn-success btn-sm" data-toggle="tooltip" title="Approve">{{__('Approved') }}</a>
                                    </form>
                                    @endif
                                    @if($r->status ==1 && $r->v_status == 0)
                                    <form id="approve-form" action="{{route('approve_toggle',encryptor('encrypt',$r->id))}}" style="display: inline;" method="post">
                                        @csrf
                                        @method('PUT')
                                        <a href="javascript:void(0)" data-status="{{$r->status}}" data-title="{{$r->title}}" class="approve btn btn-warning btn-sm" data-toggle="tooltip" title="UnApprove">{{__('UnApproved') }}</a>
                                    </form>
                                    @endif
                                    <a class="btn btn-sm btn-danger" href=""><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Requistion Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $requisitions->links() }}
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
