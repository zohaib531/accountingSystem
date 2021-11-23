<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrialBalance extends Controller
{
    public function index()
    {
        return view('admin.reports.trial_balance.index');
    }

    // get data for trial balance
    public function entriesBetweenDates(Request $request){
        $validations = Validator::make($request->all(), [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $data = Voucher::whereBetween('date',[$request->start_date, $request->end_date])
         ->get();
        
        return $data;
    }
}
