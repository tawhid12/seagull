@extends('layout.app')

@section('pageTitle','Product Requisition List')
@section('pageSubTitle','Product Requisition List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('product-requisition.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Requisition Slip No')}}</th>
                                <th scope="col">{{__('Requisition Title')}}</th>
                                <th scope="col">{{__('Order Details')}}</th>
                                <th scope="col">{{__('Company')}}</th>
                                <th scope="col">{{__('Posting Date')}}</th>
                                <th scope="col">{{__('Description')}}</th>
{{--                                <th scope="col">{{__('Status')}}</th>--}}
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($product_requisitions as $pr)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$pr->req_slip_no}}</td>
                                <td>{{$pr->title}}</td>
                                <td>{{$pr->order_id}}</td>
                                <td>{{$pr->company_id}}</td>
                                <td>{{date('d M Y',strtotime($pr->postingDate))}}</td>
                                <td>{{$pr->des}}</td>
{{--                                <td>@if($c->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>--}}
                                <td class="white-space-nowrap">
                                    <a href="{{route('product-requisition.edit',encryptor('encrypt',$pr->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$pr->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$pr->id}}" action="{{route('product-requisition.destroy',encryptor('encrypt',$pr->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Product Requisition Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $product_requisitions->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection
