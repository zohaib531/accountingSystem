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

     <div class="alert alert-success alert-dismissible fade successAlert" style="width: fit-content;position:absolute; z-index:1111;right:0;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success</strong> data has been added successfully.
    </div>


     <div class="container-fluid">
         <div class="row">
             <div class="col-12 px-0">
                 <div class="card">
                    <form class="form-valide"  id="update-form">
                        @csrf
                        @method('put')
                            <div class="card-body px-4">
                                <div class="row m-0 justify-content-between">
                                    <div class="col-4 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-3 col-form-label px-0" for="update-date">Voucher Date<span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input class="form-control" id="update-date" name="date" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $voucher->date)->format('d / m / y')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-4 text-center">
                                        <h4 class="card-title">Update Sale/Purchase Voucher</h4>
                                    </div>
                                    <div class="col-4 text-right">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addsubaccount" onclick="initializeSelect2(), transactionSelect2()">Add Sub account</button>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addProduct" onclick="initializeSelect2()">Add Product</button>
                                        <button type="button" class="btn btn-danger" onclick="commonFunction(true,'{{ route('salePurchase.destroy', $id) }}','{{route('salePurchase.index')}}','delete','Are you sure you want to delete complete voucher?','');">Delete Voucher</button>
                                    </div>
                                </div>


                                <div class="form-validation mb-3">

                                        {{-- Credit Section Start --}}
                                        <div  id="sale_purchase_credit" class="mt-3">
                                            <h3>Credit</h3>
                                            <div class="row mx-0 justify-content-between">
                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Date<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-3 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Sub Account<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-4 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Product<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Quantity<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Rate<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Com %<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Amount<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get()->count() > 0)
                                                @foreach($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get() as $detail)

                                                    <div class="row mx-0 justify-content-between mt-2">
                                                        <input type="hidden" name="credit_voucher_detail_ids[]" value="{{$detail->id}}">
                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <input class="form-control" name="credit_dates[]" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $detail->date)->format('d / m / y')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <select name="credit_accounts[]" class="form-control pushSubAccount updateSearchableSelectCredit{{$detail->id}}">
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
                                                                    <select name="credit_products[]" class="form-control pushProduct updateSearchableSelectCreditProduct{{$detail->id}}">
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
                                                                    <input type="text" name="credit_commission[]" oninput="comissonCalculaion(this)" value="{{$detail->commission}}" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" value="0">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-0">
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
                                        <div class="text-right pl-2 mt-2">
                                            <button onclick="addNewRow(this,'#sale_purchase_credit' , 'credit_' , 'commonCredit')" class="btn btn-light" type="button">Add more +</button>
                                        </div>
                                        {{-- Credit Section end --}}



                                        {{-- Debit Section Start --}}
                                        <div  id="sale_purchase_debit">
                                            <h3>Debit</h3>
                                            <div class="row mx-0 justify-content-between mt-2">
                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Date<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-3 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Sub Account<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-4 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Product<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Quantity<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Rate<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Com %<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>

                                                <div class="col-1 px-0">
                                                    <div class="form-group row m-0 align-items-center">
                                                        <label class="col-lg-12 col-form-label px-0 pb-0">Amount<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get()->count() > 0)
                                                @foreach($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get() as $detail)

                                                    <div class="row mx-0 justify-content-between mt-2">
                                                        <input type="hidden" name="debit_voucher_detail_ids[]" value="{{$detail->id}}">
                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <input class="form-control" name="debit_dates[]" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $detail->date)->format('d / m / y')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-3 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-2">
                                                                    <select name="debit_accounts[]" class="form-control pushSubAccount updateSearchableSelectDebit{{ $detail->id }}">
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
                                                                    <select name="debit_products[]" class="form-control pushProduct updateSearchableSelectDebitProduct{{ $detail->id }}">
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
                                                                    <input type="text" name="debit_commission[]" oninput="comissonCalculaion(this)" value="{{$detail->commission}}" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" value="0">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-1 px-0">
                                                            <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                                <div class="col-lg-12 pl-0 pr-0">
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
                                        <div class="text-right pl-2 mt-2">
                                            <button onclick="addNewRow(this,'#sale_purchase_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                                        </div>
                                        {{-- Debit Section end --}}

                                        @php
                                            $suspenseEntry = $voucher->voucherDetails()->where('suspense_account','1')->first();
                                            $str = $suspenseEntry!=null ? $suspenseEntry->entry_type."_amount":'';
                                        @endphp

                                        <div class="row m-0 justify-content-between align-items-end mt-3">
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
                                            <input type="hidden" id="suspense_entry" name="suspense_entry" value="{{$suspenseEntry !=null?$suspenseEntry->entry_type:''}}">
                                            <div class="col-4 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                                    <div class="col-lg-12 pl-0 pr-2">
                                                        <input class="form-control" name="suspense_date" value="{{ $suspenseEntry !=null ? \Carbon\Carbon::createFromFormat('Y-m-d', $suspenseEntry->date)->format('d / m / y') :''}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                                    <div class="col-lg-12 pl-0 pr-2">
                                                        <select name="suspense_account" class="form-control updateSearchableSelectSuspense">
                                                            <option disabled selected value="">Sub account</option>
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

                                        <div class="row m-0 justify-content-between align-items-end mt-3">
                                            <div class="col-8 px-0"></div>
                                            <div class="col-4 px-0">
                                                <div class="row m-0">
                                                    <div class="col-6 pr-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                            <label class="col-lg-12 col-form-label px-0" for="debit-amount">Total Debit<span class="text-danger">*</span></label>
                                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                                <input type="text" class="form-control" id="debit-amount" name="total_debit" value="{{$voucher->total_debit}}" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$voucher->total_debit}}" data-common="common" onkeyup="getValue(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pr-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                            <label class="col-lg-12 col-form-label px-0" for="credit-amount">Total Credit<span class="text-danger">*</span></label>
                                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                                <input type="text" class="form-control" id="credit-amount" name="total_credit" value="{{$voucher->total_credit}}" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$voucher->total_credit}}" data-common="common" onkeyup="getValue(this)">
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




<!--Add subaccount modal start-->
<div class="modal fade addsubaccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sub Accounts</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
               <div class="form-validation my-5">
                   <form class="form-valide" id="create-form-sub">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="val-account">General Accounts<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select class="form-control searchableSelectSubAccount removeVal" id="val-account" name="account_id">
                                    <option value="" disabled selected>Select General Accounts</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{str_pad($account->id, 2, '0', STR_PAD_LEFT)}}">{{$account->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="val-title">Sub Accounts<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control removeVal" id="val-title" name="title" placeholder="Enter Sub Accounts..">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="opening-balance">Opening Balance<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <div class="row m-0">
                                    <div class="col-6 pl-0">
                                        <input type="text" class="form-control removeVal" id="opening-balance" value="0" name="opening_balance" placeholder="Enter Opening Balance.."  maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                    </div>
                                    <div class="col-6 pr-0">
                                        <select class="form-control searchableSelectTransaction removeVal" id="transaction-type" name="transaction_type">
                                            <option value="" disabled selected>Select Debit/Credit</option>
                                            <option value="debit">Debit</option>
                                            <option value="credit">Credit</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="opening-date">Opening Date<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control removeVal" id="opening-date" name="opening_date" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                            </div>
                        </div>

                   </form>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-danger text-white customModalClose" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-success text-white" onclick="addRealTimeFunction(false,'{{ route('sub-accounts.store') }}', 'subAccount', 'post','','create-form-sub');">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add subaccount modal start-->

<!--Add Product modal start-->
<div class="modal fade addProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Products</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
               <div class="form-validation my-5">
                   <form class="form-valide" id="create-form-pro">
                       <input type="hidden" name="unique_product" id="productUniqueAdd">

                       <div class="row m-0">
                           <div class="col-7 px-0">
                               <div class="form-group row">
                                   <label class="col-lg-5 col-form-label px-0" for="product-title">Product Name<span class="text-danger">*</span></label>
                                   <div class="col-lg-7 pr-0" style="padding-left: 1.3rem !important;">
                                       <input type="text" class="form-control removeVal" id="product-title" name="title" placeholder="Enter Product Name.." oninput="getUniqueProduct('#product-title', '#product-naration', '#product-unit' , '#productUniqueAdd')">
                                   </div>
                               </div>
                           </div>
                           <div class="col-5 pl-0">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label px-0 text-right" for="product-unit">Unit<span class="text-danger">*</span></label>
                                    <div class="col-lg-9 pr-0">
                                        <select class="form-control searchableSelect removeVal" id="product-unit" name="product_unit" onchange="getUniqueProduct('#product-title', '#product-naration', '#product-unit', '#productUniqueAdd')">
                                            <option value="" disabled selected>Select Product unit</option>
                                            <option value="meter">Meter</option>
                                            <option value="bags">Bags</option>
                                            <option value="kgs">Kgs</option>
                                            <option value="pounds">Pounds</option>
                                        </select>
                                    </div>
                                </div>
                           </div>
                       </div>



                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="product-naration">Narration<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control removeVal" id="product-naration" name="narration" placeholder="Enter Narration.." oninput="getUniqueProduct('#product-title', '#product-naration', '#product-unit', '#productUniqueAdd')">
                            </div>
                        </div>

                   </form>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-danger text-white customModalClose" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-success text-white" onclick="addRealTimeFunction(false,'{{ route('products.store') }}','product','post','','create-form-pro');">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add Product modal start-->




     @endsection


@section('script')

<script>
    let i = 0;
    const addNewRow=(elem, id, side , commonClass)=>{
        ++i
        $(elem).parent().parent().find(id).append(`
            <div class="row mt-2 mx-0 justify-content-between position-relative w-100">
                <div class="col-1 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input class="form-control" name="${side}dates[]" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="col-3 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <select name="${side}accounts[]" class="form-control updateSearchableSelect${i}">
                                    <option disabled selected value="">Sub account</option>
                                    @foreach ($subAccounts as $subAccount)
                                        <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                    @endforeach
                                    <option value="${$('.realtimeSubAccount').val()}">${$('.realtimeSubAccount').html()}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <select name="${side}products[]" class="form-control updateSearchableSelectProduct${i}">
                                    <option disabled selected value="">Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                    @endforeach
                                    <option value="${$('.realtimeProduct').val()}">${$('.realtimeProduct').html()}</option>
                                </select>

                            </div>
                        </div>
                    </div>



                    <div class="col-1 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="text" name="${side}quantities[]" class="form-control" oninput="createAmount(this , true, true)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="col-1 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="text" name="${side}rates[]" class="form-control" oninput="createAmount(this , false, true)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="col-1 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="text" name="${side}_commission[]" oninput="comissonCalculaion(this)" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" value="0">
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

        if($('#checkedEntery').is(":checked")){
            $('#checkedEntery').click()
        }
        // Initialize coma in add more
            defaultScope.ready();
        // Initialize coma in add more

        $('.updateSearchableSelect'+i).select2({ dropdownParent: $('.updateSearchableSelect'+i).parent() });
        $('.updateSearchableSelectProduct'+i).select2({ dropdownParent: $('.updateSearchableSelectProduct'+i).parent() });


    }



    $(document).ready(function() {
        $('.updateSearchableSelectSuspense').select2({ dropdownParent: $('.updateSearchableSelectSuspense').parent() });
        $('.searchableSelectSubAccount').select2({ dropdownParent: $('.searchableSelectSubAccount').parent() });

    });

    function transactionSelect2(){
            $('.searchableSelectTransaction').select2({dropdownParent: $('.searchableSelectTransaction').parent()});
    }

</script>

@endsection



