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
            'products' => 'required|array',
            'products.*' => 'required',
            'accounts' => 'required|array',
            'accounts.*' => 'required',
            'debits.*' => 'required',
            'credits.*' => 'required',
            'transaction_types' => 'required|array',
            'transaction_types.*' => 'required',
            'total_debit' => 'required|same:total_credit',
            'total_credit' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        return "fds";

        $sale_purchase_voucher = new Voucher();
        $sale_purchase_voucher->date = $request->date;
        $sale_purchase_voucher->voucher_type = "sale_purchase_voucher";
        $sale_purchase_voucher->total_debit = $request->total_debit;
        $sale_purchase_voucher->total_credit = $request->total_credit;
        $sale_purchase_voucher->save();
        foreach ($request->credits as $key => $credit) {
            $detail_vouchers = new VoucherDetail();
            $detail_vouchers->voucher_id = $sale_purchase_voucher->id;
            $detail_vouchers->product_id = isset($request->products[$key])?$request->products[$key]:'';
            $detail_vouchers->sub_account_id = isset($request->accounts[$key])?$request->accounts[$key]:'';
            $detail_vouchers->transaction_type = isset($request->transaction_types[$key])?$request->transaction_types[$key]:'';
            $detail_vouchers->debit_amount = isset($request->debits[$key])?$request->debits[$key]:0;
            $detail_vouchers->credit_amount = isset($request->credits[$key])?$request->credits[$key]:0;
            $detail_vouchers->entry_type = isset($request->debits[$key]) && $request->debits[$key]!=0?'debit':'credit';
            $detail_vouchers->save();

        }

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
    public function destroy($salePurchaseVoucher)
    {
        if (SalePurchaseVoucher::where('id', $salePurchaseVoucher)->delete()) {
            return response()->json(['success' => true, 'message' => 'Sale/Purchase voucher has been deleted successfully']);
        }
    }
}
