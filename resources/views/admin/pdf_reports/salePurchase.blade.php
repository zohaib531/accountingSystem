<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Purchase Voucher Report</title>

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
        <div style="text-align: center; font-size:20px;margin-bottom:20px;font-weight:bolder;">Sale/Purchase Voucher</div>
        <table class="table1">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Sub account</th>
                    <th>Product</th>
                    <th>Debit</th>
                    <th>Credit</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $num = 0;
                @endphp
                @foreach ($vouchers as $key => $voucherDetail)
                    @if($voucherDetail->voucher->voucher_type=='sale_purchase_voucher')
                        <tr>
                            <td>{{ ++$num }}</td>
                            <td>{{date('d/m/y',strtotime($voucherDetail->date))}}</td>
                            <td>{{ $voucherDetail->subAccount->title }}</td>
                            <td>{{ $voucherDetail->product_narration }}</td>
                            {{-- Code for Debit start --}}
                            @if ($voucherDetail->entry_type =='debit')
                                <td>{{ $voucherDetail->debit_amount }}</td>
                            @else
                                <td>0</td>
                            @endif
                            {{-- Code for Debit start --}}

                            {{-- Code for Credit start --}}
                            @if ($voucherDetail->entry_type == 'credit')
                                <td>{{ $voucherDetail->credit_amount }}</td>
                            @else
                                <td>0</td>
                            @endif
                            {{-- Code for Credit start --}}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
