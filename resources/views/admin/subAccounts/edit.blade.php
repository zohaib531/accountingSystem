<div class="modal-header">
    <h5 class="modal-title">Update Sub Account</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
    </button>
</div>
<div class="modal-body px-5">
   <div class="form-validation my-5">
    <form class="form-valide" id="update-form">
        @csrf
        @method('put')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label" for="val-account">Select Account <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
                <select class="form-control updateSearchableSelect" id="val-account" name="account_id">
                    <option value="" disabled>Please select</option>
                    @foreach ($accounts as $account)
                        <option value="{{$account->id}}" {{$subAccount->account_id==$account->id?'selected':''}}>{{$account->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 col-form-label" for="val-title">Sub account title<span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
                <input type="text" class="form-control" value="{{$subAccount->title}}" id="val-title" name="title" placeholder="Enter sub account..">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 col-form-label" for="opening-balance">Opening Balance<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <div class="row m-0">
                    <div class="col-6 pl-0">
                        <input type="text" class="form-control" id="opening-balance" value="{{number_format($subAccount->opening_balance)}}"  name="opening_balance" placeholder="Enter Opening Balance.."  maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="{{$subAccount->opening_balance}}" data-common="common" onkeyup="getValue(this)">
                    </div>
                    <div class="col-6 pr-0">
                        <select class="form-control updateSearchableSelectTransaction" id="transaction-type" name="transaction_type">
                            <option value="" disabled>Select Debit/Credit</option>
                            <option value="debit" @if($subAccount->transaction_type=='debit') selected @endif >Debit</option>
                            <option value="credit" @if($subAccount->transaction_type=='credit') selected @endif>Credit</option>
                        </select>

                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-lg-3 col-form-label" for="opening-date">Opening Date<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input class="form-control" id="opening-date" value="{{\Carbon\Carbon::createFromFormat('Y-m-d', $subAccount->date)->format('d / m / y')}}" name="opening_date" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);"  autocomplete="off" type="text">
            </div>
        </div>



    </form>
   </div>
   </div>
<div class="modal-footer">
   <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('sub-accounts.update',$subAccount->id) }}','{{route('sub-accounts.index')}}','post','','update-form');">Update</button>
</div>


<script>
    $('.updateSearchableSelectTransaction').select2({dropdownParent: $('.updateSearchableSelectTransaction').parent()});
</script>


