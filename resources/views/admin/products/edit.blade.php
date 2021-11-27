<div class="modal-header">
    <h5 class="modal-title">Update Product</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
    </button>
</div>
<div class="modal-body px-5">
   <div class="form-validation my-5">
    <form class="form-valide" id="update-form">
        @csrf
        @method('put')

        <div class="form-group row">
            <label class="col-lg-3 col-form-label px-0" for="val-title">Product Name<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" class="form-control" id="val-title" value="{{$product->title}}" name="title" placeholder="Enter Product Name..">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 col-form-label px-0" for="val-balance">Narration<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" class="form-control" id="val-balance" value="{{$product->narration}}" name="narration" placeholder="Enter Narration..">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 col-form-label px-0" for="product-unit">Unit<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <select class="form-control" id="product-unit" name="product_unit">
                    <option value="" disabled>Select Product unit</option>
                    <option value="meter" @if($product->product_unit=='meter') selected @endif>Meter</option>
                    <option value="bags" @if($product->product_unit=='bags') selected @endif>Bags</option>
                    <option value="kgs" @if($product->product_unit=='kgs') selected @endif>Kgs</option>
                    <option value="pounds" @if($product->product_unit=='pounds') selected @endif>Pounds</option>
                </select>
            </div>
        </div>



    </form>
   </div>
   </div>
<div class="modal-footer">
   <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('products.update',$product->id) }}','{{route('products.index')}}','post','','update-form');">Update</button>
</div>
