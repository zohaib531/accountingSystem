@extends('layouts.admin')
@section('title', 'Sale/Purchase Voucher List')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0">
                            <div class="col-6 text-right">
                                <h4 class="card-title">All Sale/Purchase Voucher</h4>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('salePurchase.create') }}">
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
                                        <th>Product</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $key => $sale_purchase_voucher)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{date('d/m/y',strtotime($sale_purchase_voucher->date))}}</td>
                                            <td></td>
                                            <td>{{ number_format($sale_purchase_voucher->total_debit , 2) }}</td>
                                            <td>{{ number_format($sale_purchase_voucher->total_credit , 2) }}</td>

                                            <td class="text-right">
                                                <a href="{{route('salePurchase.edit',$sale_purchase_voucher->id)}}">
                                                    <button class="btn btn-info text-white btn-sm">
                                                        Update
                                                    </button>
                                                </a>
                                                <button class="btn btn-danger btn-sm" onclick="commonFunction(true,'{{ route('salePurchase.destroy', $sale_purchase_voucher->id) }}','{{ route('salePurchase.index') }}','delete','Are you sure you want to delete?','');">
                                                    Delete
                                                </button>
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
