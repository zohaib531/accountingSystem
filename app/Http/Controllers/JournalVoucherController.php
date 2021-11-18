<?php

namespace App\Http\Controllers;

use App\Account;
use App\JournalVoucher;
use App\SubAccount;
use Validator;
use Illuminate\Http\Request;

class JournalVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $subAccounts = SubAccount::select('id', 'title')->get();
        $journal_vouchers = JournalVoucher::all();
        $data = [
            'subAccounts' => $subAccounts,
            'journal_vouchers' => $journal_vouchers,
        ];
        return view('admin.vouchers.journal.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vouchers.journal.create');
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
            'naration' => 'required',
            'debit_account_id' => 'required',
            'debit_amount' => 'required',
            'debit_transaction_type' => 'required',
            'credit_account_id' => 'required',
            'credit_amount' => 'required|same:debit_amount',
            'credit_transaction_type' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $journal_voucher = new JournalVoucher();
        $journal_voucher->date = $request->date;
        $journal_voucher->naration = $request->naration;
        $journal_voucher->debit_account_id = $request->debit_account_id;
        $journal_voucher->debit_amount = $request->debit_amount;
        $journal_voucher->debit_transaction_type = $request->debit_transaction_type;
        $journal_voucher->credit_account_id = $request->credit_account_id;
        $journal_voucher->credit_amount = $request->credit_amount;
        $journal_voucher->credit_transaction_type = $request->credit_transaction_type;

        $journal_voucher->save();
        return response()->json(['success' => true, 'message' => 'Journal voucher has been added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function show(JournalVoucher $journalVoucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $journal_voucher = JournalVoucher::where('id', $id)->first();
        // return $id;
        $subAccounts = SubAccount::select('id', 'title')->get();
        $data = [
            'subAccounts' => $subAccounts,
            'journal_voucher' => $journal_voucher,
        ];
        return view('admin.vouchers.journal.edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JournalVoucher $journalVoucher , $id)
    {
        $validations = Validator::make($request->all(), [
            'date' => 'required',
            'naration' => 'required',
            'debit_account_id' => 'required',
            'debit_amount' => 'required',
            'debit_transaction_type' => 'required',
            'credit_account_id' => 'required',
            'credit_amount' => 'required|same:debit_amount',
            'credit_transaction_type' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $journal_voucher = JournalVoucher::find($id);
        $journal_voucher->date = $request->date;
        $journal_voucher->naration = $request->naration;
        $journal_voucher->debit_account_id = $request->debit_account_id;
        $journal_voucher->debit_amount = $request->debit_amount;
        $journal_voucher->debit_transaction_type = $request->debit_transaction_type;
        $journal_voucher->credit_account_id = $request->credit_account_id;
        $journal_voucher->credit_amount = $request->credit_amount;
        $journal_voucher->credit_transaction_type = $request->credit_transaction_type;

        $journal_voucher->save();
        return response()->json(['success' => true, 'message' => 'Journal voucher has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($journalVoucher)
    {

        if (JournalVoucher::where('id', $journalVoucher)->delete()) {
            return response()->json(['success' => true, 'message' => 'Product has been deleted successfully']);
        }
    }
}
