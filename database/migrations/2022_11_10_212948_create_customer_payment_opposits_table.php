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
        Schema::create('customer_payment_opposits', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['submit', 'progress', 'finish'])->default('submit');
            $table->text('raison_opposit');
            $table->timestamps();

            $table->foreignId('customer_transaction_id')
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
        Schema::dropIfExists('customer_payment_opposits');
    }
};
