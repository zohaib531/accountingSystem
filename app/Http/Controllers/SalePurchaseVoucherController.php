<?php

namespace App\Http\Controllers;

use App\Account;
use App\Product;
use App\SalePurchaseVoucher;
use App\SubAccount;
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
            ->join('sub_accounts', 'sub_accounts.id', 'sale_purchase_vouchers.debit_account')
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
            'product_id' => 'required',
            'debit_account' => 'required',
            'debit_quantity' => 'required',
            'debit_rate' => 'required',
            'debit_amount' => 'required|same:credit_amount',
            'debit_transaction_type' => 'required',
            'credit_account' => 'required',
            'credit_quantity' => 'required',
            'credit_rate' => 'required',
            'credit_amount' => 'required',
            'credit_transaction_type' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $sale_purchase_voucher = new SalePurchaseVoucher();
        $sale_purchase_voucher->date = $request->date;
        $sale_purchase_voucher->product_id = $request->product_id;
        $sale_purchase_voucher->debit_account = $request->debit_account;
        $sale_purchase_voucher->debit_quantity = $request->debit_quantity;
        $sale_purchase_voucher->debit_rate = $request->debit_rate;
        $sale_purchase_voucher->debit_amount = $request->debit_amount;
        $sale_purchase_voucher->debit_transaction_type = $request->debit_transaction_type;
        $sale_purchase_voucher->credit_account = $request->credit_account;
        $sale_purchase_voucher->credit_quantity = $request->credit_quantity;
        $sale_purchase_voucher->credit_rate = $request->credit_rate;
        $sale_purchase_voucher->credit_amount = $request->credit_amount;
        $sale_purchase_voucher->credit_transaction_type = $request->credit_transaction_type;

        $sale_purchase_voucher->save();

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
            'debit_account' => 'required',
            'debit_quantity' => 'required',
            'debit_rate' => 'required',
            'debit_amount' => 'required',
            'debit_transaction_type' => 'required',
            'credit_account' => 'required',
            'credit_quantity' => 'required',
            'credit_rate' => 'required',
            'credit_amount' => 'required|same:debit_amount',
            'credit_transaction_type' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        SalePurchaseVoucher::where('id', $id)->update([
            'date' => $request->date,
            'product_id' => $request->product_id,
            'debit_account' => $request->debit_account,
            'debit_quantity' => $request->debit_quantity,
            'debit_rate' => $request->debit_rate,
            'debit_amount' => $request->debit_amount,
            'debit_transaction_type' => $request->debit_transaction_type,
            'credit_account' => $request->credit_account,
            'credit_quantity' => $request->credit_quantity,
            'credit_rate' => $request->credit_rate,
            'credit_amount' => $request->credit_amount,
            'credit_transaction_type' => $request->credit_transaction_type,


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
