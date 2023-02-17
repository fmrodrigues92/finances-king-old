<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'limit',
        'closing_day',
        'payment_day',
        'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
