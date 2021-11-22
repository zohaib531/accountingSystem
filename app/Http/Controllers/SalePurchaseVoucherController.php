<?php

namespace App\Http\Controllers;

use App\Account;
use App\DetailVoucher;
use App\Product;
use App\SalePurchaseVoucher;
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

        $sale_purchase_vouchers = Product::join('sale_purchase_vouchers', 'products.id', 'sale_purchase_vouchers.product_id')
            ->join('sub_accounts', 'sub_accounts.id', 'sale_purchase_vouchers.account')
            ->select('products.title as product_title', 'products.*', 'sale_purchase_vouchers.*', 'sub_accounts.*', 'sale_purchase_vouchers.id as salePurchaseID')
            ->get();
        $subAccounts = SubAccount::select('id', 'title')->get();
        $products = Product::select('id', 'title')->get();
        $data = [
            'subAccounts' => $subAccounts,
            'products' => $products,
            'sale_purchase_vouchers' => $sale_purchase_vouchers,
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
            'debit_total' => 'required|same:credit_total',
            'credit_total' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $sale_purchase_voucher = new Voucher();
        $sale_purchase_voucher->date = $request->date;
        $sale_purchase_voucher->naration = $request->naration;
        $sale_purchase_voucher->debit_total = $request->debit_total;
        $sale_purchase_voucher->credit_total = $request->credit_total;
        $sale_purchase_voucher->voucher_type = $request->voucher_type;
        $sale_purchase_voucher->save();
        foreach ($request->credits as $key => $credit) {
            $sale_purchase_voucher_detail = new DetailVoucher();
            $sale_purchase_voucher_detail->voucher_id = $sale_purchase_voucher->id;
            $sale_purchase_voucher_detail->product_id = isset($request->product_ids[$key])?$request->product_ids[$key]:'';
            $sale_purchase_voucher_detail->account = isset($request->accounts[$key])?$request->accounts[$key]:'';
            $sale_purchase_voucher_detail->transaction_type = isset($request->transaction_types[$key])?$request->transaction_types[$key]:'';

            $sale_purchase_voucher_detail->save();

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
        $sale_purchase_voucher = SalePurchaseVoucher::where('id', $id)->first();
        // return $sale_purchase_voucher;
        $subAccounts = SubAccount::select('id', 'title')->get();
        $products = Product::select('id', 'title')->get();
        $data = [
            'subAccounts' => $subAccounts,
            'products' => $products,
            'sale_purchase_voucher' => $sale_purchase_voucher,
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
    public function update(Request $request, SalePurchaseVoucher $salePurchaseVoucher, $id)
    {
        // return $id;

        $validations = Validator::make($request->all(), [
            'date' => 'required',
            'product_id' => 'required',
            'account' => 'required',
            'transaction_type' => 'required',
            'debit.*' => 'required',
            'credit.*' => 'required',
            'debit_total' => 'required',
            'credit_total' => 'required|same:debit_total',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        SalePurchaseVoucher::where('id', $id)->update([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'account' => $request->account,
            'debit_total' => $request->debit_total,
            'transaction_type' => $request->transaction_type,
            'credit_total' => $request->credit_total,


        ]);
        return response()->json(['success' => true, 'message' => 'Sale/Purchase voucher has been added successfully']);
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
