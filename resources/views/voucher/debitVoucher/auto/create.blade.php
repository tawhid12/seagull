@extends('layout.app')

@section('pageTitle',trans('Create Debit/Payment Voucher'))
@section('pageSubTitle',trans('Create'))

@section('content')
  <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <h4 class="card-title text-center">{{__('Debit Voucher Entry')}}</h4>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" enctype="multipart/form-data" method="post" action="{{route('debit.store')}}">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="model" value="{{request()->get('op')}}">
                                    <input type="hidden" name="model_id" value="{{request()->get('id')}}">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="countryName">{{__('Voucher No')}}</label>
                                            <input type="text" id="voucher_no" class="form-control" value="" name="voucher_no" readonly>
                                            @if($errors->has('countryName'))
                                                <span class="text-danger"> {{ $errors->first('countryName') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="date">{{__('Date')}}</label>
                                            <input type="date" id="current_date" class="form-control" value="{{ old('current_date')}}" name="current_date" required>
                                            @if($errors->has('current_date'))
                                                <span class="text-danger"> {{ $errors->first('current_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="name">{{__('Name')}}</label>
                                            <input type="text" id="pay_name" class="form-control" value="{{ old('pay_name',$r->title)}}" name="pay_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Purpose">{{__('Purpose')}}</label>
                                            <input type="text" id="purpose" class="form-control" value="{{ old('purpose')}}" name="purpose">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="Category">{{__('Received Account')}}</label>
                                            <select  class="form-control form-select" name="credit">
                                                @if($paymethod)
                                                    @foreach($paymethod as $d)
                                                        <option value="{{$d['table_name']}}~{{$d['id']}}~{{$d['head_name']}}-{{$d['head_code']}}">{{$d['head_name']}}-{{$d['head_code']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-bordered" id='account' cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>{{__('SN#')}}</th>
                                                <th>{{__('A/C Head')}}</th>
                                                <th>{{__('Amount')}}</th>
                                                <th>{{__('Remarks')}}</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align:right;" colspan="2">{{__('Total Amount Tk.')}}</th>
                                                <th><input type='text' class='form-control' name='debit_sum' id='debit_sum' value='{{$r->approve_amount}}' style='text-align:center; border:none;' readonly autocomplete="off" /></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody style="background:#eee;">
                                            <tr>
                                                <td style='text-align:center;'>1</td>
                                                <td style='text-align:left;'>
                                                    <div style='width:100%;position:relative;'>
                                                        <input type='text' name='account_code[]' class='cls_account_code form-control' value='{{$r->account_code}}' style='border:none;' maxlength='100' readonly/>
                                                    </div>
                                                        <input type='hidden' class='table_name' name='table_name[]' value='{{$r->table_name}}'>
                                                        <input type='hidden' class='table_id' name='table_id[]' value='{{$r->table_id}}'>
                                                </td>
                                                <td style='text-align:left;'>
                                                    <input type='text' name='debit[]' class='cls_debit form-control' value='{{$r->approve_amount}}' style='text-align:center; border:none;' maxlength='15'  autocomplete="off" readonly/> 
                                                </td>
                                                <td style='text-align:left;'><input type='text' class=" form-control" name='remarks[]' value='' maxlength='50' style='text-align:left;border:none;' /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group @if($errors->has('name')) has-error @endif">
                                            <label>{{__('Cheque No')}}</label>
                                            <span class="block input-icon input-icon-right">
                                                <input type="text" class="form-control" name="cheque_no" value="{{old('cheque_no')}}">
                                                @if($errors->has('cheque_no')) 
                                                <i class="ace-icon fa fa-times-circle"></i>
                                                @endif
                                            </span>
                                            @if($errors->has('cheque_no')) 
                                                <div class="help-block col-sm-reset">
                                                {{ $errors->first('cheque_no') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                            <label>{{__('Bank Name')}}</label>
                                            <input type="text" class="form-control" name="bank" value="{{old('bank')}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group">
                                            <label>{{__('Cheque Date')}}</label>
                                            <input type="date" class="form-control" name="cheque_dt" >
                                                
                                            @if($errors->has('cheque_dt')) 
                                                <div class="help-block col-sm-reset">
                                                {{ $errors->first('cheque_dt') }}
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <input class="form-control" type="file" name="slip">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">{{__('Submit')}}</button>
                                        
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

</script>
@endpush