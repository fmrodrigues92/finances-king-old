<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();

        return Inertia::render('Account/index', [
            'accounts' => $accounts,
        ]);
    }
}
