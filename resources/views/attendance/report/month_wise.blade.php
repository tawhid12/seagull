@extends('layout.app')
@section('title', 'Month Wise Attendance Report')
@push('styles')
<style>
	.table-sm td,
	.table-sm th {
		padding: 0.1rem;
	}

	table,
	tbody,
	tr,
	th,
	td {
		font-size: 0.9em;
	}

	h4 {
		font-size: 18px;
		color: #000
	}

	p,
	p strong,
	table,
	table td,
	table th {
		color: #000;
		font-size: 12px;
	}


	p strong {
		margin-right: 10px;
	}

	body {
		font-size: 12pt;
	}

	.table.table-sm tr td,
	.table.table-sm tr th {
		padding: 0.25rem;
	}

	table td span {
		font-size: 14px;
	}

	td .action-btn {
		font-size: 11px;
	}
</style>

@endpush
@section('content')
<section class="section">
	<form action="{{route('attendance.index')}}">
		@csrf

		<div class="row my-3">
			<div class="col-md-4">
				<label>Select Date Range</label>
				<div class="input-group">
					<input type="text" id="date_range" name="date_range" class="form-control" placeholder="dd/mm/yyyy" autocomplete="off">
					<span class="input-group-text"><i class="bi bi-calendar"></i></span>
				</div>
			</div>
			<div class="col-sm-3">
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
			<div class="col-sm-3">
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


			<div class="col-md-12 d-flex justify-content-end">
				<button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
				<a href="{{route('attendance.index')}}" class="ml-2 btn-sm reset-btn btn btn-warning"><i class="bi bi-arrow-counterclockwise"></i></a>
			</div>
		</div>

	</form>
	<div class="row">
		<div class="card">
			<div class="col-md-12">
				<h4 class="m-0 p-0 text-center" style="font-size:18px;font-weight:700;color:#25396f;">Seagull Marine Engineer's PVT Ltd.</h4>
				<p class="m-0 p-0 text-center" style="font-size:16px;"><strong style="color:#25396f">Employee Attendance Report</strong></p>
				<div class="table-responsive">
					<table class="table text-center table-bordered table-sm table-hover" style="width:100%;border:1px solid #000;color:#000;">
						<tbody>
							<tr>
								<th class="align-bottom" rowspan="2" style="border:1px solid #000;;color:#000;"><strong>SL.</strong></th>
								<!-- <th class="align-middle" rowspan="2" style="border:1px solid #000;;color:#000;"><strong>Employee ID</strong></th> -->
								<th width="120px" class="align-bottom" rowspan="2" style="border:1px solid #000;;color:#000;"><strong>Name</strong></th>
								<!-- <th class="align-middle" rowspan="2" style="border:1px solid #000;;color:#000;"><strong>Designation</strong></th> -->
								<th class="align-middle" style="border:1px solid #000;;color:#000;font-size:16px;" colspan={{ $postingDate->count() }}><strong>Attendance Details</strong></th>
								<th style="border:1px solid #000;;color:#000;width:5px;"><strong>Total Working Days</strong></th>
							</tr>
							<tr>
								@forelse($postingDate as $pdate)
								<th style="border:1px solid #000;;color:#000;text-align:center">
									{{\Carbon\Carbon::createFromTimestamp(strtotime($pdate->postingDate))->format('d')}}
									<table class="table table-bordered" style="width:100%;border:1px solid #000;color:#000;">
										<tr>
											<td>
												<form action="{{ route('attendance.update',$pdate->postingDate) }}" method="post">
													@csrf
													@method('PUT')
													<input type="hidden" name="type" value="1">
													<button type="submit" class="btn btn-sm action-btn text-primary"><i class="bi bi-pencil"></i></button>
												</form>
											</td>
											<td>
												<form action="{{route('attendance.edit',$pdate->postingDate)}}">
													@csrf
													<input type="hidden" name="postingDate" value="{{$pdate->postingDate}}">
													<button type="submit" class="btn btn-sm action-btn text-warning"><i class="bi bi-pencil"></i></button>
												</form>
											</td>
											<td>
												<form action="{{route('attendance.destroy',$pdate->postingDate)}}" method="post">
													@csrf
													@method('DELETE')
													<input type="hidden" name="postingDate" value="{{$pdate->postingDate}}">
													<button type="submit" class="btn btn-sm action-btn text-danger"><i class="bi bi-trash3"></i></button>
												</form>
											</td>
										</tr>
									</table>
								</th>
								@empty
								@endforelse
								<td>{{ $postingDate->count() }}</td>
							</tr>
							@forelse($employees as $e)
							<tr>
								<td>{{ ++$loop->index }}</td>
								<td>{{$e->employee_name}}</td>
								@forelse ($postingDate as $pdate)
								@php
								$attendance_data = \App\Models\Attendance::where('employee_id', $e->id)->where('postingDate', '=', \Carbon\Carbon::createFromTimestamp(strtotime($pdate->postingDate))->format('Y-m-d'))->first();
								@endphp
								@if ($attendance_data !== null && $attendance_data->isPresent == 1)
								<td><span class="text-success"><i class="bi bi-check-square-fill"></i></span></td>
								@else
									@if($attendance_data != null)
									@if($attendance_data->isPresent > 1)
									<td><span class="bg-warning text-white p-1">L</td>
									@else
									<td><span class="text-danger"><i class="bi bi-x-square-fill"></i></td>
									@endif
									@else
									<td><span class="text-danger"><i class="bi bi-x-square-fill"></i></td>
									@endif
								@endif
								@empty
								@endforelse
								<td>{{\App\Models\Attendance::where('employee_id', $e->id)->where('isPresent', '=', 1)->count()}}</td>
							</tr>
							@empty
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>

</section>

@endsection
@push('scripts')

<script>
	$(document).ready(function() {
		$('.batch-attn-btn').on('click', function() {
			var batch_id = $('#batch_id option:selected').val();
			/*var start_date = $('#start_date').val();
			var class_count = $('#class_count').val();*/
			$.ajax({
				url: "",
				method: 'GET',
				dataType: 'json',
				data: {
					batch_id: batch_id,
					/*start_date: start_date,
					class_count: class_count,*/ //Loop Count
				},
				success: function(res) {
					console.log(res.data);
					$('#data').empty();
					$('#data').append(res.data);
				},
				error: function(e) {
					console.log(e);
				}
			});
		});
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







	})

	function printPageArea() {
		var table = document.getElementById("data").outerHTML;
		var newWin = window.open('', 'Print-Window');
		newWin.document.open();
		newWin.document.write('<html><style type="text/css" media="print"> button { display:none;} p strong{font-size:11px;margin-right:8px;color:#000;} @page { font-size:11px; }.cell{width:100px;} table{font-size:11px;border-collapse: collapse;} table, td, th {border: 1px solid #000;} h4,p{text-align:center;padding:0;margin:0;color:#000}  table{margin-top:10px;}</style><body onload="window.print()">' + table + '</html>');
		newWin.document.close();
		setTimeout(function() {
			//newWin.close();
		}, 10);
	}
</script>
@if(Session::has('response'))
<script>
	Command: toastr["{{Session::get('response')['class']}}"]("{{Session::get('response')['message']}}")
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"newestOnTop": false,
		"progressBar": false,
		"positionClass": "toast-top-right",
		"preventDuplicates": false,
		"onclick": null,
		"showDuration": "300",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
</script>
@endif

@endpush