<div class="modal-header">
    <h5 class="modal-title">Update Sale/Purchase Voucher</h5>
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
                        <input type="date" class="form-control" id="val-date" value="{{$sale_purchase_voucher->date}}" name="date">
                    </div>
                </div>
            </div>
            <div class="col-5 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-2 col-form-label px-0" for="val-balance">Product<span class="text-danger">*</span></label>
                    <div class="col-lg-10">
                        <select name="product_id" id="val-balance" class="form-control">
                            <option selected disabled>Please select product</option>
                            @foreach ($products as $product)
                                <option value="{{$product->id}}" {{$product->id == $sale_purchase_voucher->product_id? 'selected':''}}>{{$product->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Debit Code Start --}}
        <div>
            <h3 class="mt-4 mb-3">Debit</h3>
        </div>

        <div class="row m-0 justify-content-between">
            <div class="col-3 px-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-account">Select Account<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <select name="debit_account" id="val-account" class="form-control">
                            <option disabled>Please select account</option>
                            @foreach ($accounts as $account)
                                <option value="{{$account->id}}" {{$account->id == $sale_purchase_voucher->debit_account? 'selected':''}}>{{$account->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-2 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-quantity">Quantity<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <input type="number" class="form-control" id="val-quantity" value="{{$sale_purchase_voucher->debit_quantity}}" name="debit_quantity" placeholder="Enter Quantity...">
                    </div>
                </div>
            </div>
            <div class="col-2 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-rate">Rate<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <input type="number" class="form-control" id="val-rate" value="{{$sale_purchase_voucher->debit_rate}}" name="debit_rate" placeholder="Enter Rate...">
                    </div>
                </div>
            </div>
            <div class="col-2 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-amount">Amount<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2 ">
                        <input type="number" class="form-control" id="val-amount" value="{{$sale_purchase_voucher->debit_amount}}" name="debit_amount"  placeholder="Enter Amount...">
                    </div>
                </div>
            </div>
            <div class="col-3 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <select name="debit_transaction_type" id="val-transaction-type" class="form-control">
                            <option selected disabled>Please select transaction type</option>
                            <option value="abc">abc</option>
                            <option value="abc1" selected>abc1</option>
                            <option value="abc2">abc2</option>
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
            <div class="col-3 px-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-account">Select Account<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <select name="credit_account" id="val-account" class="form-control">
                            <option selected disabled>Please select account</option>
                            @foreach ($accounts as $account)
                                <option value="{{$account->id}}" {{$account->id == $sale_purchase_voucher->credit_account? 'selected':''}}>{{$account->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-2 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-quantity">Quantity<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <input type="number" class="form-control" id="val-quantity" value="{{$sale_purchase_voucher->credit_quantity}}" name="credit_quantity" placeholder="Enter Quantity...">
                    </div>
                </div>
            </div>
            <div class="col-2 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-rate">Rate<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <input type="number" class="form-control" id="val-rate" value="{{$sale_purchase_voucher->credit_rate}}"   name="credit_rate" placeholder="Enter Rate...">
                    </div>
                </div>
            </div>
            <div class="col-2 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-amount">Amount<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2 ">
                        <input type="number" class="form-control" id="val-amount" value="{{$sale_purchase_voucher->credit_amount}}" name="credit_amount" placeholder="Enter Amount...">
                    </div>
                </div>
            </div>
            <div class="col-3 pr-0">
                <div class="form-group row m-0 align-items-center">
                    <label class="col-lg-12 col-form-label px-0" for="val-transaction-type">Transaction Type<span class="text-danger">*</span></label>
                    <div class="col-lg-12 pl-0 pr-2">
                        <select name="credit_transaction_type" id="val-transaction-type" class="form-control">
                            <option selected disabled>Please select transaction type</option>
                            <option value="abc">abc</option>
                            <option value="abc1" selected>abc1</option>
                            <option value="abc2">abc2</option>
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
   <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('salePurchase.update',$sale_purchase_voucher->id) }}','{{route('salePurchase.index')}}','post','','update-form');">Update</button>
</div>
