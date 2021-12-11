<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Voucher;
use App\VoucherDetail;
use App\SubAccount;
use Carbon\Carbon;

class PartyAccountLedgerController extends Controller
{
    public function index()
    {
        $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.reports.partyAccountLedger.index',compact('subAccounts'));
    }

    // get data for trial balance
    public function entriesBetweenDates(Request $request){
        $validations = Validator::make($request->all(), ['sub_account'=>'required','start_date' => 'required','end_date' => 'required|after_or_equal:start_date']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}
        $vouchers = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[Carbon::createFromFormat('d / m / Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d / m / Y', $request->end_date)->format('Y-m-d')])->orderBy('date','asc')->get();
        $totalDebit = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[Carbon::createFromFormat('d / m / Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d / m / Y', $request->end_date)->format('Y-m-d')])->sum('debit_amount');
        $totalCredit = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[Carbon::createFromFormat('d / m / Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d / m / Y', $request->end_date)->format('Y-m-d')])->sum('credit_amount');
        $subAccount = SubAccount::where('id', $request->sub_account)->first();
        return response()->json(['success' => true, 'html' => view('admin.reports.partyAccountLedger.get_data',compact('vouchers','totalDebit','totalCredit','subAccount'))->render()]);
    }
}
