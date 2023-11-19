@extends('layout.app')

@section('pageTitle','Salary Slip')
@section('pageSubTitle','Salary Slip')

@section('content')


<!-- Bordered table start -->
<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <form class="form" method="post" enctype="multipart/form-data" action="{{route('salary-slip.store')}}">
                    @csrf
                    <div class="row">
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="text" name="from_date" class="postingDate form-control" placeholder="dd/mm/yyyy" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="text" name="to_date" class="postingDate form-control" placeholder="dd/mm/yyyy" required>
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-2">
                            <div class="form-group">
                                <label for="year">From Day</label>
                                <select name="from" class="js-example-basic-single form-control me-3">
                                    <option></option>
                                    @php
                                    for($i=1;$i<=31;$i++){ @endphp <option value="{{$i}}" @if(request()->get('from') == $i) selected @endif>{{$i}}</option>
                                        @php
                                        }
                                        @endphp
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="year">To Day</label>
                                <select name="to" class="js-example-basic-single form-control me-3">
                                    <option></option>
                                    @php
                                    for($i=1;$i<=31;$i++){ @endphp <option value="{{$i}}" @if(request()->get('to') == $i) selected @endif>{{$i}}</option>
                                        @php
                                        }
                                        @endphp
                                </select>
                            </div>
                        </div> -->
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select name="month" class="js-example-basic-single form-control me-3">
                                    <option></option>
                                    @php
                                    $months = array("Jan", "Feb", "Mar", "Apr","May","June","July","August","September","October","November","December");
                                    for($i=0;$i<count($months);$i++){ $monthValue=$i + 1; @endphp <option value="{{$monthValue}}" @if(request()->get('month') == $monthValue) selected @endif>{{$months[$i]}}</option>
                                        @php
                                        }
                                        @endphp
                                </select>
                            </div>

                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select name="year" class="js-example-basic-single form-control me-3">
                                    <option></option>
                                    @php
                                    for($i=2023;$i<=2023;$i++){ @endphp <option value="{{$i}}" @if(request()->get('year') == $i) selected @endif>{{$i}}</option>
                                        @php
                                        }
                                        @endphp
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="Category">{{__('Received Account')}}</label>
                                <select class="form-control form-select" name="credit">
                                    @if($paymethod)
                                    @foreach($paymethod as $d)
                                    <option value="{{$d['table_name']}}~{{$d['id']}}~{{$d['head_name']}}-{{$d['head_code']}}">{{$d['head_name']}}-{{$d['head_code']}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-end my-2">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Generate Salary Slip</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<!-- Bordered table end -->


@endsection
@push('scripts')

<script>
    $(document).ready(function() {
        $(".postingDate").daterangepicker({
            singleDatePicker: true,
            startDate: new Date(),
            showDropdowns: true,
            autoUpdateInput: true,
            format: 'dd/mm/yyyy',
        }).on('changeDate', function(e) {
            var date = moment(e.date).format('YYYY/MM/DD');
            $(this).val(date);
        });
    });
</script>
@endpush