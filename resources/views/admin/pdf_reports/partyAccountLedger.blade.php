<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Party Leger Report</title>
    <style>
        body{
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            font-size: 10px;
        }
        .table1 th {
            text-align: center;
            border: 1px solid grey;
            padding: 5px;
            white-space: nowrap;

        }

        .table1 td {
            border: 1px solid grey;
            padding: 5px;
            text-align: left;
            white-space: nowrap;
        }

        .table1 {
            width: 100%;
            border-collapse: collapse;
        }
        .table1 tfoot tr td {
            border: 1px solid grey;
            padding: 5px !important;
            white-space: nowrap;
            font-weight: bold;
        }


    </style>
</head>

<body>
    <div>
        <div style="text-align: center; font-size:20px;margin-bottom:10px;font-weight:bolder;">Party Ledger: {{$subAccount->title}}</div>
        <table style="width:35%; padding: 10px 0px;">
            <tr>
                <th>Start date : <span>{{ Carbon\Carbon::createFromFormat('y-m-d', $startDate)->format('d / m / y') }}</span></th>
                <th style="padding-left: 15px;">End date : <span>{{ Carbon\Carbon::createFromFormat('y-m-d', $endDate)->format('d / m / y') }}</span></th>
            </tr>
        </table>
        <table class="table1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Narration/Details</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $openingBalance = 0;
                    $entryType = '';
                    $num = 1;
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
                                <td>{{$num++}}</td>
                                <td>{{date('d/m/y',strtotime($detail->date))}}</td>
                                <td colspan="3">Opening Balance</td>
                                <td>{{number_format( getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance"] )}}</td>
                                <td style="text-transform: capitalize;">{{ getOpeningBalance($detail->sub_account_id,$detail->date,true,$detail->id)["opening_balance_type"] }}</td>
                            </tr>
                        @endif
                        @php
                            $str = $detail->entry_type."_amount";
                            $getBalanceAndTypeResponse = getBalanceAndType($openingBalance,$entryType,$detail->entry_type,$detail->$str);
                            $openingBalance = $getBalanceAndTypeResponse["balance"];
                            $entryType = $getBalanceAndTypeResponse["type"];
                            $voucher = $detail->voucher['voucher_type'];
                            $voucherType = $voucher=="sale_purchase_voucher"? 'salePurchase.edit': 'journal.edit';
                        @endphp
                        <tr>
                            <td>{{$num++}}</td>
                            <td>{{date('d/m/y',strtotime($detail->date))}}</td>
                            <td>{{$detail->product_narration}} @if($detail->quantity!=0 && $detail->rate!=0)  (<span style="font-weight:bold;">{{$detail->quantity}} x {{$detail->rate}}</span>) @endif</td>
                            <td>{{ $detail->debit_amount!=0? number_format($detail->debit_amount):"" }}</td>
                            <td>{{ $detail->credit_amount!=0?number_format($detail->credit_amount):"" }}</td>
                            <td>{{ number_format($openingBalance)}}</td>
                            <td style="text-transform: capitalize;">{{$entryType}}</td>
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
                        <td>{{$num}}</td>
                        <td>{{ Carbon\Carbon::createFromFormat('y-m-d', $endDate)->format('d / m / y') }}</td>
                        {{-- <td>{{date('d/m/Y',strtotime($endDate))}}</td> --}}
                        <td>Opening Balance</td>
                        <td colspan="2"></td>
                        <td>{{ number_format($openingBalance) }}</td>
                        <td>{{ $entryType }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td colspan="7">No records found</td>
                    </tr>
                @endif
            </tbody>
            @if(isset($vouchers) && $vouchers->count()>0)
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <td>{{ number_format($totalDebit) }}</td>
                        <td>{{ number_format($totalCredit) }}</td>
                        <td>{{ number_format($openingBalance) }}</td>
                        <td style="text-transform: capitalize;">{{$entryType}}</td>
                    </tr>
                </tfoot>
            @endif
        </table>

    </div>

</body>

</html>
