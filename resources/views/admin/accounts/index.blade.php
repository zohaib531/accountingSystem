@extends('layouts.admin')
@section('title','General Account')

@section('content')



{{-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('accounts.index')}}">All General Account</a></li>
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
                            <h4 class="card-title">All General Accounts</h4>
                        </div>
                        <div class="col-6 text-right">
                            @can('create-category')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addAccount">Add new +</button>
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>General Accounts</th>
                                    @canany(['update-category' , 'delete-category'])
                                        <th class="text-right w-25">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $key=> $Account)
                                <tr>

                                    <td>{{++$key}}</td>
                                    <td>{{$Account->title}}</td>

                                    @canany(['update-category' , 'delete-category'])
                                        <td class="text-right">
                                            @can('update-category')
                                                <button class="btn btn-info text-white" data-toggle="modal" data-target=".updateAccount" onclick="editResource('{{ route('accounts.edit', $Account->id) }}','.updateModalAccount')">Update</button>
                                            @endcan
                                            @can('delete-category')
                                                <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('accounts.destroy',$Account->id) }}','{{route('accounts.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
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


 <!--Add Account modal start-->

 <div class="modal fade addAccount" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Add General Account</h5>
                 <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
             </div>
             <div class="modal-body px-5">
                <div class="form-validation my-5">
                    <form class="form-valide" id="create-form">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val-category">Head Account Name<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="val-category" name="title" placeholder="Enter head account name..">
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
                <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('accounts.store') }}','{{route('accounts.index')}}','post','','create-form');">Save</button>
             </div>
         </div>
     </div>
 </div>
 <!--Add category modal start-->


 <!--Update category modal start-->

 <div class="modal fade updateAccount" tabindex="-1" role="dialog" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content updateModalAccount">

         </div>
     </div>
 </div>
 <!--Update category modal start-->


@endsection


