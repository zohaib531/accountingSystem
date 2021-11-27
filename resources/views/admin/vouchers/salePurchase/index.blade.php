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
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-6 text-right">
                            <h4 class="card-title">All Sale/Purchase Voucher</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addSalePurchase">Add new +</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th colspan="2" class="text-center">Details</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $key=> $sale_purchase_voucher)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$sale_purchase_voucher->date }}</td>
                                    <td colspan="2">
                                        <table class="w-100">
                                            <thead>
                                                <tr>
                                                    <th>Sub Account</th>
                                                    <th>Product</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($sale_purchase_voucher->voucherDetails->count()>0)
                                                    @foreach($sale_purchase_voucher->voucherDetails as $detail)
                                                        <tr>
                                                            @php $str = $detail->entry_type."_amount";  @endphp
                                                            {{-- <th>{{ucfirst($detail->entry_type)}}</th> --}}
                                                            <td>{{$detail->subAccount->title}}</td>
                                                            <td>{{$detail->product_narration}}</td>
                                                            <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                                                            <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="text-right">
                                        {{-- <button class="btn btn-info text-white" data-toggle="modal" data-target=".updateSalePurchase" onclick="editResource('{{ route('salePurchase.edit', $sale_purchase_voucher->salePurchaseID) }}','.updateModalSalePurchase')">Update</button> --}}
                                        {{-- <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('salePurchase.destroy', $sale_purchase_voucher->salePurchaseID) }}','{{route('salePurchase.index')}}','delete','Are you sure you want to delete?','');">Delete</button> --}}
                                        <button class="btn btn-info text-white btn-sm" data-toggle="modal" data-target=".updateSalePurchase" onclick="editResource('{{ route('salePurchase.edit', $sale_purchase_voucher->id) }}','.updateModalSalePurchase')">Update</button>
                                        <button class="btn btn-danger btn-sm" onclick="commonFunction(true,'{{ route('salePurchase.destroy', $sale_purchase_voucher->id) }}','{{route('salePurchase.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->


<!--Add subaccount modal start-->

<div class="modal fade addSalePurchase" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable saleParchaseWidth">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sale/Purchase Voucher</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5 scrollModal">
               <div class="form-validation mt-3 mb-5">
                   <form class="form-valide" id="create-form">
                        <div class="row m-0 justify-content-between">
                            <div class="col-6 pl-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-3 col-form-label px-0" for="val-date">Voucher Date<span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" id="val-date" name="date">
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Credit Section Start --}}
                        <div  id="sale_purchase_credit" class="mt-5">
                            <h3>Credit</h3>
                            <div class="row mx-0 justify-content-between pt-3">
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="date" class="form-control" name="credit_dates[]">
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
                                                    <option value="{{$product->title." - ".$product->narration}}">{{$product->title." - ".$product->narration}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="number" name="credit_quantities[]"  class="form-control" oninput="createAmount(this , true)">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="credit_rates[]"  class="form-control" oninput="createAmount(this , false)">
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
                        <div  id="sale_purchase_debit" class="mt-4">
                            <h3>Debit</h3>
                            <div class="row mx-0 justify-content-between pt-3">
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="date" class="form-control" name="debit_dates[]">
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
                                                    <option value="{{$product->title." - ".$product->narration}}">{{$product->title." - ".$product->narration}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="number" name="debit_quantities[]"  class="form-control" oninput="createAmount(this , true)">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="debit_rates[]"  class="form-control" oninput="createAmount(this , false)">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="debit_amounts[]" class="form-control commonDebit" readonly oninput="totalDebitAmount(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-right pl-2 mt-3">
                            <button onclick="addNewRow(this,'#sale_purchase_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                        </div>
                        {{-- Debit Section end --}}

                        <div class="row m-0 justify-content-between align-items-end mt-5">
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
                                        <input type="date" class="form-control" name="suspense_date">
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

                        <div class="row m-0 justify-content-between align-items-end mt-5">
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
                   </form>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('salePurchase.store') }}','{{route('salePurchase.index')}}','post','','create-form') ">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add Product modal start-->


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



    const addNewRow=(elem,id, side , commonClass)=>{
        $(elem).parent().parent().find(id).append(`
            <div class="row mt-3 mx-0 justify-content-between position-relative w-100">
                <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="date" class="form-control" name="${side}dates[]">
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
                                        <option value="{{$product->title." - ".$product->narration}}">{{$product->title." - ".$product->narration}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="number" name="${side}quantities[]"  class="form-control" oninput="createAmount(this , true)">
                            </div>
                        </div>
                    </div>

                    <div class="col-2 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="number" name="${side}rates[]"  class="form-control" oninput="createAmount(this , false)">
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

                <div class="position-absolute" style="right:-44px; top:3px;">
                    <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white">x</button>
                </div>

            </div>

        `);
    }



const totalDebitAmount=(e)=>{
    // Total Debit Amount
    let totalDebit = 0;
    let allDebitAmount = document.getElementsByClassName('commonDebit')
    for(let singleDebit of allDebitAmount){
        totalDebit += +singleDebit.value;
    }
    let targetElem =  $(e).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
    targetElem.val(totalDebit);
    return targetElem.val();
}


const totalCreditAmount=(e)=>{
    // Total Credit Amount
    let totalCredit = 0;
    let allCreditAmmount = document.getElementsByClassName('commonCredit')
    for(let singleCredit of allCreditAmmount){
        totalCredit += +singleCredit.value;
    }
    let targetElem = $(e).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
    targetElem.val(totalCredit);
    return targetElem.val();
}

const totalShouldSame = (elem)=>{
    if($(elem).parent().parent().parent().parent().parent().parent().find('input[id="checkedEntery"]').is(":checked")){
        let totalDebit = getTotalOfTargetSide('commonDebit');
        let totalCredit = getTotalOfTargetSide('commonCredit');
        if((totalDebit-totalCredit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]');
            targetElem.val(parseInt(targetElem.val()) + (totalDebit-totalCredit));
        }
        else if((totalCredit-totalDebit)>0){
            let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]');
            targetElem.val(parseInt(targetElem.val()) + (totalCredit-totalDebit));
        }
    }
}

const getTotalOfTargetSide=(targetClass)=>{
    let total = 0;
    let allAmount = document.getElementsByClassName(targetClass);
    for(let single of allAmount){
        total += +single.value;
    }
    return total;
}


const createAmount = (e, action)=>{
    if (action) {
        if($(e).parent().parent().parent().next('div').children('div').children('div').children('input').val() >= 0){
            let elem = $(e).parent().parent().parent().next('div').children('div').children('div').children('input');
            let amount = elem.parent().parent().parent().next('div').children('div').children('div').children('input');
            if ($(e).val() >=0 && elem.val()>=0) {
                amount.val($(e).val() * elem.val());
            }
        }
    }else{
        if($(e).parent().parent().parent().prev('div').children('div').children('div').children('input').val() >= 0){
            let elem = $(e).parent().parent().parent().prev('div').children('div').children('div').children('input');
            let amount = $(e).parent().parent().parent().next('div').children('div').children('div').children('input');
            if ($(e).val() >=0 && elem.val()>=0) {
                amount.val($(e).val() * elem.val());
            }
        }

    }
    // $(e).attr('name').split('_')[0] =="debit"? totalDebitAmount(e) :totalCreditAmount(e);
    // totalDebitAmount(e);
    // totalCreditAmount(e);
    // let totalDebit = $(e).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]').val();
    // let totalCredit = $(e).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]').val();
    let totalDebit = totalDebitAmount(e);
    let totalCredit = totalCreditAmount(e);
    let differenceBetweenDebitCredit = 0;
    let labelTxt = "Difference";
    let entryTxt = "";
    if((totalDebit-totalCredit)>0){
        differenceBetweenDebitCredit = (totalDebit-totalCredit);
        labelTxt = "Credit";
        entryTxt ="credit";
    }
    else if((totalCredit-totalDebit)>0){
        differenceBetweenDebitCredit = (totalCredit-totalDebit);
        labelTxt = "Debit";
        entryTxt ="debit";
    }else if((totalCredit-totalDebit)==0){
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').text(labelTxt);
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(0);
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').addClass('d-none');
        $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').addClass('d-none');
        totalShouldSame(e);
        return false;
    }

    $(e).parent().parent().parent().parent().parent().parent().find('.differenceLabel').html("<b>"+labelTxt+"</b> difference of "+"<b>"+differenceBetweenDebitCredit+"</b> do you want to adjust?");
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_amount').val(differenceBetweenDebitCredit);
    $(e).parent().parent().parent().parent().parent().parent().find('#suspense_entry').val(entryTxt);
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceRow').removeClass('d-none');
    $(e).parent().parent().parent().parent().parent().parent().find('.differenceEntryCheck').removeClass('d-none');
    totalShouldSame(e);
    console.log("createAmount");

}

const commonCodeForSuspenseEntry = (elem,targetAction)=>{
    console.log("commonCodeForSuspenseEntry");
    let differenceBetweenDebitCredit = parseInt($(elem).parent().parent().parent().parent().parent().parent().find('input[id="differenceInput"]').val());
    let suspenseEntryType = $(elem).parent().parent().parent().parent().parent().parent().find('input[id="suspense_entry"]').val();
    let targetSide = suspenseEntryType=="debit"?'debit-amount':'credit-amount';
    let targetClassForTotal = suspenseEntryType=="debit"?'commonDebit':'commonCredit';
    let targetElem = $(elem).parent().parent().parent().parent().parent().parent().find(`input[id="${targetSide}"]`);
    let targetElemVal = parseInt(targetElem.val());
    targetAction=="add"? (targetElem.val(targetElemVal + differenceBetweenDebitCredit)) : (targetElem.val(targetElemVal - differenceBetweenDebitCredit));
    differenceInputRevertVal =  targetAction!="add"? parseInt($(elem).parent().parent().parent().parent().parent().parent().find('#suspense_amount').val()):0;
    if(targetAction!="add")
    {
        let targetRevertElem = suspenseEntryType=="debit"?'debit-amount':'credit-amount';
        $(elem).parent().parent().parent().parent().parent().parent().find(`input[id="${targetRevertElem}"]`).val(getTotalOfTargetSide(targetClassForTotal));
    }
    $(elem).parent().parent().parent().parent().parent().parent().find('.differenceInput').val(differenceInputRevertVal);
}

const suspenseAccountEntryVerification = (e)=>{$(e).is(":checked")? commonCodeForSuspenseEntry(e,'add') : commonCodeForSuspenseEntry(e,'minus'); }


</script>


@endsection

