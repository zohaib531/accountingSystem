<?php

namespace App\Http\Controllers;

use App\Account;
use App\VoucherDetail;
use App\Product;
use App\SubAccount;
use App\Voucher;
use Validator;
use Illuminate\Http\Request;

class SalePurchaseVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $vouchers = Product::join('vouchers', 'products.id', 'vouchers.product_id')
        //     ->join('sub_accounts', 'sub_accounts.id', 'vouchers.account')
        //     ->select('products.title as product_title', 'products.*', 'vouchers.*', 'sub_accounts.*', 'vouchers.id as salePurchaseID')
        //     ->get();
        $vouchers = Voucher::where('voucher_type','sale_purchase_voucher')->get();
        $subAccounts = SubAccount::select('id', 'title')->get();
        $products = Product::select('id', 'title','narration')->get();
        $data = [
            'subAccounts' => $subAccounts,
            'products' => $products,
            'vouchers' => $vouchers,
        ];
        return view('admin.vouchers.salePurchase.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vouchers.salePurchase.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            'date' => 'required',
            'credit_accounts' => 'required|array',
            'credit_accounts.*' => 'required',
            'credit_products' => 'required|array',
            'credit_products.*' => 'required',
            'credit_quantities' => 'required|array',
            'credit_quantities.*' => 'required',
            'credit_rates' => 'required|array',
            'credit_rates.*' => 'required',
            'credit_amounts' => 'required|array',
            'credit_amounts.*' => 'required',
            'debit_accounts' => 'required|array',
            'debit_accounts.*' => 'required',
            'debit_products' => 'required|array',
            'debit_products.*' => 'required',
            'debit_quantities' => 'required|array',
            'debit_quantities.*' => 'required',
            'debit_rates' => 'required|array',
            'debit_rates.*' => 'required',
            'debit_amounts' => 'required|array',
            'debit_amounts.*' => 'required',
            'total_debit' => 'required|same:total_credit',
            'total_credit' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $sale_purchase_voucher = new Voucher();
        $sale_purchase_voucher->date = $request->date;
        $sale_purchase_voucher->total_debit = $request->total_debit;
        $sale_purchase_voucher->total_credit = $request->total_credit;
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
        $products = Product::select('id', 'title','narration')->get();
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
        $validations = Validator::make($request->all(), [
            'date' => 'required',
            'products' => 'required|array',
            'products.*' => 'required',
            'accounts' => 'required|array',
            'accounts.*' => 'required',
            'debits.*' => 'required',
            'credits.*' => 'required',
            'transaction_types' => 'required|array',
            'transaction_types.*' => 'required',
            'total_debit' => 'required|same:total_credit',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $journal_voucher = Voucher::find($id);
        $journal_voucher->date = $request->date;
        $journal_voucher->total_debit = $request->total_debit;
        $journal_voucher->total_credit = $request->total_credit;
        if($journal_voucher->save()){
            if(count($request->accounts)>0){
                VoucherDetail::whereIn('id',array_values(array_diff(Voucher::find($id)->voucherDetails()->pluck('id')->toArray(),$request->voucher_detail_ids)))->delete();
                foreach ($request->accounts as $key => $account) {
                    $VoucherDetail = isset($request->voucher_detail_ids[$key])? VoucherDetail::find($request->voucher_detail_ids[$key]): new VoucherDetail();
                    $VoucherDetail->voucher_id = $journal_voucher->id;
                    $VoucherDetail->sub_account_id = isset($request->accounts[$key])?$request->accounts[$key]:'';
                    $VoucherDetail->product_id = isset($request->products[$key])?$request->products[$key]:'';
                    $VoucherDetail->transaction_type = isset($request->transaction_types[$key])?$request->transaction_types[$key]:'';
                    $VoucherDetail->debit_amount = isset($request->debits[$key])?$request->debits[$key]:0;
                    $VoucherDetail->credit_amount = isset($request->credits[$key])?$request->credits[$key]:0;
                    $VoucherDetail->entry_type = isset($request->debits[$key]) && $request->debits[$key]!=0?'debit':'credit';
                    $VoucherDetail->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Sale purchase voucher has been updated successfully']);
        }
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

    // create/update common code
    private function commonCode($voucher,$action,$request)
    {
        if(isset($request->debit_dates) && count($request->debit_dates) >0){
            foreach ($request->debit_dates as $key => $credit) {
                $detail_vouchers = new VoucherDetail();
                $detail_vouchers->voucher_id = $voucher->id;
                $detail_vouchers->product_narration = isset($request->debit_products[$key])?$request->debit_products[$key]:'';
                $detail_vouchers->sub_account_id = isset($request->debit_accounts[$key])?$request->debit_accounts[$key]:'';
                $detail_vouchers->debit_amount = isset($request->debit_amounts[$key])?$request->debit_amounts[$key]:0;
                $detail_vouchers->quantity = isset($request->debit_quantities[$key])?$request->debit_quantities[$key]:'';
                $detail_vouchers->rate = isset($request->debit_rates[$key])?$request->debit_rates[$key]:0;
                $detail_vouchers->entry_type = 'credit';
                $detail_vouchers->save();
            }
        }

        if(isset($request->credit_dates) && count($request->credit_dates) >0){
            foreach ($request->credit_dates as $key => $credit) {
                $detail_vouchers = new VoucherDetail();
                $detail_vouchers->voucher_id = $voucher->id;
                $detail_vouchers->product_narration = isset($request->credit_products[$key])?$request->credit_products[$key]:'';
                $detail_vouchers->sub_account_id = isset($request->credit_accounts[$key])?$request->credit_accounts[$key]:'';
                $detail_vouchers->credit_amount = isset($request->credit_amounts[$key])?$request->credit_amounts[$key]:0;
                $detail_vouchers->quantity = isset($request->credit_quantities[$key])?$request->credit_quantities[$key]:'';
                $detail_vouchers->rate = isset($request->credit_rates[$key])?$request->credit_rates[$key]:0;
                $detail_vouchers->entry_type = 'credit';
                $detail_vouchers->save();
            }
        }
    }
}
