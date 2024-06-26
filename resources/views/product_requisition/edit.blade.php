@extends('layout.app')

@section('pageTitle','Create Product Requistion')
@section('pageSubTitle','Create Product Requistion')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/jquery-ui.css') }}">
    <style>
        .ui-widget {
            font-size: 1em;
        }
    </style>
@endpush
@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" method="post" enctype="multipart/form-data" action="{{route('product-requisition.update',encryptor('encrypt',$prwd->id), ['role' =>currentUser()])}}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="uptoken" value="{{encryptor('encrypt',$prwd->id)}}">

                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="title">Requisition Title</label>
                                            <input type="text" id="title" class="form-control"
                                                   placeholder="Product Requisition Title" name="title" value="{{$prwd->title}}">
                                        </div>
                                        @if($errors->has('title'))
                                            <span class="text-danger"> {{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    {{-- <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="req_slip_no">Requisition slip No</label>
                                            <label for="req_slip_no"></label>
                                            <input type="text" id="req_slip_no" class="form-control"
                                                   placeholder="Requisition slip No" name="req_slip_no" value="{{$prwd->req_slip_no}}">
                                        </div>
                                        @if($errors->has('req_slip_no'))
                                            <span class="text-danger"> {{ $errors->first('req_slip_no') }}</span>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="postingDate">Requistion Date</label>
                                            <input type="date" id="postingDate" class="form-control" name="postingDate" value="{{$prwd->postingDate}}">
                                        </div>
                                        @if($errors->has('postingDate'))
                                            <span class="text-danger"> {{ $errors->first('postingDate') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="order_id">Select Order</label>
                                            <select name="order_id" class="form-control">
                                                <option value="">Select</option>
                                                @forelse($orders as $or)
                                                    <option value="{{$or->id}}" @if($prwd->order_id == $or->id) selected @endif>{{$or->order_subject}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        @if($errors->has('order_id'))
                                            <span class="text-danger"> {{ $errors->first('order_id') }}</span>
                                        @endif
                                    </div>
                                    {{--                                    <div class="col-md-3 col-12">
                                                                            <div class="form-group">
                                                                                <label for="supplier_id">Select Supplier</label>
                                                                                <select name="supplier_id" class="form-control">
                                                                                    <option value="">Select</option>
                                                                                    @forelse($suppliers as $sup)
                                                                                        <option value="{{$sup->id}}">{{$sup->supplier_name}}</option>
                                                                                    @empty
                                                                                    @endforelse
                                                                                </select>
                                                                            </div>
                                                                            @if($errors->has('supplier_id'))
                                                                                <span class="text-danger"> {{ $errors->first('supplier_id') }}</span>
                                                                            @endif
                                                                        </div>--}}
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2">Select Product</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="" id="item_search"
                                                       class="form-control  ui-autocomplete-input"
                                                       placeholder="Search Product">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="hidden" value='1' id="hidden_rowcount" name="hidden_rowcount">
                                        <table
                                            class="product-req mt-3 table table-bordered"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"
                                        >
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" class="approve-all"></th>
                                                <th>Product</th>
                                                <th>Supplier</th>
                                                <th>Is Approved</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="details_data">
                                            @forelse($prwd->product_requistion_details as $key => $pr)
                                                <tr class="productlist" id="row_{{$key}}" data-item-id="{{$pr->product_id}}">
                                                    <input type="hidden" name="product_requisition_id[]" value="{{$pr->id}}">
                                                    <td><input type="checkbox" name="product_detl[]" class="single-pid" value="{{$pr->id}}"></td>
                                                    <td>
                                                        <select class="form-control" name="product_id[]">
                                                            <option>Select</option>
                                                            @forelse($products as $p)
                                                                <option
                                                                    value="{{$p->id}}"
                                                                    @if($pr->product_id == $p->id) selected @endif>{{$p->product_name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" name="supplier_id[]">
                                                            <option>Select</option>
                                                            @forelse($suppliers as $sup)
                                                                <option
                                                                    value="{{$sup->id}}"
                                                                    @if($pr->supplier_id == $sup->id) selected @endif>{{$sup->supplier_name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </td>
                                                    <td>@if($pr->status == 1) Yes @else No @endif</td>
                                                    <td><input type="text" class="per-unit-price form-control"
                                                               value="{{$pr->per_unit_price}}"
                                                               placeholder="Product Per Unit Price"
                                                               name="per_unit_price[]"></td>
                                                    <td><input type="text" class="qty form-control" value="{{$pr->qty}}"
                                                               placeholder="Product Qty" name="qty[]"
                                                               onkeyup="calc(this);total()"></td>
                                                    <td><input type="text" class="sub-total form-control"
                                                               value="{{$pr->total_payable}}"></td>
                                                    <td id="td_" style="text-align: center;">
{{--                                                        <form id="active-form-product-req" method="POST"--}}
{{--                                                              action="{{route('product-requisition-detl.destroy',[encryptor('encrypt', $pr->id)])}}"--}}
{{--                                                              style="display: inline;">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('DELETE')--}}
{{--                                                            <input name="_method" type="hidden" value="DELETE">--}}
                                                            <a href="javascript:void(0)" type="submit"
                                                               style="cursor: pointer;font-size: 14px;"
                                                               class="delete mr-2 btn btn-sm text-danger"
                                                               data-toggle="tooltip" title="Delete"><i
                                                                    class="bi bi-trash"></i></a>
{{--                                                        </form>--}}
                                                    </td>

                                                </tr>
                                            @empty
                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td colspan="6" class="text-end"><strong>Total</strong></td>
                                                <td><input type="text" class="form-control grand-total"></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="des">Description</label>
                                            <textarea rows="5" id="des" name="des" class="form-control">{{$prwd->des}}</textarea>
                                        </div>
                                        @if($errors->has('des'))
                                            <span class="text-danger"> {{ $errors->first('des') }}</span>
                                        @endif
                                    </div>


                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
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
    <script src="{{ asset('assets/js/pages/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $("#item_search").bind("paste", function (e) {
            $("#item_search").autocomplete('search');
        });
        $("#item_search").autocomplete({
            source: function (data, cb) {
                console.log(data);
                $.ajax({
                    autoFocus: true,
                    url: "{{route('allProducts')}}",
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        name: data.term
                    },
                    success: function (res) {
                        //console.log(res);
                        var result;
                        result = {
                            label: 'No Records Found ',
                            value: ''
                        };
                        if (res.length) {
                            result = $.map(res, function (el) {
                                return {
                                    label: 'Product Name:-' + (el.product_name) + '|Category Name:-' + el.category.category_name,
                                    value: '',
                                    id: el.id,
                                    pid: el.id,
                                };
                            });
                        }
                        cb(result);
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            },
            response: function (e, ui) {
                if (ui.content.length == 1) {
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete("close");
                }
                console.log(ui);
            },
            //loader start
            search: function (e, ui) {
            },
            select: function (e, ui) {
                if (typeof ui.content != 'undefined') {
                    if (isNaN(ui.content[0].id)) {
                        return;
                    }
                    var pid = ui.content[0].id;
                } else {
                    var pid = ui.item.id;
                }
                return_row_with_data(pid);
                $("#item_search").val('');
            },
            //loader end
        });

        function return_row_with_data(pid) {
            $("#item_search").addClass('ui-autocomplete-loader-center');
            // var order_id = $('#order_id').val();
            var rowcount = $("#hidden_rowcount").val();
            $.ajax({
                autoFocus: true,
                url: "{{route('productById')}}",
                method: 'GET',
                dataType: 'json',
                data: {
                    pid: pid,
                    rowcount: rowcount,
                },
                success: function (res) {
                    //console.log(res.data);
                    var item_check = check_same_item(pid);
                    if (!item_check) {
                        $("#item_search").removeClass('ui-autocomplete-loader-center');
                        toastr['error']("Product In List!!");
                        return false;
                    }
                    if (res.data.error) {
                        toastr['error']("Product In List!!");
                        return false;
                    }
                    $('#details_data').append(res.data);
                    $("#hidden_rowcount").val(parseFloat(rowcount) + 1);
                    $("#item_search").val('');
                    $("#item_search").removeClass('ui-autocomplete-loader-center');
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

        function check_same_item(item_id) {
            if ($(".product-req tr").length > 1) {
                var rowcount = $("#hidden_rowcount").val();
                for (i = 0; i <= rowcount; i++) {
                    if ($("#row_" + i).attr('data-item-id') == item_id) {
                        return false;
                    }
                } //end for
            }
            return true;
        }

        function calc(a) {
            var qty = $(a).val();
            var price = $(a).closest('td').prev('td').find('.per-unit-price').val();
            var total = qty * price;
            $(a).closest('td').next('td').find('.sub-total').val(total.toFixed(2));
        }

        function total() {
            var grand_total = 0;
            $(".sub-total").each(function () {
                grand_total += parseFloat($(this).val());
            });
            $('.grand-total').val(grand_total.toFixed(2));
        }
        total();

        function removerow(id) { //id=Rowid
            if ($("#row_" + id).remove()) {
                total();
            }
        }

        /*====Delete Single Record ===*/
        $('.product-req').on('click', '.delete', function (event) {
            event.preventDefault();
            swal({
                title: `Are you sure you want to Delete this ?`,
                text: "If you Delete this, it will be Deleted.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $(this).parent().submit();
                    }
                });
        });
        $('.approve-all').change(function(){
            $('.single-pid').prop('checked',this.checked);
        });
        $('.single-pid').change(function(){
            $('.approve-all').prop('checked', false);
        });
    </script>
@endpush

