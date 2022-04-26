<table class="table table-striped table-bordered zero-configuration">
    <thead>
        <tr>
            <th>Date</th>
            <th>Days</th>
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
            $openingBalance = 0;
            $debitBalance = 0;
            $creditBalance = 0;
            $entryType = '';
        @endphp
        @if(isset($vouchers) && $vouchers->count()>0)
            @foreach($vouchers as $key=>$singleAccount)
                @php
                    $subAccount = App\SubAccount::where('id',$key)->first();
                @endphp
                <tr><td colspan="7"> <h3 class="mb-0">{{$subAccount->title}}</h3></td></tr>

                @foreach($singleAccount as $key=>$detail)
                    @if($loop->first)
                        @php
                            $getOpeningBalanceResponse = getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id);
                            $openingBalance = $getOpeningBalanceResponse["opening_balance"];
                            $entryType = $getOpeningBalanceResponse["opening_balance_type"];
                        @endphp
                        <tr>
                            <td>{{date('d/m/y',strtotime($detail->date))}}</td>
                            <td></td>
                            <td>Opening Balance</td>
                            <td colspan="2"></td>
                            <td>{{ number_format(getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance"] , 2) }}</td>
                            <td>{{ getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance_type"] }}</td>
                        </tr>
                    @endif
                    {{-- @if($loop->first)
                        @php $openingBalance = $detail->remaining_balance; @endphp;
                    @endif --}}
                    @php
                        $str = $detail->entry_type."_amount";
                        if($openingBalance > 0 ){
                            $detail->entry_type=="debit"?$debitBalance += $detail->$str:$creditBalance += $detail->$str;
                            $openingBalance = $openingBalance - $detail->$str;
                        }else{
                            $entryType = $entryType=="debit"? "credit":"debit";
                        }
                        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $detail->date);
                        $from = \Carbon\Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        $diff_in_days = $to->diffInDays($from);
                    @endphp

                    <tr>
                        <td>{{date('d/m/y',strtotime($detail->date))}}</td>
                        <td>{{$diff_in_days}}</td>
                        <td>{{$detail->product_narration}} @if($detail->quantity!=0 && $detail->rate!=0)  (<span style="font-weight:bold;">{{$detail->quantity}} x {{$detail->rate}}</span>) @endif</td>
                        <td>{{ $detail->debit_amount!=0? number_format($detail->debit_amount , 2) :"" }}</td>
                        <td>{{ $detail->credit_amount!=0? number_format($detail->credit_amount , 2):"" }}</td>
                        <td>{{ number_format(abs($openingBalance) , 2)}}</td>
                        <td>{{$entryType}}</td>
                    </tr>
                    @if($openingBalance < 0)
                        @php break; @endphp
                    @endif
                @endforeach
            @endforeach

        @else
            <tr>
                <td colspan="8" class="text-center">No records found</td>
            </tr>
        @endif
    </tbody>
    @if(isset($vouchers) && $vouchers->count()>0)
        <tfoot>
            <tr>
                <td colspan="3"><h5 class="text-center">Total</h5></td>
                <td>{{number_format($debitBalance , 2)}}</td>
                <td>{{number_format($creditBalance , 2)}}</td>
                <td>{{number_format($openingBalance , 2)}}</td>
                <td>{{$entryType}}</td>
            </tr>
        </tfoot>
    @endif
</table>