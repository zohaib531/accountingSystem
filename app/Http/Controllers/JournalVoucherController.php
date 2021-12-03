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
        $journal_vouchers = Voucher::where('voucher_type', 'journal_voucher')->get();
        return view('admin.vouchers.journal.index', ['subAccounts' => $subAccounts, 'journal_vouchers' => $journal_vouchers]);
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
        $validations = Validator::make($request->all(), $this->rules($request), $this->messages($request));
        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }
        $journal_voucher = new Voucher();
        $journal_voucher->date = $request->date;
        $journal_voucher->voucher_type = "journal_voucher";
        $journal_voucher->total_debit = $request->total_debit;
        $journal_voucher->total_credit = $request->total_credit;
        $journal_voucher->save();
        $this->commonCode($journal_voucher, false, $request);
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
        $voucher = Voucher::where('id', $id)->first();
        $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.vouchers.journal.edit', ['subAccounts' => $subAccounts, 'voucher' => $voucher])->render();
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
        $validations = Validator::make($request->all(), $this->rules($request), $this->messages($request));
        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }
        $journal_voucher = Voucher::find($id);
        $journal_voucher->date = $request->date;
        $journal_voucher->total_debit = $request->total_debit;
        $journal_voucher->total_credit = $request->total_credit;
        $journal_voucher->save();
        $this->commonCode($journal_voucher, true, $request);
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

        if (Voucher::where('id', $journalVoucher)->delete()) {
            return response()->json(['success' => true, 'message' => 'Voucher has been deleted successfully']);
        }
    }



    // suspense entry common code
    private function suspenseEntryCommonCode($voucher, $action, $request)
    {
        $check = false;
        $remainingBalance = 0;
        $remainingBalanceType = '';
        if ($action && $request->suspense_amount > 0 && (array_sum($request->debit_amounts) > array_sum($request->credit_amounts) || array_sum($request->credit_amounts) > array_sum($request->debit_amounts))) {
            $suspenseEntryDetail = $voucher->voucherDetails()->where('suspense_account', '1')->first() != null ? $voucher->voucherDetails()->where('suspense_account', '1')->first() : new VoucherDetail();
            $check = true;
        } else if ($action && (array_sum($request->debit_amounts) == array_sum($request->credit_amounts))) {
            if ($voucher->voucherDetails()->where('suspense_account', '1')->first() != null) {
                VoucherDetail::where('id', $voucher->voucherDetails()->where('suspense_account', '1')->first()->id)->delete();
            }
        } else if (!$action && $request->suspense_amount > 0 && (array_sum($request->debit_amounts) > array_sum($request->credit_amounts) || array_sum($request->credit_amounts) > array_sum($request->debit_amounts))) {
            $suspenseEntryDetail = new VoucherDetail();
            $check = true;
        }

        $openingBalance = isset($request->suspense_account)? getOpeningBalance($request->suspense_account,$request->suspense_date,false,0)["opening_balance"]:0;
        $transactionType = isset($request->suspense_account)? getOpeningBalance($request->suspense_account,$request->suspense_date,false,0)["opening_balance_type"]:'';

        if ($transactionType == "debit" && $request->suspense_entry == "debit") {
            $remainingBalance = $openingBalance + $request->suspense_amount;
            $remainingBalanceType = "debit";
        } else if ($transactionType == "credit" && $request->suspense_entry == "debit") {
            if ($openingBalance >= $request->suspense_amount) {
                $remainingBalance = $openingBalance - $request->suspense_amount;
                $remainingBalanceType = "credit";
            } else if ($openingBalance < $request->suspense_amount) {
                $remainingBalance = $request->suspense_amount - $openingBalance;
                $remainingBalanceType = "debit";
            }
        } else if ($transactionType == "credit" && $request->suspense_entry == "credit") {
            $remainingBalance = $openingBalance + $request->suspense_amount;
            $remainingBalanceType = "credit";
        } else if ($transactionType == "debit" && $request->suspense_entry == "credit") {
            if ($openingBalance >= $request->suspense_amount) {
                $remainingBalance = $openingBalance - $request->suspense_amount;
                $remainingBalanceType = "debit";
            } else if ($openingBalance < $request->suspense_amount) {
                $remainingBalance = $request->suspense_amount - $openingBalance;
                $remainingBalanceType = "credit";
            }
        }

        if ($check) {
            $str = $request->suspense_entry . "_amount";
            $suspenseEntryDetail->voucher_id = $voucher->id;
            $suspenseEntryDetail->date = $request->suspense_date;
            $suspenseEntryDetail->sub_account_id = $request->suspense_account;
            $suspenseEntryDetail->$str = $request->suspense_amount;
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
    private function commonCode($voucher, $action, $request)
    {
        if (isset($request->debit_dates) && count($request->debit_dates) > 0) {
            foreach ($request->debit_dates as $key => $credit) {
                $remainingBalance = 0;
                $remainingBalanceType = '';
                if ($action) {
                    VoucherDetail::whereIn('id', array_values(array_diff(Voucher::find($voucher->id)->voucherDetails()->where('entry_type', 'debit')->where('suspense_account', '0')->pluck('id')->toArray(), $request->debit_voucher_detail_ids)))->delete();
                    $VoucherDetail = isset($request->debit_voucher_detail_ids[$key]) ? VoucherDetail::find($request->debit_voucher_detail_ids[$key]) : new VoucherDetail();
                } else {
                    $VoucherDetail = new VoucherDetail();
                }

                $openingBalance =  getOpeningBalance($request->debit_accounts[$key],$request->debit_dates[$key],false,0)["opening_balance"];
                $transactionType = getOpeningBalance($request->debit_accounts[$key],$request->debit_dates[$key],false,0)["opening_balance_type"];
                
                if ($transactionType == "debit") {
                    $remainingBalance = $openingBalance + $request->debit_amounts[$key];
                    $remainingBalanceType = "debit";
                } else if ($transactionType == "credit") {
                    if ($openingBalance >= $request->debit_amounts[$key]) {
                        $remainingBalance = $openingBalance - $request->debit_amounts[$key];
                        $remainingBalanceType = "credit";
                    } else if ($openingBalance < $request->debit_amounts[$key]) {
                        $remainingBalance = $request->debit_amounts[$key] - $openingBalance;
                        $remainingBalanceType = "debit";
                    }
                }

                $VoucherDetail->voucher_id = $voucher->id;
                $VoucherDetail->date = isset($request->debit_dates[$key]) ? $request->debit_dates[$key] : '';
                $VoucherDetail->product_narration = isset($request->debit_narrations[$key]) ? $request->debit_narrations[$key] : '';
                $VoucherDetail->sub_account_id = isset($request->debit_accounts[$key]) ? $request->debit_accounts[$key] : '';
                $VoucherDetail->debit_amount = isset($request->debit_amounts[$key]) ? $request->debit_amounts[$key] : 0;
                // $VoucherDetail->opening_balance = $openingBalance;
                // $VoucherDetail->opening_balance_type = $transactionType;
                $VoucherDetail->remaining_balance = $remainingBalance;
                $VoucherDetail->remaining_balance_type = $remainingBalanceType;
                $VoucherDetail->entry_type = 'debit';
                $VoucherDetail->save();
            }
        }

        if (isset($request->credit_dates) && count($request->credit_dates) > 0) {
            foreach ($request->credit_dates as $key => $credit) {
                $remainingBalance = 0;
                $remainingBalanceType = '';
                if ($action) {
                    VoucherDetail::whereIn('id', array_values(array_diff(Voucher::find($voucher->id)->voucherDetails()->where('entry_type', 'credit')->where('suspense_account', '0')->pluck('id')->toArray(), $request->credit_voucher_detail_ids)))->delete();
                    $VoucherDetail = isset($request->credit_voucher_detail_ids[$key]) ? VoucherDetail::find($request->credit_voucher_detail_ids[$key]) : new VoucherDetail();
                } else {
                    $VoucherDetail = new VoucherDetail();
                }

                $openingBalance =  getOpeningBalance($request->credit_accounts[$key],$request->credit_dates[$key],false,0)["opening_balance"];
                $transactionType = getOpeningBalance($request->credit_accounts[$key],$request->credit_dates[$key],false,0)["opening_balance_type"];
                if ($transactionType == "credit") {
                    $remainingBalance = $openingBalance + $request->credit_amounts[$key];
                    $remainingBalanceType = "credit";
                } else if ($transactionType == "debit") {
                    if ($openingBalance >= $request->credit_amounts[$key]) {
                        $remainingBalance = $openingBalance - $request->credit_amounts[$key];
                        $remainingBalanceType = "debit";
                    } else if ($openingBalance < $request->credit_amounts[$key]) {
                        $remainingBalance = $request->credit_amounts[$key] - $openingBalance;
                        $remainingBalanceType = "credit";
                    }
                }

                $VoucherDetail->voucher_id = $voucher->id;
                $VoucherDetail->date = isset($request->credit_dates[$key]) ? $request->credit_dates[$key] : '';
                $VoucherDetail->product_narration = isset($request->credit_narrations[$key]) ? $request->credit_narrations[$key] : '';
                $VoucherDetail->sub_account_id = isset($request->credit_accounts[$key]) ? $request->credit_accounts[$key] : '';
                $VoucherDetail->credit_amount = isset($request->credit_amounts[$key]) ? $request->credit_amounts[$key] : 0;
                // $VoucherDetail->opening_balance = $openingBalance;
                // $VoucherDetail->opening_balance_type = $transactionType;
                $VoucherDetail->remaining_balance = $remainingBalance;
                $VoucherDetail->remaining_balance_type = $remainingBalanceType;
                $VoucherDetail->entry_type = 'credit';
                $VoucherDetail->save();

            }
        }
        $this->suspenseEntryCommonCode($voucher, $action, $request);
        
    }


    // get rules for create and update
    private function rules($request)
    {
        $rules = [
            "credit_dates.*"  => ['required'],
            "credit_accounts.*"  => ['required'],
            "credit_narations.*"  => ['required'],
            "credit_amounts.*"  => ['required'],
            "debit_dates.*"  => ['required'],
            "debit_accounts.*"  => ['required'],
            "debit_narations.*"  => ['required'],
            "debit_amounts.*"  => ['required'],
            "total_debit" => ['required', 'same:total_credit']
        ];

        if ($request->suspense_amount > 0 && (array_sum($request->debit_amounts) > array_sum($request->credit_amounts) || array_sum($request->credit_amounts) > array_sum($request->debit_amounts))) {
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
        foreach ($request->all() as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $arr = explode('_', $key);
                    $first = ucfirst($arr[0]);
                    $second = $arr[1] == "quantities" ? str_replace('ies', 'y', $arr[1]) : str_replace('s', '', $arr[1]);
                    $kkk = $k + 1;
                    $messages["$key.$k.required"] = " $first entry number $kkk $second field is required";
                }
            }
        }
        return $messages;
    }
}
