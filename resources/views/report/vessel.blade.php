@extends('layout.app')

@section('pageTitle', 'Vessel Wise Report')
@section('pageSubTitle', 'Report')

@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <h4 class="card-title text-center">{{ __('Vessel Wise Report') }}</h4>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="tax">Select Vessel</label>
                                        <select name="vessel_id" id="vessel_id" class="form-control">
                                            <option value="">Select</option>
                                            @forelse($vessels as $v)
                                                <option value="{{ $v->id }}">{{ $v->vessel_name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if ($errors->has('ship_id'))
                                        <span class="text-danger"> {{ $errors->first('ship_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="voyage_no">Voyage No</label>
                                        <input type="text" name="voyage_no" id="voyage_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3 pt-3">
                                    <button class="btn btn-primary btn-block" type="button"
                                        onclick="get_details_report()">Get Report</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="details">
            
                                    </div>
            
                                </div>
                            </div>
            
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function get_details_report() {
		//var month = $('#month').val();
		//var year = $('#year').val();
        //var company_id = $('#company_id option:selected').val();

        var vessel_id = $('#vessel_id option:selected').val();
        var voyage_no = $('#voyage_no').val();
		if (vessel_id) {
			$.ajax({
				url: "{{route('vessel_report.details')}}",
				data: {
					//'month': month,
					//'year': year,
                    //'company_id' : company_id,
                    'vessel_id': vessel_id,
                    'voyage_no': voyage_no,
				},
				dataType: 'json',
				success: function(data) {
                    console.log(data);
                    $('#details').html(data);
					result = '' + data['result'] + '';
					mainContent = '' + data['mainContent'] + '';

					if (result == 'success')
						$('#details').html(mainContent);

				},
				error: function(e) {
					console.log(e);
				}
			});
		} else {
			alert("Please select any Vessel Or Voyage");
			$('#year').focus();
		}
		return false; // keeps the page from not refreshing     
	}
    </script>
@endpush
