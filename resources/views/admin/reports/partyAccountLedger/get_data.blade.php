<div>
    <div class="d-flex justify-content-end mb-4">
        <a class="btn btn-success text-white" href="{{ route('partyAccountReport',[$subAccount->id,$startDate, $endDate]) }}">Export to PDF</a>
    </div>
    <table class="table table-striped table-bordered zero-configuration">
        <thead>
            <tr>
                <th>Date</th>
                <th>Narration/Details</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>Nature (Debit/Credit)</th>
                <th class="text-center">Action</th>
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
                        @php
                            $getOpeningBalanceResponse = getOpeningBalance($detail->sub_account_id, $detail->date , true , $detail->id);
                            $openingBalance = $getOpeningBalanceResponse["opening_balance"];
                            $entryType = $getOpeningBalanceResponse["opening_balance_type"];
                        @endphp
                        <tr>
                            <td>{{date('d/m/y',strtotime($detail->date))}}</td>
                            <td>Opening Balance</td>
                            <td colspan="2"></td>
                            <td>{{ number_format(getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance"], 2) }}</td>
                            <td>{{ getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance_type"] }}</td>
                            <td></td>
                        </tr>
                    @endif
                    @php
                        $str = $detail->entry_type."_amount";
                        $getBalanceAndTypeResponse = getBalanceAndType($openingBalance,$entryType,$detail->entry_type,$detail->$str);
                        $openingBalance = $getBalanceAndTypeResponse["balance"];
                        $entryType = $getBalanceAndTypeResponse["type"];
                        $voucher = $detail->voucher->voucher_type;
                        $voucherType = $voucher=="sale_purchase_voucher"? 'salePurchase.edit': 'journal.edit';
                    @endphp
                    <tr>
                        <td>{{date('d/m/y',strtotime($detail->date))}}</td>
                        <td>{{$detail->product_narration}} @if($detail->quantity!=0 && $detail->rate!=0)  (<span style="font-weight:bold;">{{$detail->quantity}} x {{$detail->rate}}</span>) @endif</td>
                        <td>{{ $detail->debit_amount!=0?number_format($detail->debit_amount, 2):"" }}</td>
                        <td>{{ $detail->credit_amount!=0?number_format($detail->credit_amount, 2):"" }}</td>
                        <td>{{ number_format($openingBalance, 2) }}</td>
                        <td>{{$entryType}}</td>
                        <td class="text-center">
                            <a href="{{route($voucherType,$detail->voucher_id)}}">
                                <button class="btn btn-info btn-sm">Update</button>
                            </a>
                        </td>
                    </tr>
                    {{-- @if($loop->last)
                        @php
                            $openingBalance = $detail->remaining_balance;
                            $entryType = $detail->remaining_balance_type;
                        @endphp
                    @endif --}}
                @endforeach

            @else

                @php
                    // $endDate =  $_POST['end_date'];
                    // $accound_id = $_POST['sub_account'];
                    $getOpeningBalanceResponse = getOpeningBalance($subAccount->id, $endDate  , false , 0);
                    $openingBalance = $getOpeningBalanceResponse["opening_balance"];
                    $entryType = $getOpeningBalanceResponse["opening_balance_type"];
                @endphp


                <tr>
                    <td>{{ Carbon\Carbon::createFromFormat('y-m-d', $endDate)->format('d / m / y') }}</td>
                    {{-- <td>{{date('d/m/Y',strtotime($endDate))}}</td> --}}
                    <td>Opening Balance</td>
                    <td colspan="2"></td>
                    <td>{{ number_format($openingBalance , 2) }}</td>
                    <td>{{ $entryType }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="7" class="text-center">No records found</td>
                </tr>
            @endif
        </tbody>
        @if(isset($vouchers) && $vouchers->count()>0)
            <tfoot>
                <tr>
                    <td colspan="2"><h5 class="text-center">Total</h5></td>
                    <td>{{number_format($totalDebit, 2)}}</td>
                    <td>{{number_format($totalCredit, 2)}}</td>
                    <td>{{number_format($openingBalance, 2)}}</td>
                    <td>{{$entryType}}</td>
                    <td></td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
