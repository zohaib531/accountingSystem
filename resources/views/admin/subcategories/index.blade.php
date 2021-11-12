@extends('layouts.admin')
@section('title','Inventory | Sub category')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')



<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('sub-categories.index')}}">All sub category</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-6 text-right">
                            <h4 class="card-title">All Sub Category</h4>
                        </div>
                        @can('create-sub-category')
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addsubcategory">Add new +</button>
                            </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    {{-- <th>Category</th> --}}
                                    <th>Sub category</th>
                                    @canany(['update-sub-category' , 'delete-sub-category'])
                                        <th class="text-right w-25">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subCategories as $key=> $sub_category)
                                <tr>

                                    <td>{{++$key}}</td>
                                    {{-- @foreach ($categories as $cat)
                                    <td>{{$category->category_id==$cat->id?'selected':''}} $cat->title</td>
                                    @endforeach --}}
                                    <td>{{$sub_category->title}}</td>
                                    @canany(['update-sub-category' , 'delete-sub-category'])
                                    <td class="text-right">
                                        @can('update-sub-category')
                                            <button class="btn btn-info text-white" data-toggle="modal" data-target=".updateSubCategory" onclick="editResource('{{ route('sub-categories.edit', $sub_category->id) }}','.updateModalSubCategory')">Update</button>
                                        @endcan
                                        @can('delete-sub-category')
                                            <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('sub-categories.destroy',$sub_category->id) }}','{{route('sub-categories.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
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


<!--Add subcategory modal start-->

<div class="modal fade addsubcategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
               <div class="form-validation my-5">
                   <form class="form-valide" id="create-form">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label " for="val-category">Select Category <span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select class="form-control" id="val-category" name="category_id">
                                    <option value="" disabled selected>Please select</option>
                                    @foreach ($categories as $category)
                                        <option value="{{str_pad($category->code, 2, '0', STR_PAD_LEFT)}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label " for="val-title">Sub category title<span class="text-danger">*</span>
                            </label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="val-title" name="title" placeholder="Enter sub category..">
                            </div>
                        </div>
                   </form>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('sub-categories.store') }}','{{route('sub-categories.index')}}','post','','create-form');">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add subcategory modal start-->

 <!--Update category modal start-->

 <div class="modal fade updateSubCategory" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content updateModalSubCategory">

        </div>
    </div>
</div>
<!--Update category modal start-->


@endsection


@section('script')
    <script src="{{asset('assets/template/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>
@endsection
