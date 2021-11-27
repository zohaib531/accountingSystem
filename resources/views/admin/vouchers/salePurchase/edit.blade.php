<div class="modal-header">
    <h5 class="modal-title">Update Sale/Purchase Voucher</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
    </button>
</div>


    <div class="modal-body px-5 scrollModal">
        <div class="form-validation my-5">
            <form class="form-valide" id="update-form">
                @csrf
                @method('put')
                <div class="row m-0 justify-content-between">
                    <div class="col-6 pl-0">
                        <div class="form-group row m-0 align-items-center">
                            <label class="col-lg-3 col-form-label px-0" for="val-date">Voucher Date<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" id="val-date" name="date" value="{{$voucher->date}}">
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
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    @if($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get()->count() > 0)
                        @foreach($voucher->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->get() as $detail)
                        
                            <div class="row mx-0 justify-content-between pt-3">
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                         <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="date" class="form-control" name="credit_dates[]" value="{{$detail->date}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                         <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="credit_accounts[]" class="form-control">
                                                <option selected value="">Sub account</option>
                                                @foreach ($subAccounts as $subAccount)
                                                    <option @if($subAccount->id==$detail->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                         <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="credit_products[]" class="form-control">
                                                <option selected value="">Product</option>
                                                @foreach ($products as $product)
                                                    <option @if($detail->product_narration==$product->title." - ".$product->narration) selected @endif value="{{$product->title." - ".$product->narration}}">{{$product->title."-".$product->narration}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="number" name="credit_quantities[]"  class="form-control" oninput="createAmount(this , true)" value="{{$detail->quantity}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="credit_rates[]"  class="form-control" oninput="createAmount(this , false)" value="{{$detail->rate}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="credit_amounts[]" class="form-control commonCredit" readonly oninput="totalCreditAmount(this)" value="{{$detail->credit_amount}}">
                                        </div>
                                    </div>
                                </div>

                                @if($loop->iteration!=1)
                                    <div class="position-absolute" style="right:-44px;">
                                        <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white">x</button>
                                    </div>
                                @endif
                            </div>

                        @endforeach
                    @endif
                    
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
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Quantity<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Rate<span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col-2 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    @if($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get()->count() > 0)
                        @foreach($voucher->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->get() as $detail)
                        
                            <div class="row mx-0 justify-content-between pt-3">
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                         <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="date" class="form-control" name="debit_dates[]" value="{{$detail->date}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                         <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="debit_accounts[]" class="form-control">
                                                <option selected value="">Sub account</option>
                                                @foreach ($subAccounts as $subAccount)
                                                    <option @if($subAccount->id==$detail->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                         <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <select name="debit_products[]" class="form-control">
                                                <option selected value="">Product</option>
                                                @foreach ($products as $product)
                                                    <option @if($detail->product_narration==$product->title." - ".$product->narration) selected @endif value="{{$product->title." - ".$product->narration}}">{{$product->title."-".$product->narration}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2">
                                            <input type="number" name="debit_quantities[]"  class="form-control" oninput="createAmount(this , true)" value="{{$detail->quantity}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="debit_rates[]"  class="form-control" oninput="createAmount(this , false)" value="{{$detail->rate}}">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-2 px-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <label></label>
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="number" name="debit_amounts[]" class="form-control commonCredit" readonly oninput="totalCreditAmount(this)" value="{{$detail->debit_amount}}">
                                        </div>
                                    </div>
                                </div>

                                @if($loop->iteration!=1)
                                    <div class="position-absolute" style="right:-44px;">
                                        <button type="button" onclick="removeParentElement(this)" class="btn btn-danger text-white">x</button>
                                    </div>
                                @endif
                            </div>

                        @endforeach
                    @endif

                </div>
                <div class="text-right pl-2 mt-3">
                    <button onclick="addNewRow(this,'#sale_purchase_debit', 'debit_' , 'commonDebit')" class="btn btn-light" type="button">Add more +</button>
                </div>
                {{-- Debit Section end --}}

                @if($voucher->voucherDetails()->where('suspense_account','1')->first() !=null)
                    @php 
                        $suspenseEntry = $voucher->voucherDetails()->where('suspense_account','1')->first();
                        $str = $suspenseEntry->entry_type."_amount"; 
                    @endphp
                    <div class="row m-0 justify-content-between align-items-end mt-5">
                        <div class="col-6 pl-0">
                            <div class="form-group row m-0 align-items-center differenceEntryCheck">
                                <label class="col-lg-9 col-form-label px-0 differenceLabel" for="checkedEntery"><b>{{ucfirst($suspenseEntry->entry_type)}}</b> difference of <b>{{ucfirst($suspenseEntry->$str)}}</b> has been adjusted</label>
                                <div class="col-lg-3 pl-0 pr-2 ">
                                    <div>
                                        <input type="checkbox" class="" checked name="suspense_entry_check" id="checkedEntery" onchange="suspenseAccountEntryVerification(this);">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 px-0">
                            <div class="row m-0">
                                <div class="col-12 pr-0">
                                    <div class="form-group row m-0 align-items-center">
                                        <div class="col-lg-12 pl-0 pr-2 ">
                                            <input type="hidden" class="form-control differenceInput" id="differenceInput" value="{{ucfirst($suspenseEntry->$str)}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row mx-0 justify-content-between pt-3 differenceRow">
                        <input type="hidden" id="suspense_entry" name="suspense_entry">
                        <div class="col-4 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Date<span class="text-danger">*</span></label>
                                <div class="col-lg-12 pl-0 pr-2">
                                    <input type="date" class="form-control" name="suspense_date" value="{{ucfirst($suspenseEntry->date)}}">
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
                                            <option @if($subAccount->id==$suspenseEntry->sub_account_id) selected @endif value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 px-0">
                            <div class="form-group row m-0 align-items-center">
                                <label class="col-lg-12 col-form-label px-0">Amount<span class="text-danger">*</span></label>
                                <div class="col-lg-12 pl-0 pr-2 ">
                                    <input type="number" id="suspense_amount" name="suspense_amount" class="form-control" value="{{ucfirst($suspenseEntry->$str)}}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif  
                <div class="row m-0 justify-content-between align-items-end mt-5">
                    <div class="col-8 px-0"></div>
                    <div class="col-4 px-0">
                        <div class="row m-0">
                            <div class="col-6 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="debit-amount">Total Debit<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2 ">
                                        <input type="number" class="form-control" id="debit-amount" name="total_debit" value="{{$voucher->total_debit}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 pr-0">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="credit-amount">Total Credit<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 pl-0 pr-2 ">
                                        <input type="number" class="form-control" id="credit-amount" name="total_credit" value="{{$voucher->total_credit}}" readonly>
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
        <button type="button" class="btn btn-success" onclick="commonFunction(false,'{{ route('salePurchase.update',$voucher->id) }}','{{route('salePurchase.index')}}','post','','update-form');">Update</button>
     </div>

<script>



</script>
