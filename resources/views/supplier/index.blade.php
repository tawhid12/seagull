@extends('layout.app')

@section('pageTitle','Supplier List')
@section('pageSubTitle','Supplier List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('supplier.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Phone')}}</th>
                                <th scope="col">{{__('Mobile')}}</th>
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Fax')}}</th>
                                <th scope="col">{{__('Web')}}</th>
                                <th scope="col">{{__('Contact Person Name')}}</th>
                                <th scope="col">{{__('Contact Person Phone')}}</th>
                                {{-- <th scope="col">{{__('Status')}}</th> --}}
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $s)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$s->supplier_name}}</td>
                                <td>{{$s->phone}}</td>
                                <td>{{$s->mobile}}</td>
                                <td>{{$s->email}}</td>
                                <td>{{$s->fax}}</td>
                                <td>{{$s->web}}</td>
                                <td>{{$s->contact_person_name}}</td>
                                <td>{{$s->contact_person_phone}}</td>
                                {{-- <td>@if($s->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td> --}}
                                <td class="white-space-nowrap">
                                    <a href="{{route('supplier.edit',encryptor('encrypt',$s->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$s->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$s->id}}" action="{{route('supplier.destroy',encryptor('encrypt',$s->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Suppliers Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection