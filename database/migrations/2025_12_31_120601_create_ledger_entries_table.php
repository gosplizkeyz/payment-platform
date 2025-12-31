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
        Schema::create('ledger_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id'); // reference to wallet
            $table->string('type'); // credit or debit
            $table->integer('amount'); // amount in kobo
            $table->string('description'); // e.g., Customer payment
            $table->string('reference'); // UUID for the payment
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_entries');
    }
};

Schema::create('ledger_entries', function (Blueprint $table) {
    $table->id();
    $table->uuid('reference')->index();
    $table->foreignId('wallet_id')->constrained();
    $table->enum('type', ['credit', 'debit']);
    $table->bigInteger('amount'); // kobo
    $table->string('description');
    $table->timestamps();
});
