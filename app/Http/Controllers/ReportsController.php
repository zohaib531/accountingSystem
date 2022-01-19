<?php

namespace App\Http\Controllers;

use App\Product;
use Validator;
use App\Voucher;
use App\VoucherDetail;
use App\SubAccount;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    // Party Account Report code Start
      public function partyAccountReport($sub_account_id,$start_date,$end_date){
        ini_set ( 'max_execution_time', -1); //unlimit
        $vouchers = VoucherDetail::where('sub_account_id',$sub_account_id)->whereBetween('date',[$start_date, $end_date])->orderBy('date','asc')->get();
        $totalDebit = VoucherDetail::where('sub_account_id',$sub_account_id)->whereBetween('date',[$start_date, $end_date])->sum('debit_amount');
        $totalCredit = VoucherDetail::where('sub_account_id',$sub_account_id)->whereBetween('date',[$start_date, $end_date])->sum('credit_amount');
        $subAccount = SubAccount::where('id', $sub_account_id)->first();
        $startDate = $start_date;
        $endDate = $end_date;
        $pdf = PDF::loadView('admin.pdf_reports.partyAccountLedger', compact('vouchers','totalDebit','totalCredit','subAccount','endDate','startDate'));
      // download PDF file with download method
        return $pdf->download($subAccount->title.'ledger'.'.pdf');
    }
    // Party Account Report code end



    // Sale Purchase Report code start
    public function salePurchaseReport(Request $request)
    {
        $validations = Validator::make($request->all(), ['start_date' => 'required_with_all:end_date','end_date' => 'required_with_all:start_date']);
        if ($validations->fails()) { return back()->withInput()->withErrors($validations) ;}
        $request = $request->except('_token');
        $vouchers = null;
        $dataCheck = true;
        $start_date = '';
        $end_date = '';

        $filledFieldsArray = getFilledField($request);
        // return $filledFieldsArray;
        if(count($filledFieldsArray)>0){
            foreach($filledFieldsArray as $key=>$value){

                if($key == 'start_date'){
                    if($value != ''){
                        $start_date = $value;
                    }
                }

                if($key == 'end_date'){
                    if($value != ''){
                        $end_date =  $value;
                    }
                }



                if($key === array_key_first($filledFieldsArray)){
                    if(($key =="start_date" || $key=="end_date") && $dataCheck){
                        $vouchers = VoucherDetail::whereBetween('date',[Carbon::createFromFormat('d / m / y', $filledFieldsArray['start_date'])->format('y-m-d'), Carbon::createFromFormat('d / m / y', $filledFieldsArray['end_date'])->format('y-m-d')]);
                    }else if(($key !="start_date" || $key !="end_date") ){

                        if($key == 'product_type'){
                            $vouchers = VoucherDetail::where('product_narration','LIKE','%'.$value.'%');
                        }else{
                            $vouchers = VoucherDetail::where($key, $value);
                        }

                    }
                }

                else if(($key !=="start_date" && $key !=="end_date") && $key != 'product_type'){
                    $vouchers->where($key, $value);
                }

                else if($key == 'product_type'){
                    $vouchers->where("product_narration","like", "%{$value}%");
                }


            }
            $vouchers = $vouchers->get();
        }else{
            $vouchers = VoucherDetail::get();
        }

        $products = Product::select('id', 'title','narration','product_unit')->get();
        $unique_product_titles = Product::select('title')->distinct()->get();
        $subAccounts = SubAccount::select('id', 'title')->get();

        $pdf = PDF::loadView('admin.pdf_reports.salePurchase',  compact('vouchers','products','subAccounts','unique_product_titles','start_date','end_date'));
        // download PDF file with download method
          return $pdf->download('salePurchaseReport.pdf');

        // return view('admin.pdf_reports.salePurchase', compact('vouchers','products','subAccounts','unique_product_titles','start_date','end_date'));
    }


    // Sale Purchase Report code end




  // journal Report code start
    public function journalReport()
    {
        // $journal_vouchers = Voucher::where('voucher_type', 'journal_voucher')->get();
        $vouchers = VoucherDetail::all();
        $pdf = PDF::loadView('admin.pdf_reports.journal', compact('vouchers') );
        // download PDF file with download method
          return $pdf->download('journalReport.pdf');
    }
    // journal Report code end

    public function trialReport( $start_date , $end_date){

        $vouchers = VoucherDetail::whereBetween('date',[$start_date, $end_date])->orderBy('date','asc')->get();
        $subAccounts = SubAccount::all();
        $startDate = $start_date;
        $endDate = $end_date;
        $pdf = PDF::loadView('admin.pdf_reports.trialBalance', compact('vouchers','subAccounts','startDate','endDate') );
        // download PDF file with download method
          return $pdf->download('trialBalanceReport.pdf');
    }

}













