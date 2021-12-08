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
                                        <th colspan="2" class="text-center">Details</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($subAccountsDebit) --}}
                                    @foreach ($journal_vouchers as $key=> $journalVoucher)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$journalVoucher->date }}</td>
                                        <td colspan="2">
                                            <table class="w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Sub Account</th>
                                                        <th>Naration</th>
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
                                                                <td>{{$detail->product_narration}}</td>
                                                                <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                                                                <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <td colspan="2"><h5 class="text-center">Total</h5></td>
                                                    <td>{{$journalVoucher->total_debit}}</td>
                                                    <td>{{$journalVoucher->total_credit}}</td>
                                                </tfoot>
                                            </table>
                                        </td>

                                        <td class="text-right">
                                            <button class="btn btn-info text-white btn-sm" data-toggle="modal" data-target=".updateJournal" onclick="editResource('{{ route('journal.edit', $journalVoucher->id) }}','.updateModalJournal')">Update</button>
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
