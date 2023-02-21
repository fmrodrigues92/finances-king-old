<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountTransactionController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\CreditCardTransactionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/account/{account_id}/transactions', [AccountTransactionController::class, 'index'])->name('account.transactions.index');

    Route::get('/credit-cards', [CreditCardController::class, 'index'])->name('credit-cards.index');

    Route::get('/credit-card/{credit_card_id}/transactions', [CreditCardTransactionController::class, 'index'])->name('credit-card.transactions.index');
    Route::post('/credit-card/{credit_card_id}/transactions', [CreditCardTransactionController::class, 'store'])->name('credit-card.transactions.store');
    Route::put('/credit-card/{credit_card_id}/transactions/{credit_card_transaction_id}', [CreditCardTransactionController::class, 'update'])->name('credit-card.transactions.update');
    Route::delete('/credit-card/{credit_card_id}/transactions/{credit_card_transaction_id}', [CreditCardTransactionController::class, 'destroy'])->name('credit-card.transactions.destroy');

});

require __DIR__.'/auth.php';
