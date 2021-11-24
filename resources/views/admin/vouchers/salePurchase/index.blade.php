@extends('layouts.admin')
@section('title','Sale/Purchase Voucher List')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <style>
        @media (min-width: 992px){
            .saleParchaseWidth {
                max-width: 1000px !important;
            }
        }
    </style>
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
                                                <option selected disabled>Sub account</option>
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
                                                <option selected disabled value="">Product</option>
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
                                            <input type="number" name="credit_quantities[]"  class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="credit_rates[]"  class="form-control">
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
                            <button onclick="addNewRow('#sale_purchase_credit' , 'credit_' , 'commonCredit')" class="btn btn-light" type="button">Add more +</button>
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
                                                <option selected disabled>Sub account</option>
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
                                                <option selected disabled value="">Product</option>
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
                                            <input type="number" name="debit_quantities[]"  class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="debit_rates[]"  class="form-control">
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
                            <button onclick="addNewRow('#sale_purchase_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                        </div>
                        {{-- Debit Section end --}}




                        <div class="row m-0 justify-content-between align-items-end mt-5">
                            <div class="col-2 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-9 col-form-label px-0" for="checkedEntery">End Entery<span class="text-danger">*</span></label>
                                    <div class="col-lg-3 pl-0 pr-2 ">
                                        <div>
                                            <input type="checkbox" class="" name="commitChanges" id="checkedEntery">
                                        </div>
                                    </div>
                                </div>
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



    const addNewRow=(id, side , commonClass)=>{
        $(id).append(`
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
                                                <option selected disabled>Sub account</option>
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
                                                <option selected disabled value="">Product</option>
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
                                            <input type="number" name="${side}quantitys[]"  class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="${side}rates[]"  class="form-control">
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
        let allDebitAmmount = document.getElementsByClassName('commonDebit')
        for(let singleDebit of allDebitAmmount){
            totalDebit += +singleDebit.value;
        }
        // $('#debit-amount').val(totalDebit);
        $(e).parent().parent().parent().parent().parent().parent().find('input[id="debit-amount"]').val(totalDebit);
        // Total Debit Amount
}


const totalCreditAmount=(e)=>{
  // Total Credit Amount
  let totalCredit = 0;
        let allCreditAmmount = document.getElementsByClassName('commonCredit')
        for(let singleCredit of allCreditAmmount){
            totalCredit += +singleCredit.value;
        }

        $(e).parent().parent().parent().parent().parent().parent().find('input[id="credit-amount"]').val(totalCredit);
        // Total Credit Amount
}



</script>


@endsection

