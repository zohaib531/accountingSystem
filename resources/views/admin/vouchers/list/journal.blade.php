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
                                        <th>Sub account</th>
                                        <th>Naration</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $num = 0;
                                    @endphp
                                    @foreach ($vouchers as $key=> $voucherDetail)
                                        @if($voucherDetail->voucher->voucher_type=='journal_voucher')
                                        <tr>
                                            <td>{{++$num}}</td>
                                            <td>{{date('d/m/y',strtotime($voucherDetail->date))}}</td>
                                            <td>{{$voucherDetail->subAccount->title}}</td>
                                            <td>{{$voucherDetail->product_narration}}</td>
                                            {{-- Code for Debit start --}}
                                            @if ($voucherDetail->entry_type =='debit')
                                                <td>{{ number_format($voucherDetail->debit_amount , 2) }}</td>
                                            @else
                                                <td>0.00</td>
                                            @endif
                                            {{-- Code for Debit start --}}

                                            {{-- Code for Credit start --}}
                                            @if ($voucherDetail->entry_type == 'credit')
                                                <td>{{ number_format($voucherDetail->credit_amount , 2) }}</td>
                                            @else
                                                <td>0.00</td>
                                            @endif
                                            {{-- Code for Credit start --}}

                                            <td class="text-right">
                                                <a href="{{route('journal.edit',$voucherDetail->voucher->id)}}">
                                                    <button class="btn btn-info text-white btn-sm">
                                                        Update
                                                    </button>
                                                </a>
                                                {{-- <button class="btn btn-danger btn-sm" onclick="commonFunction(true,'{{ route('journal.destroy', $voucherDetail->voucher->id) }}','{{route('journal.index')}}','delete','Are you sure you want to delete?','');">
                                                    Delete
                                                </button> --}}
                                            </td>
                                        </tr>
                                        @endif
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
