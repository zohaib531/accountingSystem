<div class="modal-header">
    <h5 class="modal-title">Update Journal Voucher</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
    </button>
</div>
<div class="modal-body px-5">
   <div class="form-validation my-5">
    <form class="form-valide" id="update-form">
        @csrf
        @method('put')

        <div class="row m-0 justify-content-between">
            <div class="col-5 pl-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-2 col-form-label px-0" for="val-date">Date<span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="date" class="form-control" id="val-date" value="{{$journal_voucher->date}}" name="date">
                    </div>
                </div>
            </div>
            <div class="col-5 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-2 col-form-label px-0" for="val-naration">Naration<span class="text-danger">*</span></label>
                    <div class="col-lg-10 pr-2">
                        <input type="text" class="form-control" id="val-naration" value="{{$journal_voucher->naration}}" name="naration" placeholder="Enter Naration..">
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
                            <option disabled>Please select sub account</option>
                            @foreach ($subAccounts as $subAccount)
                                <option value="{{$subAccount->id}}" {{$subAccount->id == $journal_voucher->debit_account_id? 'selected':''}}>{{$subAccount->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-amount">Amount<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2 ">
                        <input type="number" class="form-control" id="val-amount" value="{{$journal_voucher->debit_amount}}" name="debit_amount"  placeholder="Enter Amount...">
                    </div>
                </div>
            </div>
            <div class="col-4 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <select name="debit_transaction_type" id="val-transaction-type" class="form-control">
                            <option disabled>Please select transaction type</option>
                            <option value="cash" {{$journal_voucher->debit_transaction_type == 'cash'?'selected':''}}>Cash</option>
                            <option value="check" {{$journal_voucher->debit_transaction_type == 'check'?'selected':''}}>Check</option>
                            <option value="bank_transfer" {{$journal_voucher->debit_transaction_type == 'bank_transfer'?'selected':''}}>Bank transfer</option>
                        </select>
                    </div>
                </div>
            </div>
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
                            <option disabled>Please select sub account</option>
                            @foreach ($subAccounts as $subAccount)
                                <option value="{{$subAccount->id}}" {{$subAccount->id == $journal_voucher->credit_account_id? 'selected':''}}>{{$subAccount->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-amount">Amount<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2 ">
                        <input type="number" class="form-control" id="val-amount" value="{{$journal_voucher->credit_amount}}" name="credit_amount" placeholder="Enter Amount...">
                    </div>
                </div>
            </div>
            <div class="col-4 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <select name="credit_transaction_type" id="val-transaction-type" class="form-control">
                            <option disabled>Please select transaction type</option>
                            <option value="cash" {{$journal_voucher->credit_transaction_type == 'cash'?'selected':''}}>Cash</option>
                            <option value="check" {{$journal_voucher->credit_transaction_type == 'check'?'selected':''}}>Check</option>
                            <option value="bank_transfer" {{$journal_voucher->credit_transaction_type == 'bank_transfer'?'selected':''}}>Bank transfer</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {{-- Credit Code end --}}




    </form>
   </div>
   </div>
<div class="modal-footer">
   <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('journal.update',$journal_voucher->id) }}','{{route('journal.index')}}','post','','update-form');">Update</button>
</div>
