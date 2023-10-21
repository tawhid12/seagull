@extends('layout.app')

@section('pageTitle','Company List')
@section('pageSubTitle','Company List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <a class="btn btn-sm btn-primary float-end" href="{{route('company.create')}}"><i class="bi bi-pencil-square"></i></a>
                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($company as $c)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$c->company_name}}</td>
                                <td>@if($c->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('company.edit',encryptor('encrypt',$c->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$c->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$c->id}}" action="{{route('company.destroy',encryptor('encrypt',$c->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Company Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $company->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection