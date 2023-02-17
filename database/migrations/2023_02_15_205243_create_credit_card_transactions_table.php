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
        Schema::create('credit_card_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('credit_card_id')->nullable();
            $table->foreign('credit_card_id')->references('id')->on('credit_cards');

            $table->string('name');
            $table->float('amount');
            $table->date('date_in');
            $table->date('date_out')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_card_transactions');
    }
};
