<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'credit_card_id',
        'installment_of_credit_card_transaction_id',
        'name',
        'amount',
        'date_in',
        'date_out',
    ];

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function furtherInstallments()
    {
        return $this->hasMany(CreditCardTransaction::class, 'installment_of_credit_card_transaction_id')->with('furtherInstallments');
    }

    public function installmentOf()
    {
        return $this->belongsTo(CreditCardTransaction::class, 'installment_of_credit_card_transaction_id');
    }
}
