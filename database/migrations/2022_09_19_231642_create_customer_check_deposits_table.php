<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_check_deposits', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('state', ['pending', 'progress', 'terminated'])->default('pending');
            $table->float('amount')->default(0);
            $table->timestamps();

            $table->foreignId('customer_wallet_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('customer_transaction_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_check_deposits');
    }
};
