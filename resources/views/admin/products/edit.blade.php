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
        <input type="hidden" name="unique_product" id="productUniqueEdit" value="{{$product->unique_product}}">

        <div class="row m-0">
            <div class="col-7 px-0">
                <div class="form-group row">
                    <label class="col-lg-5 col-form-label px-0" for="product-title-edit">Product Name<span class="text-danger">*</span></label>
                    <div class="col-lg-7 pr-0" style="padding-left: 1.3rem !important;">
                        <input type="text" class="form-control" id="product-title-edit" value="{{$product->title}}" name="title" placeholder="Enter Product Name.." oninput="getUniqueProduct('#product-title-edit', '#product-naration-edit', '#product-unit-edit' , '#productUniqueEdit')">
                    </div>
                </div>
            </div>
            <div class="col-5 pl-0">
                 <div class="form-group row">
                     <label class="col-lg-3 col-form-label px-0 text-right" for="product-unit-edit">Unit<span class="text-danger">*</span></label>
                     <div class="col-lg-9 pr-0 editSelect2Div">
                        <select class="form-control updateSearchableSelect" id="product-unit-edit" name="product_unit" onchange="getUniqueProduct('#product-title-edit', '#product-naration-edit', '#product-unit-edit' , '#productUniqueEdit')">
                            <option value="" disabled>Select Product unit</option>
                            <option value="meter" @if($product->product_unit=='meter') selected @endif>Meter</option>
                            <option value="bags" @if($product->product_unit=='bags') selected @endif>Bags</option>
                            <option value="kgs" @if($product->product_unit=='kgs') selected @endif>Kgs</option>
                            <option value="pounds" @if($product->product_unit=='pounds') selected @endif>Pounds</option>
                        </select>
                     </div>
                 </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3 col-form-label px-0" for="product-naration-edit">Narration<span class="text-danger">*</span></label>
            <div class="col-lg-9">
                <input type="text" class="form-control" id="product-naration-edit" value="{{$product->narration}}" name="narration" placeholder="Enter Narration.." oninput="getUniqueProduct('#product-title-edit', '#product-naration-edit', '#product-unit-edit' , '#productUniqueEdit')">
            </div>
        </div>


    </form>
   </div>
   </div>
<div class="modal-footer">
   <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
   <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('products.update',$product->id) }}','{{route('products.index')}}','post','','update-form');">Update</button>
</div>
