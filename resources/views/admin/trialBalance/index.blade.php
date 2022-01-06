@extends('layouts.admin')
@section('title', 'Trial Balance')

@section('style')
<style>
    .trailPassword{
        position: absolute;
        right: 26px;
        top: 8px;
        background: #fff;
        cursor: pointer;
    }
</style>

@endsection


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-6 text-right">
                            <h4 class="card-title">Trial Balance</h4>
                        </div>
                    </div>

                    <form method="post" id="create-form">
                        @csrf
                        <div class="row mx-0 mb-4 align-items-end">
                            <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-start_date">Start date<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <input name="start_date" id="val-start_date" class="form-control" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-end_date">End date<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <input name="end_date" id="val-end_date"  class="form-control" placeholder="dd/mm/yyyy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                    </div>
                                </div>
                            </div>


                            {{-- <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-end_date">Date<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <input name="date" id="val-end_date"  class="form-control" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-3">
                                <button type="button" class="btn btn-primary" onclick="commonFunctionForAllRequest(true,false,'.trialBalancePortion','{{route('getTrialBalance')}}','','post','','create-form');">Create Trial Balance</button>
                            </div>
                        </div>

                    </form>

                    <div class="table-responsive trialBalancePortion">

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>


@if(!session()->has('Trial_Bal_Password_Check'))
<!-- Button trigger modal -->
    <button type="button" class="btn btn-primary trailBalance d-none" data-toggle="modal" data-target="#myModal">ABC</button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form class="form-valide" id="password-form"  method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Password Required</h5>
                        {{-- <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="val_password">Password<span class="text-danger">*</span></label>
                            <div class="col-lg-9 position-relative">
                                <input type="password" class="form-control pr-4" id="val_password" name="password" placeholder="Enter passowrd..">
                                <i class="mdi mdi-eye-off trailPassword" onclick="changeType(this)"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                        <button type="button" class="btn btn-primary" onclick="commonFunctionForAllRequest(false,false,'','{{route('checkPassword')}}','','post','','password-form');">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endif

@endsection



@section('script')
<script>
    $(document).ready(function(){
        $(".trailBalance").click();
    });

    const changeType = (e) =>{
        if(val_password.getAttribute('type') == 'password'){
            val_password.setAttribute('type','text');
            e.classList.remove('mdi-eye-off')
            e.classList.add('mdi-eye')
        }else{
            val_password.setAttribute('type','password');
            e.classList.add('mdi-eye-off')
            e.classList.remove('mdi-eye')
        }
    }
</script>

@endsection
