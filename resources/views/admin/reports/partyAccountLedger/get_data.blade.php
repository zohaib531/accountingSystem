<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>Date</th>
            <th>Narration/Details</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
            <th>Nature (Debit/Credit)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $openingBalance = 0;
            $entryType = '';
        @endphp
        @if(isset($vouchers) && $vouchers->count()>0)
            @foreach($vouchers as $key=>$detail)
                @if($loop->first)
                    <tr>
                        <td>{{date('d-m-Y',strtotime($detail->date))}}</td>
                        <td>Opening Balance</td>
                        <td colspan="2"></td>
                        <td>{{ getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance"] }}</td>
                        <td>{{ getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance_type"] }}</td>
                    </tr>
                @endif
                @php
                    $str = $detail->entry_type."_amount";
                @endphp
                <tr>
                    <td>{{date('d-m-Y',strtotime($detail->date))}}</td>
                    <td>{{$detail->product_narration}} @if($detail->quantity!=0 && $detail->rate!=0)  (<span style="font-weight:bold;">{{$detail->quantity}} x {{$detail->rate}}</span>) @endif</td>
                    <td>{{ $detail->debit_amount!=0?number_format($detail->debit_amount):"" }}</td>
                    <td>{{ $detail->credit_amount!=0?number_format($detail->credit_amount):"" }}</td>
                    <td>{{ number_format($detail->remaining_balance) }}</td>
                    <td>{{$detail->remaining_balance_type}}</td>
                </tr>
                @if($loop->last)
                    @php 
                        $openingBalance = $detail->remaining_balance; 
                        $entryType = $detail->remaining_balance_type; 
                    @endphp
                @endif
            @endforeach

        @else
            <tr>
                <td colspan="6" class="text-center">No records found</td>
            </tr>
        @endif
    </tbody>
    @if(isset($vouchers) && $vouchers->count()>0)
        <tfoot>
            <tr>
                <td colspan="2"><h5 class="text-center">Total</h5></td>
                <td>{{number_format($totalDebit)}}</td>
                <td>{{number_format($totalCredit)}}</td>
                <td>{{number_format($openingBalance)}}</td>
                <td>{{$entryType}}</td>
            </tr>
        </tfoot>
    @endif
</table>
