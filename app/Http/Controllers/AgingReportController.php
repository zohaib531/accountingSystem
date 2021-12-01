<?php

namespace App\Http\Controllers;

use App\SubAccount;
use Illuminate\Http\Request;

class AgingReportController extends Controller
{
    public function index()
    {
        $subAccounts = SubAccount::select('id', 'title')->get();
        return view('admin.reports.aging_report.index',compact('subAccounts'));
    }
}
