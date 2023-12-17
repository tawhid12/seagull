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
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('leave.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Employees</label>
                                        <select name="employee_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($employees as $e)
                                            <option value="{{$e->id}}">{{$e->employee_name}}</option>
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
                                            <option value="{{$lt->id}}">{{$lt->leave_type}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('leave_type_id '))
                                    <span class="text-danger"> {{ $errors->first('leave_type_id ') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="leave_date">Leave Date</label>
                                        <div class="input-group">
                                            <input type="text" id="date_range" name="date_range" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                        </div>
                                    </div>
                                    @if($errors->has('leave_date'))
                                    <span class="text-danger"> {{ $errors->first('leave_date') }}</span>
                                    @endif
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="note ">Remarks</label>
                                        <textarea name="note" class="form-control" rows="6"></textarea>
                                    </div>
                                    @if($errors->has('leave_type_id '))
                                    <span class="text-danger"> {{ $errors->first('leave_type_id ') }}</span>
                                    @endif
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
        //startDate: new Date(),
        showDropdowns: true,
        autoUpdateInput: true,
        format: 'dd/mm/yyyy',
    }).on('changeDate', function(e) {
        var date = moment(e.date).format('YYYY/MM/DD');
        $(this).val(date);
    });
    // Set the input value to an empty string after initialization
    $("input[name='date_range']").val('');
</script>

@endpush