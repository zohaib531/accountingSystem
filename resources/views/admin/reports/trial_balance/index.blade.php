@extends('layouts.admin')
@section('title','Trial Balance List')


@section('content')



<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('salePurchase.index')}}">All Trial Balance</a></li>
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
                            <h4 class="card-title">All Trial Balance</h4>
                        </div>
                    </div>

                    <form action="{{route('getTrialBalanceData')}}" method="post">
                        @csrf
                        <div class="row mx-0 mb-5 align-items-end">
                            <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-start_date">Start date<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <input type="date" name="start_date" id="val-start_date" value="{{ isset($request->start_date)? $request->start_date:'' }}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group row m-0 align-items-center">
                                    <label class="col-lg-12 col-form-label px-0" for="val-end_date">End date<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 px-0">
                                        <input type="date" name="end_date" id="val-end_date"  class="form-control" value="{{ isset($request->end_date)?$request->end_date:'' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <button type="submit" class="btn btn-primary">Create Report +</button>
                            </div>
                        </div>

                    </form>


                    @if(isset($vouchers))
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th colspan="2" class="text-center">Detials</th>
                                        {{-- <th class="text-right">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $key=> $journalVoucher)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$journalVoucher->date }}</td>
                                            <td colspan="2">
                                                <table class="w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Sub Account</th>
                                                            <th>Naration</th>
                                                            <th>Transaction Type</th>
                                                            <th>Debit</th>
                                                            <th>Credit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($journalVoucher->voucherDetails->count()>0)
                                                            @foreach($journalVoucher->voucherDetails as $detail)
                                                                <tr>
                                                                    @php $str = $detail->entry_type."_amount";  @endphp
                                                                    <td>{{$detail->subAccount->title}}</td>
                                                                    <td>sdfsdf</td>
                                                                    <td>{{ucfirst(str_replace('_',' ',$detail->transaction_type))}}</td>
                                                                    <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                                                                    <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </td>
                                            {{-- <td class="text-right">
                                                <button class="btn btn-info text-white btn-sm" data-toggle="modal" data-target=".updateJournal" onclick="editResource('{{ route('journal.edit', $journalVoucher->id) }}','.updateModalJournal')">Update</button>
                                                <button class="btn btn-danger btn-sm" onclick="commonFunction(true,'{{ route('journal.destroy', $journalVoucher->id) }}','{{route('journal.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
                                            </td> --}}
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif
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

