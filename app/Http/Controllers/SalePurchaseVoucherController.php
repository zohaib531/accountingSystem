<?php

namespace App\Http\Controllers;

use App\Account;
use App\VoucherDetail;
use App\Product;
use App\SubAccount;
use App\Voucher;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests\SalePurchaseVoucherRequest;
use Carbon\Carbon;

class SalePurchaseVoucherController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return $request;
        $vouchers = Voucher::where('voucher_type','sale_purchase_voucher')->get();
        $products = Product::select('id', 'title','narration','product_unit')->get();
        $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.vouchers.list.salePurchase', compact('vouchers','products','subAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subAccounts = SubAccount::select('id', 'title')->get();
        $products = Product::select('id', 'title','narration','product_unit')->get();
        $data = [
            'subAccounts' => $subAccounts,
            'products' => $products,
        ];
        return view('admin.vouchers.salePurchase.create' , $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(),$this->rules($request),$this->messages($request));
        if ($validations->fails()) {return response()->json(['success' => false, 'message' => $validations->errors()]);}
        $sale_purchase_voucher = new Voucher();
        $sale_purchase_voucher->date = Carbon::createFromFormat('d / m / y', $request->date)->format('Y-m-d');
        $sale_purchase_voucher->total_debit = str_replace(',','',$request->total_debit);
        $sale_purchase_voucher->total_credit = str_replace(',','',$request->total_credit);
        $sale_purchase_voucher->save();
        $this->commonCode($sale_purchase_voucher,false,$request);
        return response()->json(['success' => true, 'message' => 'Sale/Purchase voucher has been added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalePurchaseVoucher  $salePurchaseVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(SalePurchaseVoucher $salePurchaseVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalePurchaseVoucher  $salePurchaseVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale_purchase_voucher = Voucher::where('id', $id)->first();
        $subAccounts = SubAccount::select('id', 'title')->get();
        $products = Product::select('id', 'title','narration','product_unit')->get();
        $data = [
            'subAccounts' => $subAccounts,
            'products' => $products,
            'voucher' => $sale_purchase_voucher,
        ];
        return view('admin.vouchers.salePurchase.edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalePurchaseVoucher  $salePurchaseVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $validations = Validator::make($request->all(),$this->rules($request),$this->messages($request));
        if ($validations->fails()) {return response()->json(['success' => false, 'message' => $validations->errors()]);}
        $sale_purchase_voucher = Voucher::find($id);
        $sale_purchase_voucher->date = Carbon::createFromFormat('d / m / y', $request->date)->format('Y-m-d') ;
        $sale_purchase_voucher->total_debit = str_replace(',','',$request->total_debit);
        $sale_purchase_voucher->total_credit = str_replace(',','',$request->total_credit);
        $sale_purchase_voucher->save();
        $this->commonCode($sale_purchase_voucher,true,$request);
        return response()->json(['success' => true, 'message' => 'Sale purchase voucher has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalePurchaseVoucher  $salePurchaseVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Voucher::where('id', $id)->delete()) {
            return response()->json(['success' => true, 'message' => 'Sale/Purchase voucher has been deleted successfully']);
        }
    }

    private function filterSalePurchaseVoucher($sub_account , $product_narration , $entry_type){

    }







    // suspense entry common code
    private function suspenseEntryCommonCode($voucher,$action,$request){
        $check = false;
        $remainingBalance = 0;
        $remainingBalanceType = '';
        if($action && str_replace(',','',$request->suspense_amount) > 0 && (array_sum(str_replace(',','',array_values($request->debit_amounts)))>array_sum(str_replace(',','',array_values($request->credit_amounts))) || array_sum(str_replace(',','',array_values($request->credit_amounts)))>array_sum(str_replace(',','',array_values($request->debit_amounts))))){
            $suspenseEntryDetail = $voucher->voucherDetails()->where('suspense_account','1')->first() !=null ?$voucher->voucherDetails()->where('suspense_account','1')->first():new VoucherDetail();
            $check = true;
        }else if($action && str_replace(',','',$request->suspense_amount) > 0 && (array_sum(str_replace(',','',array_values($request->debit_amounts)))==array_sum(str_replace(',','',array_values($request->credit_amounts))))){
            if($voucher->voucherDetails()->where('suspense_account','1')->first() !=null){
                VoucherDetail::where('id',$voucher->voucherDetails()->where('suspense_account','1')->first()->id)->delete();
            }
        }else if(!$action && str_replace(',','',$request->suspense_amount) > 0 && (array_sum(str_replace(',','',array_values($request->debit_amounts)))>array_sum(str_replace(',','',array_values($request->credit_amounts))) || array_sum(str_replace(',','',array_values($request->credit_amounts)))>array_sum(str_replace(',','',array_values($request->debit_amounts))))){
            $suspenseEntryDetail = new VoucherDetail();
            $check = true;
        }
        $openingBalance = isset($request->suspense_account) && isset($request->suspense_date)? getOpeningBalance($request->suspense_account,$request->suspense_date,false,0)["opening_balance"]:0;
        $transactionType = isset($request->suspense_account) && isset($request->suspense_date)? getOpeningBalance($request->suspense_account,$request->suspense_date,false,0)["opening_balance_type"]:'';

        if($transactionType=="debit" && $request->suspense_entry=="debit"){
            $remainingBalance = $openingBalance + str_replace(',','',$request->suspense_amount);
            $remainingBalanceType = "debit";
        } else if($transactionType=="credit" && $request->suspense_entry=="debit"){
            if($openingBalance >= str_replace(',','',$request->suspense_amount)){
                $remainingBalance = $openingBalance - str_replace(',','',$request->suspense_amount);
                $remainingBalanceType = "credit";
            }else if($openingBalance < str_replace(',','',$request->suspense_amount)){
                $remainingBalance = str_replace(',','',$request->suspense_amount) - $openingBalance;
                $remainingBalanceType = "debit";
            }
        } else if($transactionType=="credit" && $request->suspense_entry=="credit"){
            $remainingBalance = $openingBalance + str_replace(',','',$request->suspense_amount);
            $remainingBalanceType = "credit";
        } else if($transactionType=="debit" && $request->suspense_entry=="credit"){
            if($openingBalance >= str_replace(',','',$request->suspense_amount)){
                $remainingBalance = $openingBalance - str_replace(',','',$request->suspense_amount);
                $remainingBalanceType = "debit";
            }else if($openingBalance < str_replace(',','',$request->suspense_amount)){
                $remainingBalance = str_replace(',','',$request->suspense_amount) - $openingBalance;
                $remainingBalanceType = "credit";
            }
        }

        if($check){
            $str = $request->suspense_entry."_amount";
            $suspenseEntryDetail->voucher_id = $voucher->id;
            $suspenseEntryDetail->date = Carbon::createFromFormat('d / m / y', $request->suspense_date)->format('Y-m-d');
            $suspenseEntryDetail->sub_account_id = $request->suspense_account;
            $suspenseEntryDetail->$str = str_replace(',','',$request->suspense_amount);
            $suspenseEntryDetail->entry_type = $request->suspense_entry;
            // $suspenseEntryDetail->opening_balance = $openingBalance;
            // $suspenseEntryDetail->opening_balance_type = $transactionType;
            $suspenseEntryDetail->remaining_balance = $remainingBalance;
            $suspenseEntryDetail->remaining_balance_type = $remainingBalanceType;
            $suspenseEntryDetail->suspense_account = '1';
            $suspenseEntryDetail->save();
        }

    }

    // create/update common code
    private function commonCode($voucher,$action,$request)
    {
        if(isset($request->debit_dates) && count($request->debit_dates) >0){
            foreach ($request->debit_dates as $key => $credit) {
                $remainingBalance = 0;
                $remainingBalanceType = '';
                if($action){
                    VoucherDetail::whereIn('id',array_values(array_diff(Voucher::find($voucher->id)->voucherDetails()->where('entry_type','debit')->where('suspense_account','0')->pluck('id')->toArray(),$request->debit_voucher_detail_ids)))->delete();
                    $VoucherDetail = isset($request->debit_voucher_detail_ids[$key])? VoucherDetail::find($request->debit_voucher_detail_ids[$key]): new VoucherDetail();
                }else{
                    $VoucherDetail = new VoucherDetail();
                }

                $openingBalance =  getOpeningBalance($request->debit_accounts[$key],$request->debit_dates[$key],false,0)["opening_balance"];
                $transactionType = getOpeningBalance($request->debit_accounts[$key],$request->debit_dates[$key],false,0)["opening_balance_type"];
                if($transactionType=="debit"){
                    $remainingBalance = $openingBalance + str_replace(',','',$request->debit_amounts[$key]);
                    $remainingBalanceType = "debit";
                } else if($transactionType=="credit"){
                    if($openingBalance >= str_replace(',','',$request->debit_amounts[$key])){
                        $remainingBalance = $openingBalance - str_replace(',','',$request->debit_amounts[$key]);
                        $remainingBalanceType = "credit";
                    }else if($openingBalance < str_replace(',','',$request->debit_amounts[$key])){
                        $remainingBalance = str_replace(',','',$request->debit_amounts[$key]) - $openingBalance;
                        $remainingBalanceType = "debit";
                    }
                }

                $VoucherDetail->voucher_id = $voucher->id;
                $VoucherDetail->date = isset($request->debit_dates[$key])? Carbon::createFromFormat('d / m / y', $request->debit_dates[$key])->format('Y-m-d'):'';
                $VoucherDetail->product_narration = isset($request->debit_products[$key])?$request->debit_products[$key]:'';
                $VoucherDetail->sub_account_id = isset($request->debit_accounts[$key])?$request->debit_accounts[$key]:'';
                $VoucherDetail->debit_amount = isset($request->debit_amounts[$key])?str_replace(',','',$request->debit_amounts[$key]):0;
                // $VoucherDetail->opening_balance = $openingBalance;
                // $VoucherDetail->opening_balance_type = $transactionType;
                $VoucherDetail->remaining_balance = $remainingBalance;
                $VoucherDetail->remaining_balance_type = $remainingBalanceType;
                $VoucherDetail->quantity = isset($request->debit_quantities[$key])?str_replace(',','',$request->debit_quantities[$key]):'';
                $VoucherDetail->rate = isset($request->debit_rates[$key])?str_replace(',','',$request->debit_rates[$key]):0;
                $VoucherDetail->entry_type = 'debit';
                $VoucherDetail->save();
            }
        }

        if(isset($request->credit_dates) && count($request->credit_dates) >0){
            foreach ($request->credit_dates as $key => $credit) {
                $remainingBalance = 0;
                $remainingBalanceType = '';
                if($action){
                    VoucherDetail::whereIn('id',array_values(array_diff(Voucher::find($voucher->id)->voucherDetails()->where('entry_type','credit')->where('suspense_account','0')->pluck('id')->toArray(),$request->credit_voucher_detail_ids)))->delete();
                    $VoucherDetail = isset($request->credit_voucher_detail_ids[$key])? VoucherDetail::find($request->credit_voucher_detail_ids[$key]): new VoucherDetail();
                }else{
                    $VoucherDetail = new VoucherDetail();
                }

                $openingBalance = getOpeningBalance($request->credit_accounts[$key],$request->credit_dates[$key],false,0)["opening_balance"];
                $transactionType = getOpeningBalance($request->credit_accounts[$key],$request->credit_dates[$key],false,0)["opening_balance_type"];
                if($transactionType=="credit"){
                    $remainingBalance = $openingBalance + str_replace(',','',$request->credit_amounts[$key]);
                    $remainingBalanceType = "credit";
                } else if($transactionType=="debit"){
                    if($openingBalance >= str_replace(',','',$request->credit_amounts[$key])){
                        $remainingBalance = $openingBalance - str_replace(',','',$request->credit_amounts[$key]);
                        $remainingBalanceType = "debit";
                    }else if($openingBalance < str_replace(',','',$request->credit_amounts[$key])){
                        $remainingBalance = str_replace(',','',$request->credit_amounts[$key]) - $openingBalance;
                        $remainingBalanceType = "credit";
                    }
                }

                $VoucherDetail->voucher_id = $voucher->id;
                $VoucherDetail->date = isset($request->credit_dates[$key])? Carbon::createFromFormat('d / m / y', $request->credit_dates[$key])->format('Y-m-d'):'';
                $VoucherDetail->product_narration = isset($request->credit_products[$key])?$request->credit_products[$key]:'';
                $VoucherDetail->sub_account_id = isset($request->credit_accounts[$key])?$request->credit_accounts[$key]:'';
                $VoucherDetail->credit_amount = isset($request->credit_amounts[$key])?str_replace(',','',$request->credit_amounts[$key]):0;
                // $VoucherDetail->opening_balance = $openingBalance;
                // $VoucherDetail->opening_balance_type = $transactionType;
                $VoucherDetail->remaining_balance = $remainingBalance;
                $VoucherDetail->remaining_balance_type = $remainingBalanceType;
                $VoucherDetail->quantity = isset($request->credit_quantities[$key])?str_replace(',','',$request->credit_quantities[$key]):'';
                $VoucherDetail->rate = isset($request->credit_rates[$key])?str_replace(',','',$request->credit_rates[$key]):0;
                $VoucherDetail->entry_type = 'credit';
                $VoucherDetail->save();
            }
        }
        $this->suspenseEntryCommonCode($voucher,$action,$request);
    }

    // get rules for create and update
    private function rules($request)
    {
        $rules = [
            "credit_dates.*"  => ['required'],
            "credit_accounts.*"  => ['required'],
            "credit_products.*"  => ['required'],
            "credit_quantities.*"  => ['required'],
            "credit_rates.*"  => ['required'],
            "credit_amounts.*"  => ['required'],
            "debit_dates.*"  => ['required'],
            "debit_accounts.*"  => ['required'],
            "debit_products.*"  => ['required'],
            "debit_quantities.*"  => ['required'],
            "debit_rates.*"  => ['required'],
            "debit_amounts.*"  => ['required'],
            "total_debit" => ['required','same:total_credit']
        ];

        if($request->suspense_amount > 0 && (array_sum($request->debit_amounts)>array_sum($request->credit_amounts) || array_sum($request->credit_amounts)>array_sum($request->debit_amounts))){
            $rules['suspense_date'] = ['required'];
            $rules['suspense_account'] = ['required'];
            $rules['suspense_entry_check'] = ['required'];
        }

        return $rules;
    }

    // error messages for validation
    private function messages($request)
    {
        $messages = [];
        foreach($request->all() as $key=>$value){
            if(is_array($value)){
                foreach ($value as $k => $v) {
                    $arr = explode('_',$key);
                    $first = ucfirst($arr[0]);
                    $second = $arr[1]=="quantities"? str_replace('ies','y',$arr[1]):str_replace('s','',$arr[1]);
                    $kkk = $k + 1;
                    $messages["$key.$k.required"] = " $first entry number $kkk $second field is required";
                }
            }
        }
        return $messages;
    }

}
