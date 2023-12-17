@extends('layout.app')

@section('pageTitle','Product Type List')
@section('pageSubTitle','Product Type List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('product-type.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
{{--                                <th scope="col">{{__('Status')}}</th>--}}
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pro_types as $pt)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$pt->product_type_name}}</td>
{{--                                <td>@if($c->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>--}}
                                <td class="white-space-nowrap">
                                    <a href="{{route('product-type.edit',encryptor('encrypt',$pt->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$pt->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$pt->id}}" action="{{route('category.destroy',encryptor('encrypt',$pt->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Product Type Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $pro_types->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection
