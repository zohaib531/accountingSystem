@extends('layouts.admin')
@section('title','Journal Voucher List')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
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
                                                            <td>{{$detail->product_narration}}</td>
                                                            <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                                                            <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <td colspan="2"><h5 class="text-center">Total</h5></td>
                                                <td>{{$journalVoucher->total_debit}}</td>
                                                <td>{{$journalVoucher->total_credit}}</td>
                                            </tfoot>
                                        </table>
                                    </td>

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
            <div class="modal-body px-5 scrollModal">
                <div class="form-validation mt-3 mb-5">
                    <form class="form-valide" id="create-form">
                         <div class="row m-0 justify-content-between">
                             <div class="col-4 pl-0">
                                 <div class="form-group row m-0 align-items-center">
                                     <label class="col-lg-3 col-form-label px-0" for="val-date">Voucher Date<span class="text-danger">*</span></label>
                                     <div class="col-lg-9">
                                         <input type="date" class="form-control" id="val-date" name="date">
                                     </div>
                                 </div>
                             </div>
                         </div>


                         {{-- Credit Section Start --}}
                         <div  id="journal_credit" class="mt-5">
                             <h3>Credit</h3>
                             <div class="row mx-0 justify-content-between pt-3">
                                 <div class="col-3 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 pl-0 pr-2">
                                             <input type="date" class="form-control" name="credit_dates[]">
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-3 px-0">
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

                                 <div class="col-3 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0" for="credit-naration">Naration<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="text" class="form-control" id="credit-naration" name="credit_narrations[]" placeholder="Naration..">
                                        </div>
                                    </div>
                                 </div>

                                 <div class="col-3 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 pl-0 pr-2 ">
                                             <input type="number" name="credit_amounts[]" class="form-control commonCredit"  oninput="createAmount(this , false, false)">
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="text-right pl-2 mt-3">
                             <button onclick="addNewRow(this,'#journal_credit' , 'credit_' , 'commonCredit')" class="btn btn-light" type="button">Add more +</button>
                         </div>
                         {{-- Credit Section end --}}



                         {{-- Debit Section Start --}}
                         <div  id="journal_debit" class="mt-4">
                             <h3>Debit</h3>
                             <div class="row mx-0 justify-content-between pt-3">
                                 <div class="col-3 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 pl-0 pr-2">
                                             <input type="date" class="form-control" name="debit_dates[]">
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-3 px-0">
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

                                <div class="col-3 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-12 col-form-label px-0" for="debit-naration">Naration<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="text" class="form-control" id="debit-naration" name="debit_narrations[]" placeholder="Naration..">
                                        </div>
                                    </div>
                                </div>


                                 <div class="col-3 px-0">
                                     <div class="form-group row m-0 align-items-center">
                                         <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                         <div class="col-lg-12 pl-0 pr-2 ">
                                             <input type="number" name="debit_amounts[]" class="form-control commonDebit" oninput="createAmount(this, false, false)">
                                         </div>
                                     </div>
                                 </div>

                             </div>

                         </div>
                         <div class="text-right pl-2 mt-3">
                             <button onclick="addNewRow(this,'#journal_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
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



const addNewRow=(elem, id, side , commonClass)=>{
    $(elem).parent().parent().find(id).append(`
            <div class="row mt-3 mx-0 justify-content-between position-relative w-100">

                    <div class="col-3 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="date" class="form-control" name="${side}dates[]">
                            </div>
                        </div>
                    </div>

                    <div class="col-3 px-0">
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

                    <div class="col-3 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2">
                                <input type="text" class="form-control" name="${side}narrations[]" placeholder="Naration..">
                            </div>
                        </div>
                    </div>


                    <div class="col-3 px-0">
                        <div class="form-group row m-0 align-items-center">
                            <label></label>
                            <div class="col-lg-12 pl-0 pr-2 ">
                                <input type="number" name="${side}amounts[]" class="form-control ${commonClass}" oninput="createAmount(this , false, false)">
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
