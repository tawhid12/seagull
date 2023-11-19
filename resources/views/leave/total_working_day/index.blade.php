@extends('layout.app')

@section('pageTitle','Total Working Day')
@section('pageSubTitle','Total Working Day List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('total-working-day.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Total Working Day')}}</th>
                                <th scope="col">{{__('Month')}}</th>
                                <th scope="col">{{__('Year')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($total_working_day as $twd)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$twd->total_working_day}}</td>
                                <td>{{ \Carbon\Carbon::create()->month($twd->month)->format('F') }}</td>
                                <td>{{$twd->year}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('total-working-day.edit',encryptor('encrypt',$twd->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$twd->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$twd->id}}" action="{{route('total-working-day.destroy',encryptor('encrypt',$twd->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Data Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $total_working_day->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection