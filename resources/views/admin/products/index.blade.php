@extends('layouts.admin')
@section('title','Product List')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')



{{-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('products.index')}}">All Products</a></li>
        </ol>
    </div>
</div>
<!-- row --> --}}

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-6 text-right">
                            <h4 class="card-title">All Products</h4>
                        </div>
                        <div class="col-6 text-right">
                            @can('create-product')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addProduct" onclick="initializeSelect2()">Add new +</button>
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Narration</th>
                                    <th>Unit</th>
                                    @canany(['update-product' , 'delete-product'])
                                        <th class="text-right w-25">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key=> $product)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$product->title}}</td>
                                    <td>{{$product->narration}}</td>
                                    <td>{{ucwords($product->product_unit)}}</td>
                                    @canany(['update-product' , 'delete-product'])
                                        <td class="text-right">
                                            @can('update-product')
                                                <button class="btn btn-info text-white" data-toggle="modal" data-target=".updateProduct" onclick="editResource('{{ route('products.edit', $product->id) }}','.updateModalProduct')">Update</button>
                                            @endcan
                                            @can('delete-product')
                                                <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('products.destroy',$product->id) }}','{{route('products.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
                                            @endcan
                                        </td>
                                    @endcanany
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->


<!--Add Product modal start-->

<div class="modal fade addProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Products</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
               <div class="form-validation my-5">
                   <form class="form-valide" id="create-form">
                       <input type="hidden" name="unique_product" id="productUniqueAdd">

                       <div class="row m-0">
                           <div class="col-7 px-0">
                               <div class="form-group row">
                                   <label class="col-lg-5 col-form-label px-0" for="product-title">Product Name<span class="text-danger">*</span></label>
                                   <div class="col-lg-7 pr-0" style="padding-left: 1.3rem !important;">
                                       <input type="text" class="form-control" id="product-title" name="title" placeholder="Enter Product Name.." oninput="getUniqueProduct('#product-title', '#product-naration', '#product-unit' , '#productUniqueAdd')">
                                   </div>
                               </div>
                           </div>
                           <div class="col-5 pl-0">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label px-0 text-right" for="product-unit">Unit<span class="text-danger">*</span></label>
                                    <div class="col-lg-9 pr-0">
                                        <select class="form-control searchableSelect" id="product-unit" name="product_unit" onchange="getUniqueProduct('#product-title', '#product-naration', '#product-unit', '#productUniqueAdd')">
                                            <option value="" disabled selected>Select Product unit</option>
                                            <option value="meter">Meter</option>
                                            <option value="bags">Bags</option>
                                            <option value="kgs">Kgs</option>
                                            <option value="pounds">Pounds</option>
                                        </select>
                                    </div>
                                </div>
                           </div>
                       </div>



                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="product-naration">Narration<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="product-naration" name="narration" placeholder="Enter Narration.." oninput="getUniqueProduct('#product-title', '#product-naration', '#product-unit', '#productUniqueAdd')">
                            </div>
                        </div>

                   </form>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('products.store') }}','{{route('products.index')}}','post','','create-form');">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add Product modal start-->


 <!--Update Product modal start-->

 <div class="modal fade updateProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content updateModalProduct">

        </div>
    </div>
</div>
<!--Update Product modal start-->



@endsection


@section('script')
    <script src="{{asset('assets/template/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>



@endsection
