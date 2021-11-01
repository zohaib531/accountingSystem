@extends('layouts.admin')
@section('title','Create user')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('users.create')}}">Create user</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Create user</h4>
                    <div class="form-validation">
                        <form class="form-valide" id="create-form">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="val-username">Username <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="val-username" name="username" placeholder="Enter a username..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="val-email">Email <span class="text-danger">*</span> </label>
                                <div class="col-lg-6">
                                    <input type="email" class="form-control" id="val-email" name="email" placeholder="Enter email..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="val-password">Password <span class="text-danger">*</span></label>
                                <div class="col-lg-6">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto">
                                    <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('users.store') }}','{{route('users.index')}}','post','','create-form');">Save</button>
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
