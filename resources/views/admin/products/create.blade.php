@extends('layouts.admin')
@section('title', 'Create Product')
@section('content')



    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('categories.create') }}">Create product</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Create product</h4>
                        <div class="form-validation row justify-content-center">
                            <form class="form-valide col-6" id="create-form">

                                {{-- <div class="col-form-label" >Select Category & Sub category <span class="text-danger">*</span></div> --}}
                                <div class="text-right">
                                    <button type="button" class="btn btn-primary d-none" id="addModal" data-toggle="modal"
                                        data-target=".addcategrory_subcategory">Add Category & Sub category</button>
                                </div>
                                {{-- <div>
                                <label class="col-form-label " for="val-category">Select Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="val-category" name="category_id" onchange="categoryChange(this)">
                                    <option value="" disabled selected>Please select</option>

                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" data-code="{{str_pad($category->code, 2, '0', STR_PAD_LEFT)}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="col-form-label " for="val-sub_category">Select sub category <span class="text-danger">*</span></label>
                                <select class="form-control" id="val-sub_category" name="sub_category_id" onchange="subCategoryChange(this)">
                                    <option value="" disabled selected>Please select</option>
                                </select>
                            </div> --}}


                                <!--Add category and subcategory modal start-->
                                <div class="modal fade addcategrory_subcategory" tabindex="-1" role="dialog"
                                    aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Category & Sub Category</h5>
                                            </div>
                                            <div class="modal-body px-5">
                                                <div class="form-validation my-5">
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-lg-3" for="val-category">Select
                                                            Category <span class="text-danger">*</span></label>
                                                        <div class="col-lg-9">
                                                            <select class="form-control" class="select_2"
                                                                id="val-category" name="category_id"
                                                                onchange="categoryChange(this); selectedValue('val-category','val-sub_category')">
                                                                <option value="" disabled selected>Please select</option>

                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}"
                                                                        data-code="{{ str_pad($category->code, 2, '0', STR_PAD_LEFT) }}">
                                                                        {{ $category->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-lg-3" for="val-sub_category">Select
                                                            sub category <span class="text-danger">*</span></label>
                                                        <div class="col-lg-9">
                                                            <select class="form-control" id="val-sub_category"
                                                                name="sub_category_id"
                                                                onchange="subCategoryChange(this); selectedValue('val-category','val-sub_category')">
                                                                <option value="" disabled selected>Please select</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary text-white" id="saveBtn"
                                                    disabled data-dismiss="modal">Save</button>
                                                {{-- <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('sub-categories.store') }}','{{route('sub-categories.index')}}','post','','create-form');">Save</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Add category and subcategory modal end-->



                                <div class="form-group">
                                    <label class="col-form-label" for="product-code">Product code<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <input type="number" class="form-control" id="product-code" name="product_code"
                                            placeholder="00000000" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="product-title">Product title<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="product-title" name="title"
                                            placeholder="Enter a product title..">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="product-price">Product price<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <input type="number" class="form-control" id="product-price" name="price"
                                            placeholder="Enter a product price..">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="product-quantity">Product quantity<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <input type="number" class="form-control" id="product-quantity" name="quantity"
                                            placeholder="Enter a product quantity..">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group" style="margin-bottom: 5px !important;">
                                        <label for="InputFile" class="col-form-label">Upload Image<span
                                                class="text-danger">*</span></label>
                                        <div>
                                            <input type="hidden" id="uploaded-file" name="image" value="">
                                            <input type="hidden" id="upload_path" name="upload_path"
                                                value="admin/uploads/products">
                                            <input type="file" name="file" id="InputFile"
                                                onchange="uploadFile($('#InputFile'))" accept=".jpg,.jpeg,.png,.gif">
                                        </div>
                                    </div>

                                    <div class="form-group" style="width: 300px;">
                                        <div class="progress d-none" style="margin-bottom: 2px;">
                                            <div class="progress-bar progress-bar-success myprogress" role="progressbar"
                                                style="width:0%">0%</div>
                                        </div>
                                        <div class="msg"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label" for="product-variation">Product Variation<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <input type="checkbox" name="variation" id="product-variation" value="1" />
                                    </div>
                                </div>
                                <div class="form-group variation_show w-100" id="variation_show" style="display: none">
                                    <div class="multiselect-dropdown">
                                        <label for="">Color</label>
                                        <select name='colors[]' id='colors' class=" select_2 w-100 js-states " multiple
                                            onchange="ProductsVariation()">
                                            <option value="Green">Green</option>
                                            <option value="blue">blue</option>
                                            <option value="red">red</option>
                                            <option value="Black">Black</option>

                                        </select>
                                    </div>
                                    <div class="multiselect-dropdown">
                                        <label for="">Size</label>

                                        <select name='size[]' id='size' class=" select_2  w-100 js-states " multiple
                                            onchange="ProductsVariation()">
                                            <option value="sm">small</option>
                                            <option value="md">medium</option>
                                            <option value="lg">large</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <td>Color</td>
                                                    <td>size</td>
                                                    <td>image</td>
                                                    <td>price</td>
                                                    <td>qty</td>
                                                </tr>
                                            </thead>
                                            <tbody id="variationjoints">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label" for="product-descripton">Product descripton<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <textarea class="form-control" name="description" id="product-descripton"
                                            placeholder="Enter a product descripton.." cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="button" class="btn btn-primary"
                                            onclick="commonFunction(false,'{{ route('products.store') }}','{{ route('products.index') }}','post','','create-form');">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->



@endsection

@section('script')
    <script src="{{ asset('assets/template/plugins/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/template/plugins/validation/jquery.validate-init.js') }}"></script>


    <script>
        // $("#single").select2({
        //     placeholder: "Select a programming language",
        //     allowClear: true
        // });
        $(".select_2").select2({

            allowClear: true
        });
        // upload file using ajax with progress bar
        function uploadFile(id) {
            $('.myprogress').css('width', '0');
            $('.msg').text('');
            var formData = new FormData();
            formData.append('file', id[0].files[0]);
            formData.append('upload_path', $('#upload_path').val());
            formData.append('_token', '{{ csrf_token() }}');
            $('.msg').text('Uploading in progress...');
            $.ajax({
                url: "{{ route('uploadFile') }}",
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                // this part is progress bar
                xhr: function() {
                    $('.submit').addClass('disabled');
                    $('.progress').removeClass('d-none');
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.myprogress').text(percentComplete + '%');
                            $('.myprogress').css('width', percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                success: function(data) {
                    if (data.status = true) {
                        $('.submit').removeClass('disabled');
                        $('.progress-bar').css('background-color', '#3ac574');
                        $('#previewImg').attr('src', data.path);
                        $('.msg').text('Uploading complete');
                        $('#uploaded-file').val(data.path);
                    }
                }
            });
        }

        // Declearing Variables
        let getCategory_code, subCategory_code, getProduct_code = 0

        // Function for setting Sub catrgory with change in category
        const categoryChange = (e) => {
            getCategory_code = $(e).find('option:selected').data('code');

            $('#val-sub_category').empty();
            $('#val-sub_category').append('<option  disabled selected>Please select</option>')
            var subCategory = {!! $sub_categories !!}
            for (let singleItem of subCategory) {
                if (e.value == singleItem.category_id) {
                    let subCategoryCode = ("0" + singleItem.code).slice(-2);
                    $('#val-sub_category').append('<option value=' + singleItem.id + ' data-code=' + subCategoryCode +
                        '>' + singleItem.title + '</option>')
                }
            }

            $('#product-code').val('00000000')

        }

        const subCategoryChange = (e) => {
            subCategory_code = $(e).find('option:selected').data('code');
            var pCodeBackend = {!! $productCode !!}
            $('#product-code').val(getCategory_code + subCategory_code + String(pCodeBackend).padStart(4, '0'))
        }


        const selectedValue = (tagId, secondTagId) => {
            if ($('#' + tagId).val() != null && $('#' + secondTagId).val() != null) {

                $('#saveBtn').removeAttr('disabled')
            }
        }


        window.onload = (event) => {
            $('#addModal').click()
        }
        $('#product-variation').on('click', function() {

            // Check
            
            var value=$("#product-variation").val();
            if (value) {

                $(".variation_show").toggle("checkVariationDisplay");
            }
         
             

        })

        function ProductsVariation() {
            var size = $('#size').val();
            var colors = $('#colors').val();
            var p_price = $('#product-price').val();
            console.log(colors, size, p_price)
            variationjoints.innerHTML = ``;
            for (var i = 0; i < colors.length; i++) {
                for (var j = 0; j < size.length; j++) {

                    variationjoints.innerHTML += `
                    <tr>
                    <td><input type='text' name='variation_color[]' value='${colors[i]}' class='variation_style checked_val'/></td>
                    <td><input type='text' name='variation_size[]' value='${size[j]}' class='variation_style checked_val'/></td>
                    <td><input type='file' name='variation_img[]' required  class='variation_style_only_img checked_val' /></td>
                    <td><input type='number' name='variation_price[]' required class='form-control checked_val'/></td>
                    <td><input type='number' name='variation_qty[]' required class='form-control checked_val'/></td>
                    <td ><button class='btn btn-danger' onclick="removeRow(this)">&#9986;</button></td>
                    </tr>
                    `;
                }
            }
        }

        removeRow = function(el) {
            $(el).parents("tr").remove()
        }
    </script>

@endsection
