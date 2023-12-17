@extends('layout.app')

@section('pageTitle','Bank List')
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
                        <a class="btn btn-sm btn-primary float-end" href="{{route('bank.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Company')}}</th>
                                <th scope="col">{{__('Bank Name')}}</th>
                                <th scope="col">{{__('Branch')}}</th>
                                <th scope="col">{{__('District')}}</th>
                                <th scope="col">{{__('Account Name')}}</th>
                                <th scope="col">{{__('Account No')}}</th>
                                <th scope="col">{{__('Swift Code')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banks as $b)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$b->company?->company_name}}</td>
                                <td>{{$b->bank_name}}</td>
                                <td>{{$b->branch}}</td>
                                <td>{{$b->district}}</td>
                                <td>{{$b->account_name}}</td>
                                <td>{{$b->account_no}}</td>
                                <td>{{$b->swift_code}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('bank.edit',encryptor('encrypt',$b->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$b->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$b->id}}" action="{{route('bank.destroy',encryptor('encrypt',$b->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Bank Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $banks->links() }}
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
