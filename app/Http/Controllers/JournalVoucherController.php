<?php

namespace App\Http\Controllers;

use App\Account;
use App\Voucher;
use App\VoucherDetail;
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
        $journal_vouchers = Voucher::where('voucher_type','journal_voucher')->get();
        return view('admin.vouchers.journal.index', ['subAccounts' => $subAccounts,'journal_vouchers' => $journal_vouchers]);
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
            'narations.*' => 'required',
            'accounts.*' => 'required',
            'debits.*' => 'required',
            'credits.*' => 'required',
            'transaction_types.*' => 'required',
            'total_debit' => 'required|same:total_credit',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $journal_voucher = new Voucher();
        $journal_voucher->date = $request->date;
        $journal_voucher->voucher_type = "journal_voucher";
        $journal_voucher->total_debit = $request->total_debit;
        $journal_voucher->total_credit = $request->total_credit;
        if($journal_voucher->save()){
            if(count($request->accounts)>0){
                foreach ($request->accounts as $key => $account) {
                    $VoucherDetail = new VoucherDetail();
                    $VoucherDetail->voucher_id = $journal_voucher->id;
                    $VoucherDetail->sub_account_id = isset($request->accounts[$key])?$request->accounts[$key]:'';
                    $VoucherDetail->narration = isset($request->narrations[$key])?$request->narrations[$key]:'';
                    $VoucherDetail->transaction_type = isset($request->transaction_types[$key])?$request->transaction_types[$key]:'';
                    $VoucherDetail->debit_amount = isset($request->debits[$key])?$request->debits[$key]:0;
                    $VoucherDetail->credit_amount = isset($request->credits[$key])?$request->credits[$key]:0;
                    $VoucherDetail->entry_type = isset($request->debits[$key]) && $request->debits[$key]!=0?'debit':'credit';
                    $VoucherDetail->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Journal voucher has been added successfully']);
        }
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
        $voucher = Voucher::where('id', $id)->first();
        $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.vouchers.journal.edit', ['subAccounts' => $subAccounts,'voucher' => $voucher])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $validations = Validator::make($request->all(), [
            'date' => 'required',
            'narations.*' => 'required',
            'accounts.*' => 'required',
            'debits.*' => 'required',
            'credits.*' => 'required',
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
                    $VoucherDetail->narration = isset($request->narrations[$key])?$request->narrations[$key]:'';
                    $VoucherDetail->transaction_type = isset($request->transaction_types[$key])?$request->transaction_types[$key]:'';
                    $VoucherDetail->debit_amount = isset($request->debits[$key])?$request->debits[$key]:0;
                    $VoucherDetail->credit_amount = isset($request->credits[$key])?$request->credits[$key]:0;
                    $VoucherDetail->entry_type = isset($request->debits[$key]) && $request->debits[$key]!=0?'debit':'credit';
                    $VoucherDetail->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Journal voucher has been updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JournalVoucher  $journalVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($journalVoucher)
    {

        if (Voucher::where('id', $journalVoucher)->delete()) {
            return response()->json(['success' => true, 'message' => 'Voucher has been deleted successfully']);
        }
    }
}
