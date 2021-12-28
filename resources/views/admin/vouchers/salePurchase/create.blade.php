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

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
              <form class="form-valide" id="create-form">
                <div class="card-body px-5">
                    <div class="row m-0 justify-content-between">
                        <div class="col-4 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-3 col-form-label px-0" for="val-date">Voucher Date<span class="text-danger">*</span></label>
                                <div class="col-lg-9">
                                    <input class="form-control" id="val-date" name="date" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="card-title">Sale/Purchase Voucher</h4>
                        </div>
                    </div>


                    <div class="form-validation mb-3">

                             {{-- Credit Section Start --}}
                             <div  id="sale_purchase_credit" class="mt-3">
                                 <h3>Credit</h3>
                                 <div class="row mx-0 justify-content-between">
                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 {{-- <input type="date" class="form-control" name="credit_dates[]"> --}}
                                                 <input class="form-control" name="credit_dates[]"  placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-3 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="credit_accounts[]" class="form-control searchableSelectCredit">
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
                                                 <select name="credit_products[]" class="form-control searchableSelectCreditProduct">
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
                                             <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 px-0">
                                                 <input type="text" name="credit_amounts[]" class="form-control commonCredit" readonly oninput="totalCreditAmount(this)"  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
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
                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <input class="form-control" name="debit_dates[]" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-3 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="debit_accounts[]" class="form-control searchableSelectDebit">
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
                                                 <select name="debit_products[]" class="form-control searchableSelectDebitProduct">
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
                                             <input class="form-control" name="suspense_date" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
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
                            <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('salePurchase.store') }}','{{route('salePurchase.index')}}','post','','create-form') ">Save</button>
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
    let count = 0;
    const addNewRow=(elem, id, side , commonClass)=>{

        count++;

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
                                <select name="${side}accounts[]" class="form-control searchableSelect${side}${count}">
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
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <select name="${side}products[]" class="form-control searchableSelect${side}Product${count}">
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

    });
</script>

@endsection

