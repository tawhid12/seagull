@extends('layout.app')

@section('pageTitle','Account Head Navigation')
@section('pageSubTitle','Account Head Navigation')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <!-- table bordered -->
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Master Head</th>
                                <th>Sub1 Head</th>
                                <th>Sub2 Head</th>
                                <th>Sub3 Head</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $master_head = DB::table('account_masters')->get();
                            @endphp
                            @foreach($master_head as $mh)
                            <tr>
                                <td>{{$mh->master_code}}-{{$mh->fcoa_master}}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                                @php $master_sub_head = DB::table('account_master_subs')->where('fcoa_master_id',$mh->master_id)->get();@endphp
                                @foreach($master_sub_head as $msh)
                                <tr>
                                    <td></td>
                                    <td>{{$msh->fcoa_code}}-{{$msh->fcoa}}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                    @php $master_sub_head_bkdn = DB::table('account_master_sub_bkdns')->where('fcoa_id',$msh->fcoa_id)->get();@endphp
                                    @foreach($master_sub_head_bkdn as $mshb)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{$mshb->bkdn_code}}-{{$mshb->fcoa_bkdn}}</td>
                                        <td></td>
                                    </tr>
                                        @php $master_sub_head_bkdn_sub = DB::table('account_master_sub_bkdn_subs')->where('fcoa_bkdn_id',$mshb->fcoa_bkdn_id)->get();@endphp
                                        @foreach($master_sub_head_bkdn_sub as $mshbs)
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$mshbs->sub_code}}-{{$mshbs->fcoa_bkdn_sub}}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection