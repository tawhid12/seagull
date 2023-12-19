@extends('layout.app')

@section('pageTitle', 'Order Detail')
@section('pageSubTitle', 'Order Details')

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
                                    <th scope="col">{{ __('Order No') }}</th>
                                    <th scope="col">{{ __('Company') }}</th>
                                    <th scope="col">{{ __('Client') }}</th>
                                    <th scope="col">{{ __('Vessel') }}</th>
                                    <th scope="col">{{ __('Invoice Amount') }}</th>
                                    <th scope="col">{{ __('Receive Amount') }}</th>
                                    <th scope="col">{{ __('Due Amount') }}</th>
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
                            </tbody>
                        </table>
                        <div class="row">
                            <h5 class="text-center my-2">Service Report (Attachments)</h5>
                            @forelse ($or->service_report as $sr)
                                <div class="col-md-3"><iframe src="{{ asset($sr->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                        <div class="row">
                            <h5 class="text-center my-2">Delivery Report (Attachments)</h5>
                            @forelse ($or->delivery_report as $dr)
                                <div class="col-md-3"><iframe src="{{ asset($dr->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                        <div class="row">
                            <h5 class="text-center my-2">Invoice Report (Attachments)</h5>
                            @forelse ($or->invoice_report as $ir)
                                <div class="col-md-3"><iframe src="{{ asset($ir->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                        <div class="row">
                            <h5 class="text-center my-2">Work Done (Certificates)</h5>
                            @forelse ($or->work_done_report as $sr)
                                <div class="col-md-3"><iframe src="{{ asset($sr->file_name) }}" width="100%" height="300px"></iframe></div>
                            @empty
                                <div class="col-md-12">No File Uploaded</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Bordered table end -->


@endsection
@push('scripts')
    <script></script>
@endpush
