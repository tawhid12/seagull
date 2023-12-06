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
                        <a class="btn btn-sm btn-primary float-end" href="{{route('invoice.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Invoice No')}}</th>
                                <th scope="col">{{__('Company')}}</th>
                                <th scope="col">{{__('Client')}}</th>
                                <th scope="col">{{__('Vessel')}}</th>
                                <th scope="col">{{__('Invoice Amount')}}</th>
                                <th scope="col">{{__('Receive Amount')}}</th>
                                <th scope="col">{{__('Due Amount')}}</th>
                                <th scope="col">{{__('Posted On')}}</th>
                                <th>{{__('Receive')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $inv)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$inv->invoice_no}}</td>
                                <td>{{$inv->company?->company_name}}</td>
                                <td>{{$inv->client?->client_name}}</td>
                                <td>{{$inv->vessel?->vessel_name}}</td>
                                <td>{{$inv->amount}}</td>
                                <td>{{$inv->payments->sum('amount')}}</td>
                                <td>{{$inv->amount-$inv->payments->sum('amount')}}</td>
                                <td>{{$inv->posted_on}}</td>
                                <td>
                                    <a data-invoice-id="{{ $inv->id }}" data-client="{{ $inv->client?->client_name }}" href="#" data-bs-toggle="modal" data-bs-target="#paymentModal" class="ms-2 d-inline-block btn btn-primary btn-sm" title="Reserve">Make Payment</a>
                                </td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('invoice.edit',encryptor('encrypt',$inv->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$inv->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$inv->id}}" action="{{route('invoice.destroy',encryptor('encrypt',$inv->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Invoice Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $invoices->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form class="form" method="post" action="{{route('payment.store')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="invoice_id" id="invoice_id">
                <div class="modal-header text-center">
                    <h4 class="modal-title" id="addNoteModalLabel"></h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h5 class="text-primary text-center">Payment For:-<span id="client"></span></h5>
                <div class="modal-body" id="invData">
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
    $('#paymentModal').on('show.bs.modal', function(event) {
        $('#paymentData').empty();
        var button = $(event.relatedTarget);
        var invoice_id = button.data('invoice-id');
        var client = button.data('client');
        var modal = $(this);
        modal.find('#invoice_id').val(invoice_id);
        modal.find('#client').text(client);

        $.ajax({
            url: "{{route('payment_by_invoice')}}",
            method: 'GET',
            dataType: 'json',
            data:{
                invoice_id:invoice_id
            },
            success: function(res) {
                console.log(res.data);
                $('#invData').append(res.data);
            },
            error: function(e) {
                console.log(e);
            }
        });

    });
</script>
@endpush