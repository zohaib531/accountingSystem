@extends('layouts.admin')
@section('title','Create Product')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('categories.create')}}">Create product</a></li>
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
                    <div class="form-validation">
                        <form class="form-valide" id="create-form">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="product-code">Product Code<span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="product-code" name="product_code" placeholder="Enter product code" value="123456" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="product-title">Product title<span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="product-title" name="title" placeholder="Enter a product title..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="product-price">Product price<span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="product-price" name="price" placeholder="Enter a product price..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="product-quantity">Product quantity<span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="product-quantity" name="quantity" placeholder="Enter a product quantity..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="product-descripton">Product descripton<span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <textarea class="form-control" name="descripton" id="product-descripton"  placeholder="Enter a product descripton.."  cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto">
                                    <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('products.store') }}','{{route('products.index')}}','post','','create-form');">Save</button>
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
    <script src="{{asset('assets/template/plugins/validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/validation/jquery.validate-init.js')}}"></script>

@endsection
