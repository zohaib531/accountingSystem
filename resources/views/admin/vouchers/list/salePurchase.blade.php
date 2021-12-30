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
                            @dd()
                            {{-- Filter Code Start --}}
                            <div class="col-10">

                                <form method="post" action="{{ route('applyFilter') }}" >
                                    @csrf
                                    <div class="row mt-2 align-items-end">

                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Sub Account<span class="text-danger">*</span></label>
                                            <select name="sub_account_id" class="form-control searchableSelectFilterSubaccount">
                                                <option selected value="all">All</option>
                                                @foreach ($subAccounts as $subAccount)
                                                <option value="{{$subAccount->id}}" >{{$subAccount->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Product<span class="text-danger">*</span></label>
                                            <select name="product_narration" class="form-control searchableSelectFilterProduct">
                                                <option selected value="all">All</option>
                                                @foreach ($products as $product)
                                                    <option value="{{$product->title." - ".$product->narration." - ".$product->product_unit}}">{{$product->title." - ".$product->narration." - ".$product->product_unit}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            <label class="col-lg-12 col-form-label px-0">Transaction Type<span class="text-danger">*</span></label>
                                            <select name="entry_type" class="form-control searchableSelectFilterTransaction">
                                                <option selected value="all">All</option>
                                                <option value="debit" >Debit</option>
                                                <option value="credit">Credit</option>
                                            </select>
                                        </div>

                                        <div class="col-3 text-center">
                                            <button type="submit" class="btn btn-primary">
                                                Apply Filter
                                            </button>
                                        </div>

                                    </div>

                                </form>


                            </div>
                            {{-- Filter Code Start --}}

                        </div>



                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Sub account</th>
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
                                            <td>{{ $sale_purchase_voucher->subAccount->title }}</td>
                                            <td>{{ $sale_purchase_voucher->product_narration }}</td>
                                            {{-- Code for Debit start --}}
                                            @if ($sale_purchase_voucher->entry_type =='debit')
                                                <td>{{ number_format($sale_purchase_voucher->debit_amount , 2) }}</td>
                                            @else
                                                <td>0.00</td>
                                            @endif
                                            {{-- Code for Debit start --}}

                                            {{-- Code for Credit start --}}
                                            @if ($sale_purchase_voucher->entry_type == 'credit')
                                                <td>{{ number_format($sale_purchase_voucher->credit_amount , 2) }}</td>
                                            @else
                                                <td>0.00</td>
                                            @endif
                                            {{-- Code for Credit start --}}

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


@section('script')

    <script>
        $(document).ready(function() {
            $('.searchableSelectFilterSubaccount').select2({dropdownParent: $('.searchableSelectFilterSubaccount').parent()});
            $('.searchableSelectFilterProduct').select2({dropdownParent: $('.searchableSelectFilterProduct').parent()});
            $('.searchableSelectFilterTransaction').select2({dropdownParent: $('.searchableSelectFilterTransaction').parent()});
        });
    </script>

@endsection
