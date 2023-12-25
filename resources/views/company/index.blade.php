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
                            <div class="d-flex justify-content-end my-2">
                                <a class="fs-4 btn btn-primary" href="{{route('company.create')}}"><i class="bi bi-plus"></i> Add</a>
                            </div>
                            <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Company Name')}}</th>
                                <th scope="col">{{__('Website')}}</th>
                                <!-- <th scope="col">{{__('Tax No')}}</th> -->
                                <!-- <th scope="col">{{__('Address')}}</th> -->
                                <th scope="col">{{__('City')}}</th>
                                <th scope="col">{{__('Country')}}</th>
                                <!-- <th scope="col">{{__('Zip')}}</th> -->
                                <th scope="col">{{__('Email')}}</th>
                                <th scope="col">{{__('Contact')}}</th>
                                <th scope="col">{{__('Bank Detail')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($company as $c)
                                <tr>
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{$c->company_name}}</td>
                                    <td>{{$c->website}}</td>
                                    <!-- <td>{{$c->tax_no}}</td> -->
                                    <!-- <td>{{$c->address}}</td> -->
                                    <td>{{$c->city}}</td>
                                    <td>{{$c->country}}</td>
                                    <!-- <td>{{$c->zip_code}}</td> -->
                                    <td>{{$c->email}}</td>
                                    <td>{{$c->contact_no}}</td>
                                    <td>
                                        @forelse($c->banks as $b)
                                            <p class="border-bottom">
                                                <strong>Bank Name: </strong>{{$b->bank_name}}<br><strong>Account Name: </strong>{{$b->account_name}}<br>
                                                <strong>Branch Name: </strong>{{$b->branch}}
                                            </p>
                                        @empty
                                        @endforelse
                                    </td>
                                    {{--                                <td>@if($c->status == 1) {{__('Active') }} @else {{__('Inactive') }} @endif</td>--}}
                                    <td class="white-space-nowrap">
                                        <a href="{{route('company.edit',encryptor('encrypt',$c->id))}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <!-- <a href="javascript:void()" onclick="$('#form{{$c->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                        <form id="form{{$c->id}}"
                                              action="{{route('company.destroy',encryptor('encrypt',$c->id))}}"
                                              method="post">
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
