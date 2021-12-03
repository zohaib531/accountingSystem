@extends('layouts.admin')
@section('title','Sale/Purchase Voucher List')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')



<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('salePurchase.index')}}">All Sale/Purchase Voucher</a></li>
        </ol>
    </div>
</div>
<!-- row -->

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
                                    <input type="date" class="form-control" id="val-date" name="date" data-date="" data-date-format="DD/MM/YYYY">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="card-title">Sale/Purchase Voucher</h4>
                        </div>
                    </div>


                    <div class="form-validation mt-3 mb-3">

                             {{-- Credit Section Start --}}
                             <div  id="sale_purchase_credit" class="mt-5">
                                 <h3>Credit</h3>
                                 <div class="row mx-0 justify-content-between">
                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <input type="date" class="form-control" name="credit_dates[]" data-date-format="DD/MM/YYYY">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="credit_accounts[]" class="form-control">
                                                     <option selected value="">Sub account</option>
                                                     @foreach ($subAccounts as $subAccount)
                                                         <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="credit_products[]" class="form-control">
                                                     <option selected value="">Product</option>
                                                     @foreach ($products as $product)
                                                         <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>



                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <input type="number" name="credit_quantities[]"  class="form-control" oninput="createAmount(this , true, true)">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2 ">
                                                 <input type="number" name="credit_rates[]"  class="form-control" oninput="createAmount(this , false, true)">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2 ">
                                                 <input type="number" name="credit_amounts[]" class="form-control commonCredit" readonly oninput="totalCreditAmount(this)">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="text-right pl-2 mt-3">
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
                                                 <input type="date" class="form-control" name="debit_dates[]" data-date="" data-date-format="DD/MM/YYYY">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="debit_accounts[]" class="form-control">
                                                     <option selected value="">Sub account</option>
                                                     @foreach ($subAccounts as $subAccount)
                                                         <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <select name="debit_products[]" class="form-control">
                                                     <option selected value="">Product</option>
                                                     @foreach ($products as $product)
                                                         <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                     </div>



                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2">
                                                 <input type="number" name="debit_quantities[]"  class="form-control" oninput="createAmount(this , true, true)">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2 ">
                                                 <input type="number" name="debit_rates[]"  class="form-control" oninput="createAmount(this , false, true)">
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-2 px-0">
                                         <div class="form-group row m-0 align-items-center">
                                             <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                             <div class="col-lg-12 pl-0 pr-2 ">
                                                 <input type="text" name="debit_amounts[]" class="form-control commonDebit" readonly oninput="totalDebitAmount(this)">
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                             </div>
                             <div class="text-right pl-2 mt-3">
                                 <button onclick="addNewRow(this,'#sale_purchase_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                             </div>
                             {{-- Debit Section end --}}

                             <div class="row m-0 justify-content-between align-items-end mt-3">
                                 <div class="col-4 pl-0">
                                     <div class="form-group row m-0 align-items-center differenceEntryCheck d-none">
                                         <label class="col-lg-9 col-form-label px-0 differenceLabel" for="checkedEntery">Do you want suspense Entry?<span class="text-danger">*</span></label>
                                         <div class="col-lg-3 pl-0 pr-2 ">
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
                                             <input type="date" class="form-control" name="suspense_date" data-date="" data-date-format="DD/MM/YYYY">
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-4 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 pl-0 pr-2">
                                             <select name="suspense_account" class="form-control">
                                                 <option selected value="">Sub account</option>
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
                                         <div class="col-lg-12 pl-0 pr-2 ">
                                             <input type="number" id="suspense_amount" name="suspense_amount" class="form-control" value="0" readonly>
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
                                                     <input type="number" class="form-control" id="debit-amount" name="total_debit" value="0" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-6 pr-0">
                                             <div class="form-group row m-0 align-items-center">
                                                 <label class="col-lg-12 col-form-label px-0" for="credit-amount">Total Credit<span class="text-danger">*</span></label>
                                                 <div class="col-lg-12 pl-0 pr-2 ">
                                                     <input type="number" class="form-control" id="credit-amount" name="total_credit" value="0" readonly>
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



 <!--Update Product modal start-->

 <div class="modal fade updateSalePurchase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg saleParchaseWidth">
        <div class="modal-content updateModalSalePurchase">

        </div>
    </div>
</div>
<!--Update Product modal start-->



@endsection


@section('script')
    <script src="{{asset('assets/template/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>

<script>



    const addNewRow=(elem, id, side , commonClass)=>{
        $(elem).parent().parent().find(id).append(`
            <div class="row mt-3 mx-0 justify-content-between position-relative w-100">
                <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="date" class="form-control apendDate" name="${side}dates[]" data-date-format="DD/MM/YYYY">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <select name="${side}accounts[]" class="form-control">
                                    <option selected value="">Sub account</option>
                                    @foreach ($subAccounts as $subAccount)
                                        <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <select name="${side}products[]" class="form-control">
                                    <option selected value="">Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="number" name="${side}quantities[]"  class="form-control" oninput="createAmount(this , true, true)">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="number" name="${side}rates[]"  class="form-control" oninput="createAmount(this , false, true)">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="number" name="${side}amounts[]" readonly class="form-control ${commonClass}">
                            </div>
                        </div>
                    </div>

                <div class="position-absolute" style="right:-44px;">
                    <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white">x</button>
                </div>

            </div>

        `);

        var today = moment();
        $('.apendDate').val(today.format('DD/MM/YYYY'));
        $('.apendDate').attr('data-date',today.format('DD/MM/YYYY'));
    }


</script>

@endsection

