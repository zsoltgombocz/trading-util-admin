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
        Schema::create('closed_trades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('stock');

            //Represents how many days passed from the BUY to the SELL, also can be calculated from the
            //buy_occurred_at and sell_occurred_at
            $table->integer('active_days')->nullable();

            $table->integer('open_positions'); //How many BUY was added until it reached the SELL LIMIT
            $table->text('note')->nullable();
            $table->timestamp('buy_occurred_at')->nullable();
            $table->timestamp('sell_occurred_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closed_trades');
    }
};
