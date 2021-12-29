<?php

namespace App\Http\Controllers;

use App\SubAccount;
use App\VoucherDetail;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;

class TrialBalanceController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        // $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.trialBalance.index');
    }

    // get trial balance of accounts
    public function getTrialBalance(Request $request){
        $validations = Validator::make($request->all(), ['date' => 'required']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}
        $subAccounts = SubAccount::all();
        $endDate = Carbon::createFromFormat('d / m / Y', $request->date)->format('Y-m-d');
        return response()->json(['success' => true, 'html' => view('admin.trialBalance.get_data',compact('subAccounts','endDate'))->render()]);
    }
}
