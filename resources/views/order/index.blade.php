@extends('layout.app')

@section('pageTitle','Order List')
@section('pageSubTitle','Order List')

@section('content')

    <!-- Bordered table start -->
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <!-- table bordered -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <a class="btn btn-sm btn-primary float-end" href="{{route('order.create')}}"><i
                                    class="bi bi-pencil-square"></i></a>
                            <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Order No')}}</th>
                                <th scope="col">{{__('Company')}}</th>
                                <th scope="col">{{__('Client')}}</th>
                                <th scope="col">{{__('Vessel')}}</th>
                                <th scope="col">{{__('Invoice')}}</th>
                                <th scope="col">{{__('Receive')}}</th>
                                <th scope="col">{{__('Due')}}</th>
                                <th scope="col">{{__('Posted On')}}</th>
                                <th scope="col">{{__('Upload')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $or)
                                <tr>
                                    <td>{{ ++$loop->index }}</td>
                                    <td>{{$or->id}}</td>
                                    <td>{{$or->company?->company_name}}</td>
                                    <td>{{$or->client?->client_name}}</td>
                                    <td>{{$or->vessel?->vessel_name}}</td>
                                    <td>{{$or->amount}}</td>
                                    <td>{{$or->payments->sum('amount')}}</td>
                                    <td>{{$or->amount-$or->payments->sum('amount')}}</td>
                                    <td>{{$or->posted_on}}</td>
                                    <td>
                                        <a href="{{route('service-report.create',['id' => $or->id])}}" class="m-1 btn btn-sm btn-success" title="Service report">S/R</a>
                                        <a href="{{route('delivery-report.create',['id' => $or->id])}}" class="m-1 btn btn-sm btn-success">D/R</a>
                                        <a href="{{route('invoice-report.create',['id' => $or->id])}}" class="m-1 btn btn-sm btn-success">I/R</a>
                                        <a href="{{route('work-done-report.create',['id' => $or->id])}}" class="m-1 btn btn-sm btn-success">Wkd/R</a>
                                    </td>
                                    <td>
                                        <a href="{{route('order.edit',encryptor('encrypt',$or->id))}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{route('order.show',encryptor('encrypt',$or->id))}}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <!-- <a data-order-id="{{ $or->id }}" data-client="{{ $or->client?->client_name }}"
                                           href="#" data-bs-toggle="modal" data-bs-target="#paymentModal"
                                           class="ms-2 d-inline-block btn btn-primary btn-sm" title="Payment">
                                            Payment</a> -->

                                        <!-- <a href="javascript:void()" onclick="$('#form{{$or->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                        <form id="form{{$or->id}}"
                                              action="{{route('order.destroy',encryptor('encrypt',$or->id))}}"
                                              method="post">
                                            @csrf
                                            @method('delete')

                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="4" class="text-center">No Order Found</th>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="pt-2">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Bordered table end -->

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form class="form" method="post" action="{{route('payment.store')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" id="order_id">
                    <div class="modal-header text-center">
                        <h4 class="modal-title" id="addNoteModalLabel"></h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <h5 class="text-primary text-center">Payment For:-<span id="client"></span></h5>
                    <div class="modal-body" id="orderData">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#paymentModal').on('show.bs.modal', function (event) {
            $('#paymentData').empty();
            var button = $(event.relatedTarget);
            var order_id = button.data('order-id');
            var client = button.data('client');
            var modal = $(this);
            modal.find('#order_id').val(order_id);
            modal.find('#client').text(client);

            $.ajax({
                url: "{{route('payment_by_order')}}",
                method: 'GET',
                dataType: 'json',
                data: {
                    order_id: order_id
                },
                success: function (res) {
                    console.log(res.data);
                    $('#orderData').empty();
                    $('#orderData').append(res.data);
                },
                error: function (e) {
                    console.log(e);
                }
            });

        });
    </script>
@endpush
