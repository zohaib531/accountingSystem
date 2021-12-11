@extends('layouts.admin')
@section('title','All users')


@section('content')



{{-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('users.index')}}">All users</a></li>
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
                            <h4 class="card-title text-center">All users</h4>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".adduser">Add new +</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key=> $user)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{  implode(",", $user->roles->pluck('name')->toArray()) }}</td>
                                    <td class="text-right"><button class="btn btn-danger" onclick="commonFunction(true,'{{ route('users.destroy',$user->id) }}','{{route('users.index')}}','delete','Are you sure you want to delete?','');">Delete</button></td>
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


<!--Add user modal start-->

<div class="modal fade adduser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
               <div class="form-validation my-5">
                    <form class="form-valide" id="create-form">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label " for="val-username">Username <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="val-username" name="username" placeholder="Enter a username..">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label " for="val-email">Email <span class="text-danger">*</span> </label>
                            <div class="col-lg-10">
                                <input type="email" class="form-control" id="val-email" name="email" placeholder="Enter email..">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label " for="val-password">Password <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password..">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label " for="val-role">Role <span class="text-danger">*</span></label>
                            <div class="col-lg-10">
                                <select  class="form-control" name="role" id="role">
                                    <option value="" disabled selected>Please select Role</option>
                                    @if($roles->count()>0)
                                        @foreach ($roles as $role)
                                            <option value="{{$role->id}}">{{ucfirst($role->name)}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>




                    </form>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary"  onclick="commonFunction(false,'{{ route('users.store') }}','{{route('users.index')}}','post','','create-form');">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add user modal start-->



@endsection


