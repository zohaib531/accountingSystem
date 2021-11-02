<div class="modal-header">
    <h5 class="modal-title">Update Sub Category</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
    </button>
</div>
<div class="modal-body px-5">
   <div class="form-validation my-5">
    <form class="form-valide" id="update-form">
        @csrf
        @method('put')
        <div class="form-group row">
            <label class="col-lg-3 col-form-label" for="val-category">Select Category <span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
                <select class="form-control" id="val-category" name="category_id">
                    <option value="" disabled>Please select</option>
                    @foreach ($categories as $cat)
                        <option value="{{$cat->id}}" {{$category->category_id==$cat->id?'selected':''}}>{{$cat->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 col-form-label" for="val-title">Sub category title<span class="text-danger">*</span>
            </label>
            <div class="col-lg-9">
                <input type="text" class="form-control" value="{{$category->title}}" id="val-title" name="title" placeholder="Enter sub category..">
            </div>
        </div>
    </form>
   </div>
   </div>
<div class="modal-footer">
   <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('sub-categories.update',$category->id) }}','{{route('sub-categories.index')}}','post','','update-form');">Update</button>
</div>
