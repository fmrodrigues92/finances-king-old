<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('credit_card_transactions', function (Blueprint $table) {

            $table->unsignedBigInteger('installment_of_credit_card_transaction_id')->nullable()->after('credit_card_id');
            $table->foreign('installment_of_credit_card_transaction_id', 'installments_foreign_key')->references('id')->on('credit_card_transactions');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('credit_card_transactions', function (Blueprint $table) {

            $table->dropForeign('installments_foreign_key');
            $table->dropColumn('installment_of_credit_card_transaction_id');

        });
    }
};
