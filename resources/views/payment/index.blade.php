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