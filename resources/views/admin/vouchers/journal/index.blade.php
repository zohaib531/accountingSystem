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
                                    <th colspan="2" class="text-center">Details</th>
                                    <th>Total Debit</th>
                                    <th>Total Credit</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($subAccountsDebit) --}}
                                @foreach ($journal_vouchers as $key=> $journalVoucher)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$journalVoucher->date }}</td>
                                    <td colspan="2">
                                        <table class="w-100">
                                            <thead>
                                                <tr>
                                                    <th>Sub Account</th>
                                                    <th>Naration</th>
                                                    <th>Transaction Type</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($journalVoucher->voucherDetails->count()>0)
                                                    @foreach($journalVoucher->voucherDetails as $detail)
                                                        <tr>
                                                            @php $str = $detail->entry_type."_amount";  @endphp
                                                            <td>{{$detail->subAccount->title}}</td>
                                                            <td>{{$detail->narration}}</td>
                                                            <td>{{ucfirst(str_replace('_',' ',$detail->transaction_type))}}</td>
                                                            <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                                                            <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </td>
                                    <td>{{$journalVoucher->total_debit }}</td>
                                    <td>{{$journalVoucher->total_credit }}</td>

                                    <td class="text-right">
                                        <button class="btn btn-info text-white btn-sm" data-toggle="modal" data-target=".updateJournal" onclick="editResource('{{ route('journal.edit', $journalVoucher->id) }}','.updateModalJournal')">Update</button>
                                        <button class="btn btn-danger btn-sm" onclick="commonFunction(true,'{{ route('journal.destroy', $journalVoucher->id) }}','{{route('journal.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
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
                                            <input type="text" class="form-control" id="val-naration" name="narrations[]" placeholder="Naration..">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="transaction_types[]" id="val-transaction-type" class="form-control">
                                                <option selected value="cash">Cash</option>
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
                                            <input type="text" class="form-control" id="val-naration" name="narrations[]" placeholder="Naration..">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="transaction_types[]" id="val-transaction-type" class="form-control">
                                                <option selected value="cash">Cash</option>
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
                                            <input type="text" class="form-control" id="val-naration" name="narrations[]" placeholder="Naration..">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="transaction_types[]" id="val-transaction-type" class="form-control">
                                                <option selected value="cash">Cash</option>
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
