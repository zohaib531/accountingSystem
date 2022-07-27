<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-categories', ['only' => ['index']]);
        $this->middleware('permission:create-category', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::all();
        return view('admin.accounts.index',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.accounts.create');
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
            'title'=>'required || unique:accounts,title,NULL,id,deleted_at,NULL'
        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }


        $account = new Account();
        $account->title = $request->title;
        $account->created_by = Auth::user()->id;
        if($account->save()){
            $account->code =  str_pad($account->id, 2, '0', STR_PAD_LEFT);
            $account->save();
            return response()->json(['success' => true, 'message' =>'General Account has been added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = Account::where('id',$id)->first();
        return view('admin.accounts.edit',compact('account'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validations = Validator::make($request->all(),[
            'title'=>'required || unique:accounts,title,NULL,id,deleted_at,NULL'.$id,
        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $account = Account::find($id);
        $account->title = $request->title;
        $account->created_by = Auth::user()->id;
        if($account->save()){
            return response()->json(['success' => true, 'message' =>'General Account has been updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Account::where('id',$id)->whereHas('get_sub_accounts')->exists()){
            if(Account::where('id',$id)->delete()){
                return response()->json(['success' => true, 'message' =>'General Account has been deleted successfully']);
            }
        }else{
            return response()->json(['success' => false , 'redirect'=>false , 'message' =>'Please delete Sub Accounts first ']);
        }
    }
}
