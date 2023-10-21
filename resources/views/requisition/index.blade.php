@extends('layout.app')

@section('pageTitle','Requsition List')
@section('pageSubTitle','Requsition List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <div class="d-flex justify-content-end mb-3">
                            <a class="btn btn-sm btn-primary me-3" href="{{route('requisition.create')}}">Product Requisition</a>
                            <a class="btn btn-sm btn-primary" href="{{route('otherRequisition.create')}}">Other Requisition</a>
                        </div>

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requisitions as $r)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$r->req_slip_no}}</td>
                                <td>@if($r->status == 1) {{__('Approved') }} @else {{__('Un Approved') }} @endif</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('requisition.edit',encryptor('encrypt',$r->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$r->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$r->id}}" action="{{route('product.destroy',encryptor('encrypt',$r->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
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