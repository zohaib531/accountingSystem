@extends('layouts.admin')
@section('title','Party Account/Ledger')

@section('style')

@endsection

@section('content')


{{--
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('salePurchase.index')}}">Party Account / Ledger</a></li>
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
                            <h4 class="card-title">Party Account / Ledger</h4>
                        </div>
                    </div>

                    <form method="post" id="create-form">
                        @csrf
                        <div class="row mx-0 mb-5 align-items-end">
                            <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-start_date">Sub Account<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <select name="sub_account" class="form-control searchableSelect" id="">
                                            <option selected value="">Sub Account</option>
                                            @foreach ($subAccounts as $subAccount)
                                                <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-start_date">Start date<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <input name="start_date" id="val-start_date" class="form-control" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-end_date">End date<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <input name="end_date" id="val-end_date"  class="form-control" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <button type="button" class="btn btn-primary" onclick="commonFunctionForAllRequest(true,false,'.trialBalancePortion','{{route('getPartyAccountData')}}','','post','','create-form');">Create Report</button>
                            </div>
                        </div>

                    </form>

                    <div class="trialBalancePortion">

                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->




@endsection


@section('script')
    <script src="{{asset('assets/template/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>

@endsection


