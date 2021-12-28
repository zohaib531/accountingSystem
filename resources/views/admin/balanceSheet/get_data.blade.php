<style>
    td{
        width: 50% !important;
    }
</style>


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
                            <table class="w-100">
                                <thead>
                                    <tr>
                                        <th>Sub Account</th>
                                        <th>Closing Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subAccounts as $key=>$subAccount)
                                        @php
                                            $getOpeningBalanceResponse = getOpeningBalance($subAccount->id, $endDate, false , 0);
                                        @endphp

                                        @if ($subAccount->transaction_type == 'debit')
                                            <tr>
                                                <td>{{$subAccount->title}}</td>
                                                <td>{{$subAccount->opening_balance}}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
            {{-- Debit Table code end --}}

            {{-- Credit Table code Start --}}
                        <td style="vertical-align: top !important;">
                            <table class="w-100">
                                <thead>
                                    <tr>
                                        <th>Sub Account</th>
                                        <th>Closing Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subAccounts as $key=>$subAccount)
                                    @if ($subAccount->transaction_type == 'credit')
                                        <tr>
                                            <td>{{$subAccount->title}}</td>
                                            <td>{{$subAccount->opening_balance}}</td>
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
                        <tr>
                            <td class="text-center h5">Total</td>
                            <td class="h5">400</td>
                        </tr>
                    </tbody>
                </table>
            </td>

            <td>
                <table class="w-100">
                    <tbody>
                        <tr>
                            <td class="text-center h5">Total</td>
                            <td class="h5">400</td>
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


