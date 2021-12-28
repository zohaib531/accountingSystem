@extends('layouts.admin')
@section('title','Update Sale/Purchase Voucher')

@section('content')

<script src="{{ asset('assets/template/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/template/plugins/select2/js/select2.full.min.js') }}"></script>


     {{-- <div class="row page-titles mx-0">
         <div class="col p-md-0">
             <ol class="breadcrumb">
                 <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                 <li class="breadcrumb-item active"><a href="{{route('salePurchase.index')}}">Update Sale/Purchase Voucher</a></li>
             </ol>
         </div>
     </div>
     <!-- row --> --}}


     <div class="container-fluid">
         <div class="row">
             <div class="col-12">
                 <div class="card">
                    <form class="form-valide"  id="update-form">
                        @csrf
                        @method('put')
                            <div class="card-body px-5">
                                <div class="row m-0 justify-content-between">
                                    <div class="col-4 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-3 col-form-label px-0" for="update-date">Voucher Date<span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="update-date" name="date" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $voucher->date)->format('d / m / Y')}}" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-6">
                                        <h4 class="card-title">Update Sale/Purchase Voucher</h4>
                                    </div>
                                </div>


                                <div class="form-validation mb-3">

                                        {{-- Credit Section Start --}}
                                        <div  id="sale_purchase_credit" class="mt-5">
                                            <h3>Credit</h3>
                                            <div class="row mx-0 justify-content-between pt-3">
                                                <div class="col-2 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-3 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-4 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get()->count() > 0)
                                                @foreach($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get() as $detail)

                                                    <div class="row mx-0 justify-content-between pt-3">
                                                        <input type="hidden" name="credit_voucher_detail_ids[]" value="{{$detail->id}}">
                                                        <div class="col-2 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <input class="form-control" name="credit_dates[]" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $detail->date)->format('d / m / Y')}}" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <select name="credit_accounts[]" class="form-control updateSearchableSelectCredit{{$detail->id}}">
                                                                        <option disabled value="">Sub account</option>
                                                                        @foreach ($subAccounts as $subAccount)
                                                                            <option @if($subAccount->id==$detail->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-4 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <select name="credit_products[]" class="form-control updateSearchableSelectCreditProduct{{$detail->id}}">
                                                                        <option disabled value="">Product</option>
                                                                        @foreach ($products as $product)
                                                                            <option @if($detail->product_narration==$product->title." - ".$product->narration." - ".$product->product_unit) selected @endif value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <input type="text" name="credit_quantities[]"  class="form-control" oninput="createAmount(this , true, true)" value="{{$detail->quantity}}"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->quantity}}" data-common="common" onkeyup="getValue(this)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2 ">
                                                                    <input type="text" name="credit_rates[]"  class="form-control" oninput="createAmount(this , false, true)" value="{{$detail->rate}}"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->rate}}" data-common="common" onkeyup="getValue(this)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2 ">
                                                                    <input type="text" name="credit_amounts[]" class="form-control commonCredit" readonly oninput="totalCreditAmount(this)" value="{{$detail->credit_amount}}"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->credit_amount}}"  data-common="common" onkeyup="getValue(this)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- @if($loop->iteration!=1)
                                                            <div class="position-absolute" style="right:0px;">
                                                                <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white">x</button>
                                                            </div>
                                                        @endif --}}
                                                    </div>

                                                    <script>
                                                        $('.updateSearchableSelectCredit{{ $detail->id }}').select2({ dropdownParent: $('.updateSearchableSelectCredit{{ $detail->id }}').parent() });
                                                        $('.updateSearchableSelectCreditProduct{{ $detail->id }}').select2({ dropdownParent: $('.updateSearchableSelectCreditProduct{{ $detail->id }}').parent() });
                                                    </script>

                                                @endforeach
                                            @endif

                                        </div>
                                        <div class="text-right pl-2 mt-3">
                                            <button onclick="addNewRow(this,'#sale_purchase_credit' , 'credit_' , 'commonCredit')" class="btn btn-light" type="button">Add more +</button>
                                        </div>
                                        {{-- Credit Section end --}}



                                        {{-- Debit Section Start --}}
                                        <div  id="sale_purchase_debit" class="mt-4">
                                            <h3>Debit</h3>
                                            <div class="row mx-0 justify-content-between pt-3">
                                                <div class="col-2 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-3 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-4 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get()->count() > 0)
                                                @foreach($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get() as $detail)

                                                    <div class="row mx-0 justify-content-between pt-3">
                                                        <input type="hidden" name="debit_voucher_detail_ids[]" value="{{$detail->id}}">
                                                        <div class="col-2 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <input class="form-control" name="debit_dates[]" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $detail->date)->format('d / m / Y')}}" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <select name="debit_accounts[]" class="form-control updateSearchableSelectDebit{{ $detail->id }}">
                                                                        <option disabled value="">Sub account</option>
                                                                        @foreach ($subAccounts as $subAccount)
                                                                            <option @if($subAccount->id==$detail->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-4 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <select name="debit_products[]" class="form-control updateSearchableSelectDebitProduct{{ $detail->id }}">
                                                                        <option disabled value="">Product</option>
                                                                        @foreach ($products as $product)
                                                                            <option @if($detail->product_narration==$product->title." - ".$product->narration." - ".$product->product_unit) selected @endif value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <input type="text" name="debit_quantities[]"  class="form-control" oninput="createAmount(this , true, true)" value="{{$detail->quantity}}"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->quantity}}" data-common="common" onkeyup="getValue(this)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2 ">
                                                                    <input type="text" name="debit_rates[]"  class="form-control" oninput="createAmount(this , false, true)" value="{{$detail->rate}}"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->rate}}" data-common="common" onkeyup="getValue(this)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2 ">
                                                                    <input type="text" name="debit_amounts[]" class="form-control commonDebit" readonly oninput="totalCreditAmount(this)" value="{{$detail->debit_amount}}"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->debit_amount}}" data-common="common" onkeyup="getValue(this)">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- @if($loop->iteration!=1)
                                                            <div class="position-absolute" style="right:0px;">
                                                                <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white">x</button>
                                                            </div>
                                                        @endif --}}

                                                    </div>

                                                    <script>
                                                        $('.updateSearchableSelectDebit{{ $detail->id }}').select2({ dropdownParent: $('.updateSearchableSelectDebit{{ $detail->id }}').parent() });
                                                        $('.updateSearchableSelectDebitProduct{{ $detail->id }}').select2({ dropdownParent: $('.updateSearchableSelectDebitProduct{{ $detail->id }}').parent() });
                                                    </script>
                                                @endforeach
                                            @endif

                                        </div>
                                        <div class="text-right pl-2 mt-3">
                                            <button onclick="addNewRow(this,'#sale_purchase_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                                        </div>
                                        {{-- Debit Section end --}}

                                        @php
                                            $suspenseEntry = $voucher->voucherDetails()->where('suspense_account','1')->first();
                                            $str = $suspenseEntry!=null ? $suspenseEntry->entry_type."_amount":'';
                                        @endphp

                                        <div class="row m-0 justify-content-between align-items-end mt-5">
                                            <div class="col-6 pl-0">
                                                <div class="form-group row m-0 align-items-center differenceEntryCheck {{ $suspenseEntry ==null ? 'd-none' : ' '}}">
                                                    <label class="col-lg-9 col-form-label px-0 differenceLabel" for="checkedEntery">@if($suspenseEntry !=null)<b>{{ucfirst($suspenseEntry->entry_type)}}</b> difference of <b>{{ucfirst($suspenseEntry->$str)}}</b> has been adjusted @else Do you want to adujst? @endif</label>
                                                    <div class="col-lg-3 pl-0 pr-2 ">
                                                        <div>
                                                            <input type="checkbox" class="" {{ $suspenseEntry !=null ? 'checked' : ''}}  name="suspense_entry_check" id="checkedEntery" onchange="suspenseAccountEntryVerification(this);">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 px-0">
                                                <div class="row m-0">
                                                    <div class="col-12 pr-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                                <input type="hidden" class="form-control differenceInput" id="differenceInput" value="{{$suspenseEntry !=null?ucfirst($suspenseEntry->$str):0}}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mx-0 justify-content-between pt-3 differenceRow {{ $suspenseEntry ==null ? 'd-none' : ' '}}">
                                            <input type="hidden" id="suspense_entry" name="suspense_entry">
                                            <div class="col-4 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                                    <div class="col-lg-12 pl-0 pr-2">
                                                        <input class="form-control" name="suspense_date" value="{{ $suspenseEntry !=null ? \Carbon\Carbon::createFromFormat('Y-m-d', $suspenseEntry->date)->format('d / m / Y') :''}}" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                                    <div class="col-lg-12 pl-0 pr-2">
                                                        <select name="suspense_account" class="form-control updateSearchableSelectSuspense">
                                                            <option disabled value="">Sub account</option>
                                                            @foreach ($subAccounts as $subAccount)
                                                                <option @if($suspenseEntry !=null && $subAccount->id==$suspenseEntry->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                                    <div class="col-lg-12 pl-0 pr-2 ">
                                                        <input type="text" id="suspense_amount" name="suspense_amount" class="form-control" value="{{$suspenseEntry !=null? $suspenseEntry->$str:0}}" readonly  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$suspenseEntry !=null? $suspenseEntry->$str:0}}" data-common="common" onkeyup="getValue(this)">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row m-0 justify-content-between align-items-end mt-5">
                                            <div class="col-8 px-0"></div>
                                            <div class="col-4 px-0">
                                                <div class="row m-0">
                                                    <div class="col-6 pr-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                            <label class="col-lg-12 col-form-label px-0" for="debit-amount">Total Debit<span class="text-danger">*</span></label>
                                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                                <input type="number" class="form-control" id="debit-amount" name="total_debit" value="{{$voucher->total_debit}}" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$voucher->total_debit}}" data-common="common" onkeyup="getValue(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pr-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                            <label class="col-lg-12 col-form-label px-0" for="credit-amount">Total Credit<span class="text-danger">*</span></label>
                                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                                <input type="number" class="form-control" id="credit-amount" name="total_credit" value="{{$voucher->total_credit}}" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$voucher->total_credit}}" data-common="common" onkeyup="getValue(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('salePurchase.update',$voucher->id) }}','{{route('salePurchase.index')}}','post','','update-form');">Update</button>
                            </div>

                        </div>
                    </form>
                 </div>
             </div>
         </div>
     </div>
     <!-- #/ container -->




     @endsection


@section('script')

<script>

    const addNewRow=(elem, id, side , commonClass)=>{
        $(elem).parent().parent().find(id).append(`
            <div class="row mt-2 mx-0 justify-content-between position-relative w-100">
                <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input class="form-control" name="${side}dates[]" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="col-3 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <select name="${side}accounts[]" class="form-control updateSearchableSelect">
                                    <option disabled value="">Sub account</option>
                                    @foreach ($subAccounts as $subAccount)
                                        <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <select name="${side}products[]" class="form-control updateSearchableSelect">
                                    <option disabled value="">Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-1 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="text" name="${side}quantities[]" class="form-control" oninput="createAmount(this , true, true)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                            </div>
                        </div>
                    </div>

                    <div class="col-1 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="text" name="${side}rates[]" class="form-control" oninput="createAmount(this , false, true)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                            </div>
                        </div>
                    </div>

                    <div class="col-1 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 px-0">
                                <input type="text" name="${side}amounts[]" readonly class="form-control ${commonClass}"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                            </div>
                        </div>
                    </div>

                <div class="position-absolute" style="right:-38px;">
                    <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white px-2">x</button>
                </div>

            </div>

        `);

        // Initialize coma in add more
            defaultScope.ready();
        // Initialize coma in add more
    }



    $(document).ready(function() {

        $('.updateSearchableSelectCredit').select2({ dropdownParent: $('.updateSearchableSelectCredit').parent() });
        $('.updateSearchableSelectCreditProduct').select2({ dropdownParent: $('.updateSearchableSelectCreditProduct').parent() });
        $('.updateSearchableSelectSuspense').select2({ dropdownParent: $('.updateSearchableSelectSuspense').parent() });

    });

</script>

@endsection



