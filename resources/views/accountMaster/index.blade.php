@extends('layout.app')

@section('pageTitle','Account Master List')
@section('pageSubTitle','Account Master List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                       
                            <a class="btn btn-sm btn-primary float-end" href="{{route('accountMaster.create')}}">Add Master Account</a>

                       

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accountMaster as $am)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$am->fcoa_master}}</td>
                                <td>{{$am->master_code}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('accountMaster.edit',encryptor('encrypt',$am->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$am->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$am->id}}" action="{{route('accountMaster.destroy',encryptor('encrypt',$am->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Master Account Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $accountMaster->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection