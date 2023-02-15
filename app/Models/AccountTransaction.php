<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'amount',
        'date',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
