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
                <div class="row my-2">

                    <div class="col-md-6">
                        <a class="btn btn-sm btn-primary me-3" href="{{route('requisition.create')}}">Product Requisition</a>
                        <a class="btn btn-sm btn-primary" href="{{route('otherRequisition.create')}}">Other Requisition</a>

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
                </div>

                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="requisition table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Date')}}</th>
                                <th scope="col">{{__('Title')}}</th>
                                <th scope="col">{{__('Fund Requisition #')}}</th>
                                <th scope="col">{{__('Client Name')}}</th>
                                <th scope="col">{{__('Vessel Name')}}</th>
                                <th scope="col">{{__('Total Price')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requisitions as $r)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{date('d M Y',strtotime($r->postingDate))}}</td>
                                <td>{{$r->title}}</td>
                                <td>{{$r->id}}</td>
                                <td>{{$r->client?->client_name}}</td>
                                <td>{{$r->vessel?->vessel_name}}</td>
                                <td>{{$r->amount}}</td>
                                <td>@if($r->status == 1) {{__('Approved') }} @else {{__('UnApproved') }} @endif</td>
                                <td class="white-space-nowrap">
                                    @if($r->status == 1 && currentUser() == 'accountant')
                                    <a class="btn btn-sm btn-success" href="{{route('autodebitvoucher.create',['id' => encryptor('encrypt',$r->id)])}}">
                                        <i class="bi bi-pencil-square"></i>Create Voucher
                                    </a>
                                    @endif
                                    @if($r->v_status == 2 && currentUser() == 'superadmin')
                                    <form id="approve-form" action="{{route('requisition.update',encryptor('encrypt',$r->id))}}" style="display: inline;" method="post">
                                        @csrf
                                        @method('PUT')
                                        <a href="javascript:void(0)" data-status="{{$r->status}}" data-title="{{$r->title}}" class="approve btn @if($r->status == 1) btn-warning @else btn-success @endif btn-sm" data-toggle="tooltip" title="Approve">@if($r->status == 1) {{__('UnApproved') }} @else {{__('Approved') }} @endif</a>
                                    </form>
                                    @endif
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