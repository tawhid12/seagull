@extends('layout.app')
@section('pageTitle','Permission List')
@section('pageSubTitle','All Permission')
@section('content')
<!-- Bordered table start -->
<div class="col-12">
    <div class="card">
        <!-- table bordered -->
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <a class="btn btn-sm btn-primary float-end my-2" href="{{route('permission.create')}}"><i class="bi bi-plus-square"></i> Add New</a>
                <thead>
                    <tr>
                        <th scope="col" width="20px">{{__('#SL')}}</th>
                        <th scope="col">{{__('Permission Name')}}</th>
                        <th class="white-space-nowrap" width="80px">{{__('ACTION')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $p)
                    <tr>
                        <td scope="row">{{ ++$loop->index }}</td>
                        <td>{{$p->name}}</td>
                        <td>
                            <a href="{{route('permission.edit',encryptor('encrypt',$p->id))}}">
                                <i class="bi bi-pencil"></i>
                            </a>
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
                {{$permissions->links()}}
            </div>
        </div>
    </div>
</div>
@endsection