@extends('layout.app')

@section('pageTitle', 'Add Requisition Amount')
@section('pageSubTitle', 'Add Requisition Amount')

@section('content')

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            {{-- <form class="form" method="post" enctype="multipart/form-data"
                                action="{{ route('requisition-detl.store') }}">
                                @csrf
                                <input type="hidden" name="requisition_id" value="{{ request()->get('id') }}"> --}}
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="title">Requistion Title</label>
                                                <input type="text" id="title" class="form-control"
                                                    placeholder="Requisition Title" name="title"
                                                    value="{{ $r->title }}" readonly>
                                            </div>
                                            @if ($errors->has('title'))
                                                <span class="text-danger"> {{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="tax">Select Order</label>
                                                <select name="order_id" class="form-control" readonly>
                                                    <option value="">Select</option>
                                                    @forelse($orders as $or)
                                                        <option value="{{ $or->id }}"
                                                            @if ($or->id == $r->order_id) selected @endif>
                                                            {{ $or->order_subject }}
                                                        </option>
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
                                                <label for="postingDate">Requistion Date</label>
                                                <input type="date" id="postingDate" class="form-control"
                                                    name="postingDate" value="{{ $r->postingDate }}" readonly>
                                            </div>
                                            @if ($errors->has('postingDate'))
                                                <span class="text-danger"> {{ $errors->first('postingDate') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Requisition Amount Histroy</h5>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>SL.</th>
                                                        <th>Posting Date.</th>
                                                        <th>Approve Amount</th>
                                                        <th>Posted By</th>
                                                        <th>Description</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($r->requisition_detl as $rd)
                                                        <tr>
                                                            <td>{{ ++$loop->index }}</td>
                                                            <td>{{ date('d M Y', strtotime($rd->postingDate)) }}</td>
                                                            <td>{{ $rd->approve_amount }}</td>
                                                            <td>{{ $rd->user?->name }}</td>
                                                            <td>{{ $rd->des }}</td>
                                                            @if ($r->table_name && $r->table_id && $r->account_code)
                                                                @if ($rd->status == 2)
                                                                    <td>
                                                                        <form id="update-form-{{ $r->id }}"
                                                                            action="{{ route('requisition-detl.update', $r->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="hidden" name="approve" value="1">
                                                                        </form>
                                                                        <a href="#" class="btn btn-sm btn-warning"
                                                                            onclick="confirmUpdate({{ $r->id }})">Approve</a>
                                                                    </td>
                                                                @elseif($rd->status == 1)
                                                                    <td><a href="{{ route('autodebitvoucher.create', ['id' => encryptor('encrypt', $rd->requisition_id)]) }}"
                                                                            class="btn btn-sm btn-primary">Voucher Posting
                                                                            Pending</a></td>
                                                                @else
                                                                    <td><button type="button"
                                                                            class="btn btn-sm btn-success">Voucher
                                                                            Posted</button></td>
                                                                @endif
                                                            @endif
                                                        </tr>
                                                    @empty
                                                        <td colspan="4">No Data Found</td>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        @if ($r->order_amount - $r->requisition_detl_sum_approve_amount > 0)
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="title">Requisition Amount</label>
                                                    <input type="text" id="title" class="form-control"
                                                        placeholder="Approve Amount" name="approve_amount" readonly
                                                        value="{{ $r->order_amount }}" readonly>
                                                </div>
                                                @if ($errors->has('approve_amount'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('approve_amount') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="postingDate">Posting Date</label>
                                                    <input type="date" id="postingDate" class="form-control"
                                                        name="postingDate">
                                                </div>
                                                @if ($errors->has('postingDate'))
                                                    <span class="text-danger"> {{ $errors->first('postingDate') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="title">Approve Amount (Remaining)</label>
                                                    <input type="text" id="title" class="form-control"
                                                        placeholder="Approve Amount" name="approve_amount"
                                                        value="{{ $r->order_amount - $r->requisition_detl_sum_approve_amount }}">
                                                </div>
                                                @if ($errors->has('approve_amount'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('approve_amount') }}</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="Category">Received Account</label>
                                                    <select  class="form-control form-select" name="credit">
                                                        @if($paymethod)
                                                            @foreach($paymethod as $d)
                                                                <option value="{{$d['table_name']}}~{{$d['id']}}~{{$d['head_name']}}-{{$d['head_code']}}">{{$d['head_name']}}-{{$d['head_code']}}</option>
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
                                                <button type="submit" class="btn btn-primary mb-1">Save</button>
                                            </div>
                                        @endif
                                    </div>
                            {{-- </form> --}}
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
    <!-- Add this in the head section of your HTML -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmUpdate(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('update-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
