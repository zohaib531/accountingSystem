@extends('layouts.admin')
@section('title','Journal Voucher List')

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
            <li class="breadcrumb-item active"><a href="{{route('journal.index')}}">All Journal Voucher</a></li>
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
                            <h4 class="card-title">All Journal Voucher</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addJournal">Add new +</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Naration</th>
                                    <th>Type</th>
                                    <th>Sub Account</th>
                                    <th>Amount</th>
                                    <th>Transaction Type</th>
                                    <th class="text-right w-25">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($subAccountsDebit) --}}
                                @foreach ($journal_vouchers as $key=> $journal_voucher)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$journal_voucher->date }}</td>
                                    <td>{{$journal_voucher->naration }}</td>
                                    <td>
                                        <h5>Debit</h5>
                                        <h5 class="mt-4">Credit</h5>
                                    </td>
                                    <td>
                                        <div>
                                            {{$journal_voucher->get_debit_subaccount->title }}
                                        </div>
                                        <div class="mt-4">
                                            {{$journal_voucher->get_credit_subaccount->title }}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{$journal_voucher->debit_amount}}
                                        </div>
                                        <div class="mt-4">
                                            {{$journal_voucher->credit_amount}}
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            {{ucfirst(str_replace('_', ' ',$journal_voucher->debit_transaction_type))}}
                                        </div>
                                        <div class="mt-4">
                                            {{ucfirst(str_replace('_', ' ',$journal_voucher->credit_transaction_type))}}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-info text-white" data-toggle="modal" data-target=".updateJournal" onclick="editResource('{{ route('journal.edit', $journal_voucher->id) }}','.updateModalJournal')">Update</button>
                                        <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('journal.destroy', $journal_voucher->id) }}','{{route('journal.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
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

<div class="modal fade addJournal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg saleParchaseWidth">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Journal Voucher</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
               <div class="form-validation my-5">
                   <form class="form-valide" id="create-form">
                       <input type="hidden" value="1" name="voucher_type">
                        <div class="row m-0 justify-content-between">
                            <div class="col-5 pl-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-2 col-form-label px-0" for="val-date">Date<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input type="date" class="form-control" id="val-date" name="date">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div id="journalMain">

                            <div class="row mx-0 justify-content-between pt-5">
                                <div class="col-3 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0" for="val-account">Select Sub Account<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="accounts[]" id="val-account" class="form-control">
                                                <option selected disabled>Select sub account</option>
                                                @foreach ($subAccounts as $subAccount)
                                                    <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0" for="val-naration">Naration<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="text" class="form-control" id="val-naration" name="naration" placeholder="Naration..">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="transaction_types" id="val-transaction-type" class="form-control">
                                                <option selected disabled>Transaction type</option>
                                                <option value="cash">Cash</option>
                                                <option value="check">Check</option>
                                                <option value="bank_transfer">Bank transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Debit<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" class="form-control commonDebit" oninput="disableCreditInput(this)" name="debits[]" placeholder="Debit...">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0">Credit<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" class="form-control commonCredit" oninput="disableDebitInput(this)" name="credits[]" placeholder="Credit...">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row mx-0 justify-content-between pt-3">
                                <div class="col-3 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="accounts[]" id="val-account" class="form-control">
                                                <option selected disabled>Select sub account</option>
                                                @foreach ($subAccounts as $subAccount)
                                                    <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="text" class="form-control" id="val-naration" name="naration" placeholder="Naration..">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="transaction_types" id="val-transaction-type" class="form-control">
                                                <option selected disabled>Transaction type</option>
                                                <option value="cash">Cash</option>
                                                <option value="check">Check</option>
                                                <option value="bank_transfer">Bank transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" class="form-control commonDebit" oninput="disableCreditInput(this)" name="debits[]" placeholder="Debit...">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" class="form-control commonCredit" oninput="disableDebitInput(this)" name="credits[]" placeholder="Credit...">
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>



                        <div class="text-right pr-2 mt-3">
                            <button onclick="addNewRow('#journalMain')" class="btn btn-light" type="button">Add more +</button>
                        </div>


                        <div class="row m-0 justify-content-end  mt-5">
                            <div class="col-4 px-0">
                                <div class="row m-0">
                                    <div class="col-6 pr-0">
                                        <div class="form-group row m-0 align-items-center">
                                            <label class="col-lg-12 col-form-label px-0" for="debit-amount">Total Debit<span class="text-danger">*</span></label>
                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                <input type="number" class="form-control" id="debit-amount" name="debit_total" value="0" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 pr-0">
                                        <div class="form-group row m-0 align-items-center">
                                            <label class="col-lg-12 col-form-label px-0" for="credit-amount">Total Credit<span class="text-danger">*</span></label>
                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                <input type="number" class="form-control" id="credit-amount" name="credit_total" value="0" readonly>
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
               <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('journal.store') }}','{{route('journal.index')}}','post','','create-form');">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add Product modal start-->


 <!--Update Product modal start-->

 <div class="modal fade updateJournal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg saleParchaseWidth">
        <div class="modal-content updateModalJournal">

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



const addNewRow=(id)=>{
        $(id).append(`
                        <div class="row mt-3 mx-0 justify-content-between position-relative w-100">
                            <div class="col-3 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="accounts[]" id="val-account" class="form-control">
                                                <option selected disabled>Select sub account</option>
                                                @foreach ($subAccounts as $subAccount)
                                                    <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="text" class="form-control" id="val-naration" name="naration" placeholder="Naration..">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="transaction_types" id="val-transaction-type" class="form-control">
                                                <option selected disabled>Transaction type</option>
                                                <option value="cash">Cash</option>
                                                <option value="check">Check</option>
                                                <option value="bank_transfer">Bank transfer</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" class="form-control commonDebit" oninput="disableCreditInput(this)" name="debits[]" placeholder="Debit...">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" class="form-control commonCredit" oninput="disableDebitInput(this)" name="credits[]" placeholder="Credit...">
                                        </div>
                                    </div>
                                </div>

                            <div class="position-absolute" style="right:-44px; top:3px;">
                                <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white">x</button>
                            </div>

                        </div>
                    `);
}


</script>


@endsection
