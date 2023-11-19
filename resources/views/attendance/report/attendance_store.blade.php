@extends('layout.app')
@section('pageTitle','Add Attendance')
@section('pageSubTitle','Add Attendance')
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
		font-size: 13px;
		color: #000
	}

	p strong {
		margin-right: 10px;
	}

	body {
		font-size: 12pt;
	}
	.table.table-sm tr td, .table.table-sm tr th{
		padding: 0.5rem;
	}
</style>

@endpush
@section('content')
<!-- Bordered table start -->
<section class="section">
	<div class="row d-flex justify-content-end" id="table-bordered">
		<div class="col-sm-4 d-flex justify-content-end">
			<input type="text" id="postingDate" class="form-control" placeholder="dd/mm/yyyy" required>
			<button type="submit" class="batch-attn-btn btn btn-sm btn-primary ms-2"><i class="bi bi-search"></i></button>
			<button type="submit" class="reset-btn btn btn-sm btn btn-warning ms-2"><i class="bi bi-arrow-counterclockwise"></i></button>
		</div>
		<div class="col-md-12 selected-area" id="data">
		</div>
	</div>
</section> <!-- end row -->
@endsection
@push('scripts')

<script>
	$(document).ready(function() {
		$('.batch-attn-btn').on('click', function() {
			var postingDate = $('#postingDate').val();
			$.ajax({
				url: "{{route('datehwiseStudentAttnAdd')}}",
				method: 'GET',
				dataType: 'json',
				data: {
					postingDate: postingDate,
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
		$("#postingDate").daterangepicker({
			singleDatePicker: true,
			startDate: new Date(),
			showDropdowns: true,
			autoUpdateInput: true,
			format: 'dd/mm/yyyy',
		}).on('changeDate', function(e) {
			var date = moment(e.date).format('YYYY/MM/DD');
			$(this).val(date);
		});
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