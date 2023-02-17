<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditCardTransaction;
use Inertia\Inertia;

class CreditCardTransactionController extends Controller
{
    public function index(Request $request, $credit_card_id)
    {

        //get mounth from request
        $month = $request->input('month', date('m'));

        //get year from request;
        $year = $request->input('year', date('Y'));

        //array with all days in month
        $days = array();
        for ($i = 1; $i <= cal_days_in_month(CAL_GREGORIAN, $month, $year); $i++) {
            $days[] = $i;
        }

        $transactions = CreditCardTransaction::where('credit_card_id', $credit_card_id)
            ->whereMonth('date_in', $month)
            ->whereYear('date_in', $year)
            ->with('creditCard')
            ->orderBy('date_in', 'ASC')
            ->get();

        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->amount;
        }

        //=======================================
        //=======================================
        //=======================================

        //get all transactions where date_id started in the $month and $year first day of mounth group by day and sum amount
        $transactionsLimit = CreditCardTransaction::where('credit_card_id', $credit_card_id)
            ->where('date_in', '>=', date('Y-m-d', strtotime($year . '-' . $month . '-01')))
            ->where('date_in', '<=', date('Y-m-d', strtotime($year . '-' . $month . '-' . cal_days_in_month(CAL_GREGORIAN, $month, $year))))
            ->with('furtherInstallments')
            ->orderBy('date_in', 'ASC')
            ->get();

        //montar array com todos os dias do mes e somar os valores de $transactionsLimit do dia pra frente
        $limitUse = array();
        foreach ($days as $i => $day) {
            $limitUse[$day] = $limitUse[$day-1] ?? 0;

            foreach ($transactionsLimit as $transaction) {
                if (date('d', strtotime($transaction->date_in)) == $day) {
                    $limitUse[$day] += $transaction->amount;
                    if ($transaction->furtherInstallments->count() > 0) {
                        $limitUse[$day] += $this->sumFurtherInstallments($transaction);
                    }
                }
            }
        }


        return Inertia::render('CreditCard/transactions', [
            'credit_card' => $transactions[0]['creditCard'] ?? null,
            'transactions' => $transactions,
            'sum' => $sum,
            'days' => $days,
            'limit_used' => $limitUse,
        ]);
    }

    //sum further installments
    private function sumFurtherInstallments($transaction)
    {
        $sum = 0;
        foreach ($transaction->furtherInstallments as $installment) {
            $sum += $installment->amount;
            if ($installment->furtherInstallments->count() > 0) {
                $sum += $this->sumFurtherInstallments($installment);
            }
        }
        return $sum;
    }
}
