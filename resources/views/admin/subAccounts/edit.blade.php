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
                <select class="form-control" id="val-account" name="account_id">
                    <option value="" disabled>Please select</option>
                    @foreach ($accounts as $account)
                        <option value="{{$account->id}}" {{$account->account_id==$account->id?'selected':''}}>{{$account->title}}</option>
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
            <label class="col-lg-3 col-form-label" for="val-balance">Opening Balance<span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
                <input type="number" class="form-control" value="{{$subAccount->opening_balance}}" id="val-balance" name="opening_balance" placeholder="Enter Opening Balance..">
            </div>
        </div>



    </form>
   </div>
   </div>
<div class="modal-footer">
   <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('sub-accounts.update',$subAccount->id) }}','{{route('sub-accounts.index')}}','post','','update-form');">Update</button>
</div>
