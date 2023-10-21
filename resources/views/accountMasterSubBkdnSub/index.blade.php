@extends('layout.app')

@section('pageTitle','Account Master Sub Two List')
@section('pageSubTitle','Account Master Sub Two List')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                       
                            <a class="btn btn-sm btn-primary float-end" href="{{route('accountMasterSubBkdnSub.create')}}">Add Master Sub Two</a>

                       

                        <thead>
                            <tr>
                                <th scope="col">{{__('#SL')}}</th>
                                <th scope="col">{{__('Name')}}</th>
                                <th scope="col">{{__('Status')}}</th>
                                <th class="white-space-nowrap">{{__('ACTION')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accountMasterSubBkdnSub as $amsbs)
                            <tr>
                                <th scope="row">{{ ++$loop->index }}</th>
                                <td>{{$amsbs->fcoa_bkdn}}</td>
                                <td>{{$amsbs->fcoa_code}}</td>
                                <td class="white-space-nowrap">
                                    <a href="{{route('accountMasterSubBkdnSub.edit',encryptor('encrypt',$amsbs->id))}}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <!-- <a href="javascript:void()" onclick="$('#form{{$amsbs->id}}').submit()">
                                                <i class="bi bi-trash"></i>
                                            </a> -->
                                    <form id="form{{$amsbs->id}}" action="{{route('accountMasterSubBkdnSub.destroy',encryptor('encrypt',$amsbs->id))}}" method="post">
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
                        {{ $accountMasterSubBkdnSub->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection