
<div class="modal-header">
    <h5 class="modal-title">Update category</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
    </button>
</div>
<div class="modal-body">
   <div class="form-validation my-5">
       <form class="form-valide" id="update-form">
           @csrf
           @method('put')
           <div class="form-group row">
               <label class="col-lg-2 col-form-label text-right" for="update-category">Category title<span class="text-danger">*</span></label>
               <div class="col-lg-10">
                   <input type="text" class="form-control" id="update-category" value="{{ $category->title }}"  name="title" placeholder="Enter a category title..">
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
   <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('categories.update',$category->id) }}','{{route('categories.index')}}','post','','update-form');">Update</button>
</div>
