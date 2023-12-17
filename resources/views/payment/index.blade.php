@extends('layout.app')

@section('pageTitle','Invoice List')
@section('pageSubTitle','Invoice List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('order.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Invoice No')}}</th>
                                <th scope="col">{{__('Company')}}</th>
                                <th scope="col">{{__('Client')}}</th>
                                <th scope="col">{{__('Vessel')}}</th>
                                <th scope="col">{{__('Invoice Amount')}}</th>
                                <th scope="col">{{__('Receive Amount')}}</th>
                                <th scope="col">{{__('Posted On')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $p)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$p->invoice?->invoice_no}}</td>
                                <td>{{$p->invoice?->company?->company_name}}</td>
                                <td>{{$p->invoice?->client?->client_name}}</td>
                                <td>{{$p->invoice?->vessel?->vessel_name}}</td>
                                <td>{{$p->invoice?->amount}}</td>
                                <td>{{$p->amount}}</td>
                                <td>{{$p->created_at}}</td>

                                <td class="white-space-nowrap">
                                    <a href="{{route('payment.edit',encryptor('encrypt',$p->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$p->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$p->id}}" action="{{route('payment.destroy',encryptor('encrypt',$p->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Payments Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection
@push('scripts')

@endpush
