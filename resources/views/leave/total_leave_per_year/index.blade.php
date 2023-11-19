@extends('layout.app')

@section('pageTitle','Total Leave Per Year')
@section('pageSubTitle','total Leave Per Year')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('total-leave-per-year.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Type')}}</th>
                                <th scope="col">{{__('Year')}}</th>
                                <th scope="col">{{__('Total Leave')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($total_leave_per_year as $tlpy)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$tlpy->leave_type->leave_type}}</td>
                                <td>{{$tlpy->leave_year}}</td>
                                <td>{{$tlpy->total_leave_days}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('leave-type.edit',encryptor('encrypt',$tlpy->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$tlpy->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$tlpy->id}}" action="{{route('leave-type.destroy',encryptor('encrypt',$tlpy->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Leave Type Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $total_leave_per_year->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection