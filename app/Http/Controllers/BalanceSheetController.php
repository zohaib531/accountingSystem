<?php

namespace App\Http\Controllers;

use App\SubAccount;
use App\VoucherDetail;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.balanceSheet.index');
    }


    public function entriesBetweenDates(Request $request){
        $validations = Validator::make($request->all(), ['start_date' => 'required','end_date' => 'required|after_or_equal:start_date']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}
        $vouchers = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[Carbon::createFromFormat('d / m / Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d / m / Y', $request->end_date)->format('Y-m-d')])->orderBy('date','asc')->get();
        $totalDebit = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[Carbon::createFromFormat('d / m / Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d / m / Y', $request->end_date)->format('Y-m-d')])->sum('debit_amount');
        $totalCredit = VoucherDetail::where('sub_account_id',$request->sub_account)->whereBetween('date',[Carbon::createFromFormat('d / m / Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d / m / Y', $request->end_date)->format('Y-m-d')])->sum('credit_amount');
        $subAccounts = SubAccount::all();
        $endDate = Carbon::createFromFormat('d / m / Y', $request->end_date)->format('Y-m-d');
        return response()->json(['success' => true, 'html' => view('admin.balanceSheet.get_data',compact('vouchers','totalDebit','totalCredit','subAccounts','endDate'))->render()]);
    }
}
