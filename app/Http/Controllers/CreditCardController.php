<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CreditCard;

class CreditCardController extends Controller
{
    public function index()
    {
        $CreditCards = CreditCard::all();

        return Inertia::render('CreditCard/index', [
            'credit_cards' => $CreditCards,
        ]);
    }
}
