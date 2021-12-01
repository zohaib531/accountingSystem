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
        @if(isset($vouchers) && $vouchers->count()>0)
            @foreach($vouchers as $key=>$detail)
                <tr>
                    @php $str = $detail->entry_type."_amount";  @endphp
                    <td>{{date('d-m-Y',strtotime($detail->date))}}</td>
                    <td>{{$detail->product_narration}} (<span style="font-weight:bold;">{{$detail->quantity}} x {{$detail->rate}}</span>)</td>
                    <td>{{ $detail->debit_amount!=0?$detail->debit_amount:"" }}</td>
                    <td>{{ $detail->credit_amount!=0?$detail->credit_amount:"" }}</td>
                    <td>12000</td>
                    <td>12000</td>
                </tr>
            @endforeach

        @else
            <tr>
                <td colspan="6" class="text-center">No records found between these range</td>
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
          <td></td>
          <td></td>
          <td>{{$totalDebit}}</td>
          <td>{{$totalCredit}}</td>
          <td>Balance</td>
          <td>10000000</td>
        </tr>
      </tfoot>
</table>
