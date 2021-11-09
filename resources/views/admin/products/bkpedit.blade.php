@extends('layouts.admin')
@section('title','Edit Product')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('categories.create')}}">Update Category</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Update Category</h4>
                    <div class="form-validation">
                        <form class="form-valide" id="update-form">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="val-category">Category title<span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="val-category" name="title" value="{{ $category->title }}" placeholder="Enter a category title..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto">
                                    <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('categories.update',$category->id) }}','{{route('categories.index')}}','post','','update-form');">Update</button>
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
