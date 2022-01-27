@extends('layouts.admin')
@section('title','Update Journal Voucher')


@section('content')
<script src="{{ asset('assets/template/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/template/plugins/select2/js/select2.full.min.js') }}"></script>
    {{-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{route('journal.index')}}">Update Journal Voucher</a></li>
            </ol>
        </div>
    </div>
    <!-- row --> --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-0">
                <div class="card">
                    <div class="card-body px-4">
                        <form class="form-valide" id="update-form">
                            @csrf
                            @method('put')
                            <div class="row m-0 justify-content-between">
                                <div class="col-4 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label class="col-lg-3 col-form-label px-0" for="update-date">Voucher Date<span class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <input class="form-control editDate" id="update-date" name="date" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $voucher->date)->format('d / m / y')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <h4 class="card-title">Update Journal Voucher</h4>
                                </div>
                                <div class="col-4 text-right">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addsubaccount" onclick="initializeSelect2(), transactionSelect2()">Add Sub account</button>
                                    <button type="button" class="btn btn-danger" onclick="commonFunction(true,'{{ route('journal.destroy', $id) }}','{{route('journal.index')}}','delete','Are you sure you want to delete complete voucher?','');">Delete Voucher</button>
                                </div>
                            </div>
                            <div class="form-validation mb-3">
                                  {{-- Credit Section Start --}}
                                    <div  id="journal_credit" class="mt-3">
                                        <h3>Credit</h3>
                                        <div class="row mx-0 justify-content-between">
                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Date<span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Sub Account<span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Naration<span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Amount<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>

                                        @if($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get()->count() > 0)
                                            @foreach($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get() as $detail)

                                                <div class="row mx-0 justify-content-between mt-2">
                                                    <input type="hidden" name="credit_voucher_detail_ids[]" value="{{$detail->id}}">
                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2">
                                                                <input class="form-control editDate" name="credit_dates[]" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $detail->date)->format('d / m / y')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2">
                                                                <select name="credit_accounts[]" class="form-control updateSearchableSelectCredit{{ $detail->id }} pushSubAccount">
                                                                    <option selected value="">Sub account</option>
                                                                    @foreach ($subAccounts as $subAccount)
                                                                        <option @if($subAccount->id==$detail->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2">
                                                                <input type="text" class="form-control" name="credit_narrations[]" placeholder="Naration.." value="{{$detail->product_narration}}">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                            <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                                <input type="text" name="credit_amounts[]" class="form-control commonCredit" oninput="createAmount(this , false, false)" value="{{$detail->credit_amount}}" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->credit_amount}}" data-common="common" onkeyup="getValue(this)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($loop->iteration!=1)
                                                        <div class="position-absolute" style="right:0px;">
                                                            <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white px-2">x</button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <script>
                                                    $('.updateSearchableSelectCredit{{ $detail->id }}').select2({ dropdownParent: $('.updateSearchableSelectCredit{{ $detail->id }}').parent() });
                                                </script>
                                            @endforeach
                                        @endif

                                    </div>
                                    <div class="text-right pl-2 mt-2">
                                        <button onclick="addNewRow(this,'#journal_credit' , 'credit_' , 'commonCredit')" class="btn btn-light" type="button">Add more +</button>
                                    </div>
                                    {{-- Credit Section end --}}



                                    {{-- Debit Section Start --}}
                                    <div  id="journal_debit">
                                        <h3>Debit</h3>
                                        <div class="row mx-0 justify-content-between">
                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Date<span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Sub Account<span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Naration<span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-3 px-0">
                                                <div class="form-group row m-0 align-items-center">
                                                    <label class="col-lg-12 col-form-label px-0 pb-0">Amount<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        @if($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get()->count() > 0)
                                            @foreach($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get() as $detail)

                                                <div class="row mx-0 justify-content-between mt-2">
                                                    <input type="hidden" name="debit_voucher_detail_ids[]" value="{{$detail->id}}">
                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2">
                                                                <input class="form-control editDate" name="debit_dates[]" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $detail->date)->format('d / m / y')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2">
                                                                <select name="debit_accounts[]" class="form-control updateSearchableSelectDebit{{ $detail->id }} pushSubAccount">
                                                                    <option selected value="">Sub account</option>
                                                                    @foreach ($subAccounts as $subAccount)
                                                                        <option @if($subAccount->id==$detail->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                                <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2">
                                                                <input type="text" class="form-control" name="debit_narrations[]" placeholder="Naration.." value="{{$detail->product_narration}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-3 px-0">
                                                        <div class="form-group row m-0 align-items-center">
                                                            <label></label>
                                                            <div class="col-lg-12 pl-0 pr-2 ">
                                                                <input type="text" name="debit_amounts[]" class="form-control commonDebit" oninput="createAmount(this, false, false)" value="{{$detail->debit_amount}}" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$detail->debit_amount}}" data-common="common" onkeyup="getValue(this)">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($loop->iteration!=1)
                                                        <div class="position-absolute" style="right:0px;">
                                                            <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white px-2">x</button>
                                                        </div>
                                                    @endif

                                                </div>
                                                <script>
                                                    $('.updateSearchableSelectDebit{{ $detail->id }}').select2({ dropdownParent: $('.updateSearchableSelectDebit{{ $detail->id }}').parent() });
                                                </script>
                                            @endforeach
                                        @endif

                                    </div>
                                    <div class="text-right pl-2 mt-2">
                                        <button onclick="addNewRow(this,'#journal_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                                    </div>
                                    {{-- Debit Section end --}}


                                    <div class="row m-0 justify-content-end  mt-3">
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
                                <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('journal.update',$voucher->id) }}','{{route('journal.index')}}','post','','update-form');">Update</button>
                            </div>
                        </form>
                    </div>
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

@endsection

@section('script')

<script>

    let i = 0;
    const addNewRow=(elem, id, side , commonClass)=>{
        ++i;
        $(elem).parent().parent().find(id).append(`
                <div class="row mt-2 mx-0 justify-content-between position-relative w-100">

                        <div class="col-3 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label></label>
                                <div class="col-lg-12 pl-0 pr-2">
                                    <input class="form-control editDate" name="${side}dates[]" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="col-3 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label></label>
                                <div class="col-lg-12 pl-0 pr-2">
                                    <select name="${side}accounts[]" class="form-control updateSearchableSelect${i} pushSubAccount">
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
                                    <input type="text" name="${side}amounts[]" class="form-control ${commonClass}" oninput="createAmount(this , false, false)" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)" value="0">
                                </div>
                            </div>
                        </div>

                    <div class="position-absolute" style="right:-38px;">
                        <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white px-2">x</button>
                    </div>

                </div>

            `);

             // Initialize coma in add more
                defaultScope.ready();
            // Initialize coma in add more

            $('.updateSearchableSelect'+i).select2({ dropdownParent: $('.updateSearchableSelect'+i).parent() });
        }



    $(document).ready(function() {

        $('.updateSearchableSelectCredit').select2({ dropdownParent: $('.updateSearchableSelectCredit').parent() });
        $('.updateSearchableSelectDebit').select2({ dropdownParent: $('.updateSearchableSelectDebit').parent() });
        $('.updateSearchableSelectSuspense').select2({ dropdownParent: $('.updateSearchableSelectSuspense').parent() });
        $('.searchableSelectSubAccount').select2({ dropdownParent: $('.searchableSelectSubAccount').parent() });

    });

function transactionSelect2(){
            $('.searchableSelectTransaction').select2({dropdownParent: $('.searchableSelectTransaction').parent()});
    }

</script>

@endsection


