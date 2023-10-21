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
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="vessel_name" class="form-control" placeholder="Vessel Name" name="vessel_name">
                                    </div>
                                    @if($errors->has('vessel_name'))
                                    <span class="text-danger"> {{ $errors->first('vessel_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-12">
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