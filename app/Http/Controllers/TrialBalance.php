<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrialBalance extends Controller
{
    public function index()
    {
        return view('admin.reports.trial_balance.index');
    }
}
