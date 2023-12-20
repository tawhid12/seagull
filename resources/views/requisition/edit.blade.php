@extends('layout.app')

@section('pageTitle', 'Edit Requisition')
@section('pageSubTitle', 'Edit Requisition')

@section('content')

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data"
                                action="{{ route('requisition.edit', encryptor('encrypt', $r->id)) }}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="uptoken" value="{{ encryptor('encrypt', $r->id) }}">
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="title">Requistion Title</label>
                                            <input type="text" id="title" class="form-control"
                                                placeholder="Requisition Title" name="title">
                                        </div>
                                        @if ($errors->has('title'))
                                            <span class="text-danger"> {{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="tax">Select Order</label>
                                            <select name="order_id" class="form-control">
                                                <option value="">Select</option>
                                                @forelse($orders as $or)
                                                    <option value="{{ $or->id }}">{{ $or->order_subject }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @if ($errors->has('order_id'))
                                            <span class="text-danger"> {{ $errors->first('order_id') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="req_slip_no">Requistion Slip No</label>
                                            <input type="text" id="req_slip_no" class="form-control" readonly
                                                placeholder="Requisition Slip No">
                                        </div>
                                        @if ($errors->has('req_slip_no'))
                                            <span class="text-danger"> {{ $errors->first('req_slip_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="postingDate">Requistion Date</label>
                                            <input type="date" id="postingDate" class="form-control" name="postingDate">
                                        </div>
                                        @if ($errors->has('postingDate'))
                                            <span class="text-danger"> {{ $errors->first('postingDate') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="Category">{{ __('Received Account') }}</label>
                                            <select class="form-control form-select" name="credit">
                                                @if ($paymethod)
                                                    @foreach ($paymethod as $d)
                                                        <option
                                                            value="{{ $d['table_name'] }}~{{ $d['id'] }}~{{ $d['head_name'] }}-{{ $d['head_code'] }}">
                                                            {{ $d['head_name'] }}-{{ $d['head_code'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="postingDate">Description</label>
                                            <textarea rows="5" id="des" class="form-control" name="des"></textarea>
                                        </div>
                                        @if ($errors->has('des'))
                                            <span class="text-danger"> {{ $errors->first('des') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mb-1">Update</button>
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
