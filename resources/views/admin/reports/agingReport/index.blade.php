@extends('layouts.admin')
@section('title','Aging Report')


@section('content')



{{-- <div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('salePurchase.index')}}">Aging Report</a></li>
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
                            <h4 class="card-title">Aging Report</h4>
                        </div>
                    </div>

                    <form method="post" id="create-form">
                        @csrf
                        <div class="row mx-0 align-items-end">
                            <div class="col-2">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0">Account<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <select name="account" class="form-control searchableSelectAccount" onchange="accountChange(this)">
                                            <option selected value="all">All</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{$account->id}}">{{$account->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="fade">Some Data</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <select name="sub_account" class="form-control searchableSelect" id="subAccountWithFilter">
                                            <option selected value="all">All</option>
                                            @foreach ($subAccounts as $subAccount)
                                                <option value="{{$subAccount->id}}">{{$subAccount->title}}</option>
                                            @endforeach
                                        </select>
                                        <span class="fade">Some Data</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="col-lg-12 col-form-label px-0">Start Date<span class="text-danger">*</span></label>
                                <div class="col-lg-12 px-0">
                                    <input name="start_date" id="val-start_date" class="form-control @error('start_date') border-danger @enderror" value="{{old('start_date')}}" placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                    @if ($errors->has('start_date'))
                                        <span class="text-danger">Please enter end date.</span>
                                    @else
                                        <span class="fade">Some Data</span>
                                    @endif
                                </div>

                            </div>

                            <div class="col-2">
                                <label class="col-lg-12 col-form-label px-0" for="val-end_date">End date<span class="text-danger">*</span></label>
                                <div class="col-lg-12 px-0">
                                    <input name="end_date" id="val-end_date"  class="form-control  @error('end_date') border-danger @enderror" value="{{old('end_date')}}"  placeholder="dd/mm/yy" onkeyup="date_reformat_dd(this);" onkeypress="date_reformat_dd(this);" onpaste="date_reformat_dd(this);" autocomplete="off" type="text">
                                    @if ($errors->has('end_date'))
                                        <span class="text-danger">Please enter end date.</span>
                                    @else
                                        <span class="fade">Some Data</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-2">
                                <button type="button" class="btn btn-primary" onclick="commonFunctionForAllRequest(true,false,'.agingReportPortion','{{route('getAgentReportData')}}','','post','','create-form');">Create Report</button>
                                <div class="fade">Some Data</div>
                            </div>
                        </div>

                    </form>

                    <div class="table-responsive agingReportPortion">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->




@endsection


@section('script')

    <script>
            $(document).ready(function() {
                $('.searchableSelectAccount').select2({ dropdownParent: $('.searchableSelectAccount').parent() });
            });


            const accountChange = (e) =>{
                let html = '<option selected value="all" >All</option>';
                var allsubAccounts = {!! $subAccounts !!};
                for(let singleSubAccount of allsubAccounts){
                    if(e.value == 'all'){
                        html +=`<option value="${singleSubAccount.id}" >${singleSubAccount.title}</option>`;
                    }
                    if(e.value == singleSubAccount.account_id){
                        html +=`<option value="${singleSubAccount.id}" >${singleSubAccount.title}</option>`;
                    }
                }
                subAccountWithFilter.innerHTML= html;
            }
    </script>
@endsection

