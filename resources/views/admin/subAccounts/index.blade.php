@extends('layouts.admin')
@section('title','Sub Account')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')



{{-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('sub-accounts.index')}}">All Sub Accounts</a></li>
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
                            <h4 class="card-title">All Sub Accounts</h4>
                        </div>
                        @can('create-sub-category')
                            <div class="col-6 text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".addsubaccount" onclick="initializeSelect2(), transactionSelect2()">Add new +</button>
                            </div>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Opening Date</th>
                                    <th>General Accounts </th>
                                    <th>Sub Accounts</th>
                                    <th>Transaction Type</th>
                                    <th>Opening Balance</th>
                                    @canany(['update-sub-category' , 'delete-sub-category'])
                                        <th class="text-right w-25">Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subAccounts as $key=> $sub_account)
                                <tr>

                                    <td>{{++$key}}</td>
                                    <td>{{date('d/m/y', strtotime($sub_account->date))}}</td>
                                    <td>{{$sub_account->get_account->title}}</td>
                                    <td>{{$sub_account->title}}</td>
                                    <td>{{ucwords($sub_account->transaction_type)}}</td>
                                    <td>{{number_format($sub_account->opening_balance)}}</td>
                                    @canany(['update-sub-category' , 'delete-sub-category'])
                                    <td class="text-right">
                                        @can('update-sub-category')
                                            <button class="btn btn-info text-white" data-toggle="modal" data-target=".updateSubaccount" onclick="editResource('{{ route('sub-accounts.edit', $sub_account->id) }}','.updateModalSubaccount')">Update</button>
                                        @endcan
                                        @can('delete-sub-category')
                                            <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('sub-accounts.destroy',$sub_account->id) }}','{{route('sub-accounts.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
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


<!--Add subaccount modal start-->

<div class="modal fade addsubaccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sub Accounts</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
               <div class="form-validation my-5">
                   <form class="form-valide" id="create-form">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="val-account">General Accounts<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <select class="form-control searchableSelect" id="val-account" name="account_id">
                                    <option value="" disabled selected>Select General Accounts</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{str_pad($account->code, 2, '0', STR_PAD_LEFT)}}">{{$account->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="val-title">Sub Accounts<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="val-title" name="title" placeholder="Enter Sub Accounts..">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="opening-balance">Opening Balance<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <div class="row m-0">
                                    <div class="col-6 pl-0">
                                        <input type="text" class="form-control" id="opening-balance" value="0" name="opening_balance" placeholder="Enter Opening Balance.."  maxlength="12" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'placeholder': '0'" data-val="0" data-common="common" onkeyup="getValue(this)">
                                    </div>
                                    <div class="col-6 pr-0">
                                        <select class="form-control searchableSelectTransaction" id="transaction-type" name="transaction_type">
                                            <option value="" disabled selected>Select Debit/Credit</option>
                                            <option value="debit">Debit</option>
                                            <option value="credit">Credit</option>
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label px-0" for="opening-date">Opening Date<span class="text-danger">*</span></label>
                            <div class="col-lg-9">
                                <input class="form-control" id="opening-date" name="opening_date" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                            </div>
                        </div>

                   </form>
               </div>
           </div>
           <div class="modal-footer">
               <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-success text-white" onclick="commonFunction(false,'{{ route('sub-accounts.store') }}','{{route('sub-accounts.index')}}','post','','create-form');">Save</button>
            </div>
        </div>
    </div>
</div>
<!--Add subaccount modal start-->

 <!--Update account modal start-->

 <div class="modal fade updateSubaccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content updateModalSubaccount">

        </div>
    </div>
</div>
<!--Update account modal start-->


@endsection


@section('script')
    <script src="{{asset('assets/template/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>

    <script>
        function transactionSelect2(){
            $('.searchableSelectTransaction').select2({dropdownParent: $('.searchableSelectTransaction').parent()});
        }

    </script>
@endsection
