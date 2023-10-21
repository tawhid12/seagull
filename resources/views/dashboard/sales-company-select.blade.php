@extends('layout.app-country')
@section('pageTitle',trans('Salesexecutive | Company Select'))
@section('pageSubTitle',trans('Company Select'))

@section('content')
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($company as $c)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td class="white-space-nowrap">
                                    <a href="{{route('secretLogin',$c->id)}}" class="btn btn-sm btn-success">Login As {{$c->company_name}}</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Company Assigned</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')

@endpush