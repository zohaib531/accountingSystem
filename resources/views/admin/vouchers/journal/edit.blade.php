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
        <input type="hidden" value="1" name="voucher_type">

        <input type="hidden" value="1" name="voucher_type">
        <div class="row m-0 justify-content-between">
            <div class="col-5 pl-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-2 col-form-label px-0" for="val-date">Date<span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <input type="date" class="form-control" id="val-date" name="date" value="">
                    </div>
                </div>
            </div>
        </div>


        <div id="editJournal">

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
            <button onclick="addNewRow('#editJournal')" class="btn btn-light" type="button">Add more +</button>
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
   <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('journal.update',$journal_voucher->id) }}','{{route('journal.index')}}','post','','update-form');">Update</button>
</div>
