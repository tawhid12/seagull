@extends('layout.app')

@section('pageTitle','Account Master Sub List')
@section('pageSubTitle','Account Master Sub List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                       
                            <a class="btn btn-sm btn-primary float-end" href="{{route('accountMasterSub.create')}}">Add Master Sub</a>

                       

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accountMasterSub as $ams)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$ams->fcoa}}</td>
                                <td>{{$ams->fcoa_code}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('accountMasterSub.edit',encryptor('encrypt',$ams->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$ams->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$ams->id}}" action="{{route('accountMasterSub.destroy',encryptor('encrypt',$ams->id))}}" method="post">
                                        @csrf
                                        @method('delete')

                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="4" class="text-center">No Master Sub Found</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pt-2">
                        {{ $accountMasterSub->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection