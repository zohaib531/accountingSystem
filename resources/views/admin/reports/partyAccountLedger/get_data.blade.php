<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>Date</th>
            <th>Sub Account</th>
            <th>Narration/Details</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
            <th>Nature (Debit/Credit)</th>
            {{-- <th class="text-right">Action</th> --}}
        </tr>
    </thead>
    <tbody>
        @php 
            $openingBalance = $subAccount->opening_balance;
            $entryType = $subAccount->transaction_type
        @endphp
        @if(isset($vouchers) && $vouchers->count()>0)
            <tr>
                <td>{{date('d-m-Y',strtotime($subAccount->date))}}</td>
                <td>{{$subAccount->title}}</td>
                <td>Opening Balance</td>
                <td colspan="2"></td>
                <td>{{$subAccount->opening_balance!=0 ? $subAccount->opening_balance : 0}}</td>
                <td>{{$subAccount->opening_balance!=0 ? $subAccount->transaction_type : ""}}</td>
            </tr>
            
            @foreach($vouchers as $key=>$detail)
                @php
                    $str = $detail->entry_type."_amount";
                    if($key==0 && $subAccount->opening_balance==0)
                    {
                        $openingBalance = $detail->$str;
                        $entryType = $detail->entry_type;
                    }else{
                        $openingBalance = $entryType=="debit" ? $openingBalance-$detail->$str : $openingBalance + $detail->$str ;
                        $entryType = $openingBalance<0? "credit":"debit";
                    }
                @endphp
                <tr>
                    <td>{{date('d-m-Y',strtotime($detail->date))}}</td>
                    <td>{{$detail->subAccount->title}}</td>
                    <td>{{$detail->product_narration}} @if($detail->quantity!=0 && $detail->rate!=0)  (<span style="font-weight:bold;">{{$detail->quantity}} x {{$detail->rate}}</span>) @endif</td>
                    <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                    <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                    <td>{{ $openingBalance<0? str_replace('-','',$openingBalance):$openingBalance }}</td>
                    <td>{{$entryType}}</td>
                </tr>
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
                <td colspan="3"><h5 class="text-center">Total</h5></td>
                <td>{{$totalDebit}}</td>
                <td>{{$totalCredit}}</td>
                <td>{{$openingBalance}}</td>
                <td>{{$entryType}}</td>
            </tr>
        </tfoot>
    @endif
</table>
