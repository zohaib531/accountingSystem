<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>#</th>
            <th>Sub Account</th>
            <th>Debit</th>
            <th>Credit</th>
            {{-- <th class="text-right">Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @if(isset($vouchers) && $vouchers->count()>0)
            @foreach ($vouchers as $key=> $journalVoucher)
                @if($journalVoucher->voucherDetails->count()>0)
                    @foreach($journalVoucher->voucherDetails as $key=>$detail)
                        <tr>
                            @php $str = $detail->entry_type."_amount";  @endphp
                            <td>{{++$key}}</td>
                            <td>{{$detail->subAccount->title}}</td>
                            <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                            <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="4" class="text-center">No records found between these range</td>
            </tr>
        @endif
    </tbody>
</table>