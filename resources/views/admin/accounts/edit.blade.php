
<div class="modal-header">
    <h5 class="modal-title">Update General Account</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
    </button>
</div>
<div class="modal-body px-5">
   <div class="form-validation my-5">
       <form class="form-valide" id="update-form">
           @csrf
           @method('put')
           <div class="form-group row">
               <label class="col-lg-3 col-form-label" for="update-account">Head Account Name<span class="text-danger">*</span></label>
               <div class="col-lg-9">
                   <input type="text" class="form-control" id="update-account" value="{{ $account->title }}"  name="title" placeholder="Enter a head account name..">
               </div>
           </div>
           <div class="form-group row">
               <div class="col-lg-8 ml-auto">
               </div>
           </div>
       </form>
   </div>
   </div>
<div class="modal-footer">
   <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('accounts.update',$account->id) }}','{{route('accounts.index')}}','post','','update-form');">Update</button>
</div>
