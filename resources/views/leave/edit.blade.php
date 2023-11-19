@extends('layout.app')

@section('pageTitle','Add Leave')
@section('pageSubTitle','Add Leave')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('leave.update',encryptor('encrypt',$l->id))}}">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$l->id)}}">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Employees</label>
                                        <select name="employee_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($employees as $e)
                                            <option value="{{$e->id}}" @if($l->employee_id == $e->id) selected @endif>{{$e->employee_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('employee_id'))
                                    <span class="text-danger"> {{ $errors->first('employee_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="leave_type_id ">Select Leave Type</label>
                                        <select name="leave_type_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($leave_types as $lt)
                                            <option value="{{$lt->id}}" @if($l->leave_type_id == $lt->id) selected @endif>{{$lt->leave_type}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('leave_type_id '))
                                    <span class="text-danger"> {{ $errors->first('leave_type_id ') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="leave_date">Leave Date</label>
                                        <div class="input-group">
                                            <input type="text" id="date_range" name="date_range" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        </div>
                                    </div>
                                    @if($errors->has('date_range'))
                                    <span class="text-danger">{{ $errors->first('date_range') }}</span>
                                    @elseif($errors->has('from') || $errors->has('to'))
                                    <span class="text-danger">{{ $errors->first('from') ?: $errors->first('to') }}</span>
                                    @endif

                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="status ">Select Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">Approved</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end my-2">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- // Basic multiple Column Form section end -->
</div>
@endsection
@push('scripts')

<script>
    $("input[name='date_range']").daterangepicker({
        singleDatePicker: false,
        startDate: moment('{{$l->from_date}}', 'YYYY-MM-DD'),
        endDate: moment('{{$l->to_date}}', 'YYYY-MM-DD'),
        showDropdowns: true,
        autoUpdateInput: true,
        format: 'DD/MM/YYYY',
    }).on('apply.daterangepicker', function(e, picker) {
        var startDate = picker.startDate.format('YYYY/MM/DD');
        var endDate = picker.endDate.format('YYYY/MM/DD');
        $(this).val(startDate + ' - ' + endDate);
    });
</script>

@endpush