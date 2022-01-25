@extends('layouts.admin')
@section('title','Add Sale/Purchase Voucher')


@section('content')



{{-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('salePurchase.index')}}">All Sale/Purchase Voucher</a></li>
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
              <form class="form-valide" id="create-form">
                <div class="card-body px-4">
                    <div class="row m-0 justify-content-between">
                        <div class="col-4 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-3 col-form-label px-0" for="val-date">Voucher Date<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="val-date" name="date" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <h4 class="card-title">Sale/Purchase Voucher</h4>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addsubaccount" onclick="initializeSelect2(), transactionSelect2()">Add Sub account</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addProduct" onclick="initializeSelect2()">Add Product</button>
                        </div>

                    </div>


                    <div class="form-validation mb-3">

                             {{-- Credit Section Start --}}
                             <div  id="sale_purchase_credit" class="mt-3">
                                 <h3>Credit</h3>
                                 <div class="row mx-0 justify-content-between">
                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 {{-- <input type="date" class="form-control" name="credit_dates[]"> --}}
                                                 <input class="form-control" name="credit_dates[]"  placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-3 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="credit_accounts[]" class="form-control pushSubAccount searchableSelectCredit">
                                                     <option selected disabled value=""> Sub account</option>
                                                     @foreach ($subAccounts as $subAccount)
                                                         <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                     @endforeach

                                                 </select>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-4 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="credit_products[]" class="form-control pushProduct searchableSelectCreditProduct">
                                                     <option selected disabled value="">Product</option>
                                                     @foreach ($products as $product)
                                                         <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>



                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <input type="text" name="credit_quantities[]"  class="form-control" oninput="createAmount(this , true, true)" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2 ">
                                                 <input type="text" name="credit_rates[]"  class="form-control" oninput="createAmount(this , false, true)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-1 px-0">
                                        <div class="form-group row m-0 align-items-center">
                                            <label class="col-lg-12 col-form-label px-0">Com %<span class="text-danger">*</span></label>
                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                <input type="text" name="credit_commission[]" onkeyup="comissonCalculaion(this)" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" value="0">
                                            </div>
                                        </div>
                                    </div>



                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 px-0">
                                                 <input type="text" name="credit_amounts[]" class="form-control commonCredit" readonly oninput="totalCreditAmount(this)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)" value="0">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="text-right pl-2 mt-2">
                                 <button onclick="addNewRow(this,'#sale_purchase_credit' , 'credit_' , 'commonCredit')" class="btn btn-light" type="button">Add more +</button>
                             </div>
                             {{-- Credit Section end --}}



                             {{-- Debit Section Start --}}
                             <div  id="sale_purchase_debit">
                                 <h3>Debit</h3>
                                 <div class="row mx-0 justify-content-between">
                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <input class="form-control" name="debit_dates[]" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-3 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="debit_accounts[]" class="form-control pushSubAccount searchableSelectDebit">
                                                     <option selected disabled value="">Sub account</option>
                                                     @foreach ($subAccounts as $subAccount)
                                                         <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-4 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="debit_products[]" class="form-control pushProduct searchableSelectDebitProduct">
                                                     <option selected disabled value="">Product</option>
                                                     @foreach ($products as $product)
                                                         <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>



                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <input type="text" name="debit_quantities[]"  class="form-control" oninput="createAmount(this , true, true)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2 ">
                                                 <input type="text" name="debit_rates[]"  class="form-control" oninput="createAmount(this , false, true)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-1 px-0">
                                        <div class="form-group row m-0 align-items-center">
                                            <label class="col-lg-12 col-form-label px-0">Com %<span class="text-danger">*</span></label>
                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                <input type="text" name="debit_commission[]" onkeyup="comissonCalculaion(this)" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" value="0">
                                            </div>
                                        </div>
                                    </div>


                                     <div class="col-1 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 px-0">
                                                 <input type="text" name="debit_amounts[]" class="form-control commonDebit" readonly oninput="totalDebitAmount(this)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                             </div>
                             <div class="text-right pl-2 mt-2">
                                 <button onclick="addNewRow(this,'#sale_purchase_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                             </div>
                             {{-- Debit Section end --}}

                             <div class="row m-0 justify-content-between align-items-end mt-3">
                                 <div class="col-4 pl-0">
                                     <div class="form-group row m-0 align-items-center differenceEntryCheck d-none">
                                         <label class="col-lg-10 col-form-label px-0 differenceLabel" for="checkedEntery">Do you want suspense Entry?<span class="text-danger">*</span></label>
                                         <div class="col-lg-2 pl-0 pr-2 ">
                                             <div>
                                                 <input type="checkbox" class="" name="suspense_entry_check" id="checkedEntery" onchange="suspenseAccountEntryVerification(this);">
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-4 px-0">
                                     <div class="row m-0">
                                         <div class="col-12 pr-0">
                                             <div class="form-group row m-0 align-items-center">
                                                 <div class="col-lg-12 pl-0 pr-2 ">
                                                     {{-- <label class="col-form-label px-0 differenceLabel" for="differenceInput">Difference</label> --}}
                                                     <input type="hidden" class="form-control differenceInput" id="differenceInput" name="total_debit" value="0" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                             </div>

                             <div class="row mx-0 justify-content-between pt-3 differenceRow d-none">
                                 <input type="hidden" id="suspense_entry" name="suspense_entry">
                                 <div class="col-4 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 pl-0 pr-2">
                                             <input class="form-control" name="suspense_date" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-4 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 pl-0 pr-2">
                                             <select name="suspense_account" class="form-control searchableSelectSuspense">
                                                 <option selected disabled value="">Sub account</option>
                                                 @foreach ($subAccounts as $subAccount)
                                                     <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-4 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 px-0">
                                             <input type="text" id="suspense_amount" name="suspense_amount" class="form-control" value="0" readonly  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                         </div>
                                     </div>
                                 </div>
                             </div>

                             <div class="row m-0 justify-content-between align-items-end mt-3">
                                 <div class="col-4 pr-0">
                                     {{-- <div class="form-group row m-0 align-items-center differenceEntryCheck d-none">
                                         <label class="col-lg-9 col-form-label px-0" for="checkedEntery">Do you want suspense Entry?<span class="text-danger">*</span></label>
                                         <div class="col-lg-3 pl-0 pr-2 ">
                                             <div>
                                                 <input type="checkbox" class="" name="suspense_entry_check" id="checkedEntery" onchange="suspenseAccountEntryVerification(this);">
                                             </div>
                                         </div>
                                     </div> --}}
                                 </div>

                                 <div class="col-4 px-0">
                                     {{-- <div class="row m-0">
                                         <div class="col-12 pr-0">
                                             <div class="form-group row m-0 align-items-center">
                                                 <div class="col-lg-12 pl-0 pr-2 ">
                                                     <label class="col-form-label px-0 differenceLabel" for="differenceInput">Difference</label>
                                                     <input type="number" class="form-control differenceInput" id="differenceInput" name="total_debit" value="0" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                     </div> --}}
                                 </div>

                                 <div class="col-4 px-0">
                                     <div class="row m-0">
                                         <div class="col-6 pr-0">
                                             <div class="form-group row m-0 align-items-center">
                                                 <label class="col-lg-12 col-form-label px-0" for="debit-amount">Total Debit<span class="text-danger">*</span></label>
                                                 <div class="col-lg-12 pl-0 pr-2 ">
                                                     <input type="text" class="form-control" id="debit-amount" name="total_debit" value="0.00" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6 pr-0">
                                             <div class="form-group row m-0 align-items-center">
                                                 <label class="col-lg-12 col-form-label px-0" for="credit-amount">Total Credit<span class="text-danger">*</span></label>
                                                 <div class="col-lg-12 pl-0 pr-2 ">
                                                     <input type="text" class="form-control" id="credit-amount" name="total_credit" value="0.00" readonly data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('salePurchase.store') }}','{{route('salePurchase.create')}}','post','','create-form') ">Save</button>
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
    let count = 0;
    const addNewRow=(elem, id, side , commonClass)=>{

        count++;

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
                                <select name="${side}accounts[]" class="form-control searchableSelect${side}${count} pushSubAccount">
                                    <option selected disabled value="">Sub account</option>
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
                                <select name="${side}products[]" class="form-control searchableSelect${side}Product${count} pushProduct">
                                    <option selected disabled value="">Product</option>
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
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="text" name="${side}_commission[]" onkeyup="comissonCalculaion(this)" class="form-control" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" value="0">
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
        // Initialize select2 in add more
        $(`.searchableSelect${side}${count}`).select2({ dropdownParent: $(`.searchableSelect${side}${count}`).parent() });
        $(`.searchableSelect${side}Product${count}`).select2({ dropdownParent: $(`.searchableSelect${side}Product${count}`).parent() });
        // Initialize select2 in add more

        // Initialize coma in add more
        defaultScope.ready();
        // Initialize coma in add more

    }




    $(document).ready(function() {

        $('.searchableSelectCredit').select2({ dropdownParent: $('.searchableSelectCredit').parent() });
        $('.searchableSelectCreditProduct').select2({ dropdownParent: $('.searchableSelectCreditProduct').parent() });
        $('.searchableSelectDebit').select2({ dropdownParent: $('.searchableSelectDebit').parent() });
        $('.searchableSelectDebitProduct').select2({ dropdownParent: $('.searchableSelectDebitProduct').parent() });
        $('.searchableSelectSuspense').select2({ dropdownParent: $('.searchableSelectSuspense').parent() });


        $('.searchableSelectSubAccount').select2({ dropdownParent: $('.searchableSelectSubAccount').parent() });
    });

    function transactionSelect2(){
            $('.searchableSelectTransaction').select2({dropdownParent: $('.searchableSelectTransaction').parent()});
    }
</script>

@endsection

