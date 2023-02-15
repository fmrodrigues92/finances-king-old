<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountTransactionController extends Controller
{
    public function index(Request $request, $account_id)
    {
        //get mounth from request
        $month = $request->input('month', date('m'));

        //get year from request;
        $year = $request->input('year', date('Y'));

        $transactions = AccountTransaction::where('account_id', $account_id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get();

        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->amount;
        }

        return Inertia::render('Account/transactions', [
            'transactions' => $transactions,
            'sum' => $sum,
        ]);
    }
}
