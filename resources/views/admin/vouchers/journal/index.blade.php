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
                                    <th>Debit Account</th>
                                    <th>Debit Amount</th>
                                    <th>Credit Account</th>
                                    <th>Credit Amount</th>
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
                                    <td>{{$journal_voucher->get_debit_subaccount->title }}</td>
                                    <td>{{$journal_voucher->debit_amount}}</td>
                                    <td>{{$journal_voucher->get_credit_subaccount->title }}</td>
                                    <td>{{$journal_voucher->credit_amount}}</td>
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
                        <div class="row m-0 justify-content-between">
                            <div class="col-5 pl-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-2 col-form-label px-0" for="val-date">Date<span class="text-danger">*</span></label>
                                    <div class="col-lg-10">
                                        <input type="date" class="form-control" id="val-date" name="date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-5 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-2 col-form-label px-0" for="val-naration">Naration<span class="text-danger">*</span></label>
                                    <div class="col-lg-10 pr-2">
                                        <input type="text" class="form-control" id="val-naration" name="naration" placeholder="Enter Naration..">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Debit Code Start --}}
                        <div>
                            <h3 class="mt-4 mb-3">Debit</h3>
                        </div>

                        <div class="row m-0 justify-content-between">
                            <div class="col-4 px-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-account">Select Sub Account<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2">
                                        <select name="debit_account_id" id="val-account" class="form-control">
                                            <option selected disabled>Please select sub account</option>
                                            @foreach ($subAccounts as $subAccount)
                                                <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-amount">Amount<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2 ">
                                        <input type="number" class="form-control" id="val-amount" name="debit_amount" placeholder="Enter Amount...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2">
                                        <select name="debit_transaction_type" id="val-transaction-type" class="form-control">
                                            <option selected disabled>Please select transaction type</option>
                                            <option value="cash">Cash</option>
                                            <option value="check">Check</option>
                                            <option value="bank_transfer">Bank transfer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-right pr-2 mt-3">
                            <button onclick="addNewDebit()" class="btn btn-light" type="button">Add more +</button>
                        </div>
                        {{-- Debit Code end --}}




                        {{-- Credit Code Start --}}
                        <div>
                            <h3 class="mt-5 mb-3">Credit</h3>
                        </div>

                        <div class="row m-0 justify-content-between">
                            <div class="col-4 px-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-account">Select Sub Account<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2">
                                        <select name="credit_account_id" id="val-account" class="form-control">
                                            <option selected disabled>Please select sub account</option>
                                            @foreach ($subAccounts as $subAccount)
                                                <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-amount">Amount<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2 ">
                                        <input type="number" class="form-control" id="val-amount" name="credit_amount" placeholder="Enter Amount...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2">
                                        <select name="credit_transaction_type" id="val-transaction-type" class="form-control">
                                            <option selected disabled>Please select transaction type</option>
                                            <option value="cash">Cash</option>
                                            <option value="check">Check</option>
                                            <option value="bank_transfer">Bank transfer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="text-right pr-2 mt-3">
                            <button onclick="addNewCredit()" class="btn btn-light" type="button">Add more +</button>
                        </div>
                        {{-- Credit Code end --}}

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
    <div class="modal-dialog modal-lg">
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
// setting current date code Start
$(document).ready(function() {
    var today = new Date().toISOString().split('T')[0];
    $('#val-date').val(today);
})

// setting current date code end

</script>


@endsection
