@extends('layouts.admin')
@section('title','Journal Voucher List')


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-6 text-right">
                                <h4 class="card-title">All Journal Voucher</h4>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('journal.create') }}">
                                    <button type="button" class="btn btn-primary">
                                        Add new +
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Naration</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($journal_vouchers as $key=> $journalVoucher)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{date('d/m/Y',strtotime($journalVoucher->date))}}</td>
                                        <td></td>
                                        <td>{{number_format($journalVoucher->total_debit)}}</td>
                                        <td>{{number_format($journalVoucher->total_credit)}}</td>
                                        <td class="text-right">
                                            <a href="{{route('journal.edit',$journalVoucher->id)}}">
                                                <button class="btn btn-info text-white btn-sm">
                                                    Update
                                                </button>
                                            </a>
                                            <button class="btn btn-danger btn-sm" onclick="commonFunction(true,'{{ route('journal.destroy', $journalVoucher->id) }}','{{route('journal.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
                                        </td>
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

@endsection
