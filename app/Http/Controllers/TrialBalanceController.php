<?php

namespace App\Http\Controllers;

use App\SubAccount;
use App\Account;
use App\User;
use App\VoucherDetail;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use mysqli;

class TrialBalanceController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $accounts = Account::select('id', 'title')->get();
        return view('admin.trialBalance.index', compact('accounts'));
    }

    // get trial balance of accounts
    // public function getTrialBalance(Request $request){
    //     $validations = Validator::make($request->all(), ['date' => 'required']);
    //     if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}
    //     $subAccounts = SubAccount::all();
    //     $endDate = Carbon::createFromFormat('d / m / y', $request->date)->format('y-m-d');
    //     return response()->json(['success' => true, 'html' => view('admin.trialBalance.get_data',compact('subAccounts','endDate'))->render()]);
    // }

    public function getTrialBalance(Request $request){

        $validations = Validator::make($request->all(), ['start_date' => 'required','end_date' => 'required|after_or_equal:start_date']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}
        // $vouchers = VoucherDetail::where('sub_account_id', 34)->whereBetween('date',[Carbon::createFromFormat('d / m / y', $request->start_date)->format('y-m-d'), Carbon::createFromFormat('d / m / y', $request->end_date)->format('y-m-d')])->orderBy('date','asc')->get();
        $startDate = Carbon::createFromFormat('d / m / y', $request->start_date)->format('y-m-d');
        $endDate = Carbon::createFromFormat('d / m / y', $request->end_date)->format('y-m-d');
        $vouchers = VoucherDetail::whereBetween('date',[$startDate, $endDate])->orderBy('date','asc')->get();
        $subAccounts = $request->account==null? SubAccount::all() : SubAccount::where('account_id', $request->account)->get();
        return response()->json(['success' => true, 'html' => view('admin.trialBalance.get_data',compact('vouchers','subAccounts','startDate','endDate'))->render()]);
    }

    public function checkPassword(Request $request){

        $validations = Validator::make($request->all(), ['password' => 'required']);
        if ($validations->fails()) { return response()->json(['success' => false, 'message' => $validations->errors()]);}

        if(Hash::check($request->password, Auth::user()->tb_password)){
            Session::put('Trial_Bal_Password_Check', 'This is check for password');
            return response()->json(['success' => true, 'message' => "Thanks for verification"]);
        }else{
            return response()->json(['success' => false, 'message' => ["Sorry! These credientials does not match with our record"]]);
        }
        // return $request->session()->has('TEST');
    }

    public function changePassword(Request $request){

        $validations = Validator::make($request->all(),[
            'old_password'=>'required',
            'new_password'=>['required','min:8','same:confirm_password'],

        ]);
        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }
        else{
            if(Hash::check($request->old_password, Auth::user()->tb_password)){

                $password = User::find(Auth::user()->id);
                $password->tb_password = Hash::make($request->new_password);
                $password->save();
                return response()->json(['success' => true, 'message' => "Password has been changed successfully"]);
            }
            else{
                return response()->json(['success' => false, 'message' => ["Old Password is wrong"]]);
            }
        }
    }



}
