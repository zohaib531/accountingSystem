<?php

namespace App\Http\Controllers;

use App\Account;
use App\SubAccount;
use Illuminate\Http\Request;
use Validator;

class SubAccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-sub-accounts', ['only' => ['index']]);
        $this->middleware('permission:create-sub-account', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-sub-account', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-sub-account', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::all();
        $subAccounts = SubAccount::with('get_account')->get();
        return view('admin.subAccounts.index',compact('accounts','subAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::all();
        return view('admin.subAccounts.create',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(),[
            'title'=>'required || unique:sub_accounts',
            'account_id'=>'required',
            'opening_balance'=>'required'
        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $subAccounts = new SubAccount();
        $subAccounts->title = $request->title;
        $subAccounts->account_id = $request->account_id;
        $subAccounts->opening_balance = $request->opening_balance;
        if($subAccounts->save()){
            $subAccounts->code =  $subAccounts->id;
            $subAccounts->save();
            return response()->json(['success' => true, 'message' =>'Sub Accounts has been added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subaccount  $subaccount
     * @return \Illuminate\Http\Response
     */
    public function show(SubAccount $subAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subaccount  $subaccount
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $accounts = Account::all();
        $subAccount = SubAccount::where('id',$id)->first();
        return view('admin.subAccounts.edit',compact('accounts','subAccount'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subaccount  $subaccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubAccount $subAccount)
    {
        $validations = Validator::make($request->all(),[
            'title'=>'required || unique:sub_accounts,title,'.$subAccount->id,
            'account_id'=>'required',
            'opening_balance'=>'required',

        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $subAccount->title = $request->title;
        $subAccount->account_id = $request->account_id;
        $subAccount->opening_balance = $request->opening_balance;
        if($subAccount->save()){

            return response()->json(['success' => true, 'message' =>'Sub Accounts has been updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubAccount  $subaccount
     * @return \Illuminate\Http\Response
     */
    public function destroy($subAccount)
    {
        if(SubAccount::where('id',$subAccount)->delete()){
            return response()->json(['success' => true, 'message' =>'Sub Accounts has been deleted successfully']);
        }
    }
}
