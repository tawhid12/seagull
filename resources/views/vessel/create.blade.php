@extends('layout.app')

@section('pageTitle','Create Vessel')
@section('pageSubTitle','Create Vessel')

@section('content')
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form" method="post" enctype="multipart/form-data" action="{{route('vessel.store', ['role' =>currentUser()])}}">
                            @csrf
                            <div class="row">
                                {{--<div class="col-md-3 col-12" id="company_data">
                                    <div class="form-group">
                                        <label for="tax">Select Company</label>
                                        <select name="company_id" class="form-control" required>
                                            <option value="">Select</option>
                                            @forelse($assigned_companies as $ac)
                                            <option value="{{$ac->id}}">{{$ac->company_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('company_id'))
                                    <span class="text-danger"> {{ $errors->first('company_id') }}</span>
                                    @endif
                                </div>--}}
                                <div class="col-md-3 col-12" id="company_data">
                                    <div class="form-group">
                                        <label for="tax">Select Client</label>
                                        <select name="client_id" class="form-control" required>
                                            <option value="">Select</option>
                                            @forelse($clients as $c)
                                            <option value="{{$c->id}}">{{$c->client_name}}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    @if($errors->has('client_id'))
                                    <span class="text-danger"> {{ $errors->first('client_id') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="vessel_name" class="form-control" placeholder="Vessel Name" name="vessel_name">
                                    </div>
                                    @if($errors->has('vessel_name'))
                                    <span class="text-danger"> {{ $errors->first('vessel_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="tax">Vessel Number</label>
                                        <input type="text" id="vessel_number" class="form-control" placeholder="Vessel Number" name="vessel_number">
                                    </div>
                                    @if($errors->has('vessel_number'))
                                    <span class="text-danger"> {{ $errors->first('vessel_number') }}</span>
                                    @endif
                                </div>

                                <div class="col-12 d-flex justify-content-end">
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
    $(document).ready(function() {
        /*$("select[name='company_id']").on('change', function() {
            var company_id = $(this).val();
            if (company_id) {
                var url = "{{ url('company/client/') }}/" + company_id;
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log(res.data);
                        $('#company_data').next('#client_id').remove();
                        $('#company_data').after(res.data);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            } else {

            }

        });*/

    });
</script>
@endpush