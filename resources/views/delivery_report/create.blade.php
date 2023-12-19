@extends('layout.app')

@section('pageTitle','Upload Delivery Report')
@section('pageSubTitle','Upload Delivery Report')

@section('content')

<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('Order No')}}</th>
                                <th scope="col">{{__('Company')}}</th>
                                <th scope="col">{{__('Client')}}</th>
                                <th scope="col">{{__('Vessel')}}</th>
                                <th scope="col">{{__('Invoice Amount')}}</th>
                                <th scope="col">{{__('Receive Amount')}}</th>
                                <th scope="col">{{__('Due Amount')}}</th>
                                <th scope="col">{{__('Posted On')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{$or->id}}</td>
                                <td>{{$or->company?->company_name}}</td>
                                <td>{{$or->client?->client_name}}</td>
                                <td>{{$or->vessel?->vessel_name}}</td>
                                <td>{{$or->amount}}</td>
                                <td>{{$or->payments->sum('amount')}}</td>
                                <td>{{$or->amount-$or->payments->sum('amount')}}</td>
                                <td>{{$or->posted_on}}</td>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-center">
                                    <h5>Upload Delivery Report</h5>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-center">
                                    <form class="form" method="post" enctype="multipart/form-data" action="{{route('delivery-report.store')}}">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{request()->get('id')}}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="file" class="form-control" name="delivery_report">
                                                </div>
                                                @if($errors->has('delivery_report'))
                                                <span class="text-danger"> {{ $errors->first('delivery_report') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-start">
                                                <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </th>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection
@push('scripts')
<script>

</script>
@endpush