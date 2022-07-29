
<style>
    .trail_tr{
        background-color: #7571f9 !important;
    }
    .trail_tr th{
        font-size:20px !important;
        color: #f1f1f1 !important;
    }
    .trail_tr th:nth-child(1) , .trailTotal th:nth-child(1){
        width: 70% !important;
    }
    .trail_tr th:nth-child(2) , .trailTotal th:nth-child(2){
        width: 30% !important;
    }
    .blackBorder td, .blackBorder th {
        border: 1px solid #938f8f !important;
    }


</style>

<div>
    <div class="d-flex justify-content-end mb-4">
        <a class="btn btn-success text-white" href="{{ route('trialReport',[$startDate, $endDate]) }}">Export to PDF</a>
    </div>

    <table class="table table-striped table-bordered zero-configuration">
        <thead>
            <tr>
                <th class="text-center h4">Debit</th>
                <th class="text-center h4">Credit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                {{-- Debit Table code Start --}}
                            <td style="vertical-align: top !important;">
                                <table class="w-100 blackBorder">
                                    <thead>
                                        <tr class="trail_tr">
                                            <th>Sub Account</th>
                                            <th>Closing Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalDebit = 0;
                                            $totalCredit = 0;
                                        @endphp
                                        @foreach($subAccounts as $key=>$subAccount)
                                            @php
                                                $getOpeningBalanceResponse = getOpeningBalance($subAccount->id, $startDate, $endDate, false , 0);
                                                $openingBalance = $getOpeningBalanceResponse["opening_balance"];
                                                $entryType = $getOpeningBalanceResponse["opening_balance_type"];
                                            @endphp
                                            @if ($entryType == 'debit' && number_format($openingBalance) > 0)
                                                @php
                                                    $totalDebit += round($openingBalance);
                                                @endphp
                                                <tr>
                                                    <td>{{$subAccount->title}}</td>
                                                    <td data-last-balance ="{{$totalDebit}}">{{number_format($openingBalance)}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                {{-- Debit Table code end --}}

                {{-- Credit Table code Start --}}
                            <td style="vertical-align: top !important;">
                                <table class="w-100 blackBorder">
                                    <thead>
                                        <tr class="trail_tr">
                                            <th>Sub Account</th>
                                            <th>Closing Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subAccounts as $key=>$subAccount)
                                            @php
                                                $getOpeningBalanceResponse = getOpeningBalance($subAccount->id, $startDate, $endDate,  false , 0);
                                                $openingBalance = $getOpeningBalanceResponse["opening_balance"];
                                                $entryType = $getOpeningBalanceResponse["opening_balance_type"];
                                            @endphp

                                            @if ($entryType == 'credit' && number_format($openingBalance) > 0)
                                                @php
                                                    $totalCredit += round($openingBalance);
                                                @endphp
                                                <tr>
                                                    <td>{{$subAccount->title}}</td>
                                                    <td>{{number_format($openingBalance)}}</td>
                                                </tr>
                                            @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </td>
                {{-- Credit Table code end --}}
            </tr>


            <tr style="background-color: rgba(0, 0, 0, 0.05) !important;">
                <td>
                    <table class="w-100">
                        <tbody>
                            <tr class="trailTotal">
                                <th class="text-center h5">Total</th>
                                <th class="h5">{{number_format($totalDebit)}}</th>
                            </tr>
                        </tbody>
                    </table>
                </td>

                <td>
                    <table class="w-100">
                        <tbody>
                            <tr class="trailTotal">
                                <th class="text-center h5">Total</th>
                                <th class="h5">{{number_format($totalCredit)}}</th>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

        </tbody>

        {{-- Total Debit and Credit code Start --}}
        <tfoot>

        </tfoot>
        {{-- Total Debit and Credit code Start --}}
    </table>
</div>




