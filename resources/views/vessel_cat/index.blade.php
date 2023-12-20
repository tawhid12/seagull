@extends('layout.app')

@section('pageTitle','Vessel Categories List')
@section('pageSubTitle','Vessel Categories List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('vessel-categories.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
{{--                                <th scope="col">{{__('Status')}}</th>--}}
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vessel_cats as $vc)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$vc->category_name}}</td>
{{--                                <td>@if($$vc->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>--}}
                                <td class="white-space-nowrap">
                                    <a href="{{route('vessel-categories.edit',encryptor('encrypt',$vc->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$vc->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$vc->id}}" action="{{route('vessel-categories.destroy',encryptor('encrypt',$vc->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Vessel Category Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $vessel_cats->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection
