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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('owner_type'); // type of owner: business, platform, tax
            $table->unsignedBigInteger('owner_id')->nullable(); // reference to business id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};

Schema::create('wallets', function (Blueprint $table) {
    $table->id();
    $table->string('owner_type'); // business | platform | tax
    $table->unsignedBigInteger('owner_id')->nullable();
    $table->timestamps();
});
