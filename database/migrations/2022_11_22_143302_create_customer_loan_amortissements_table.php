<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_loan_amortissements', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_prlv');
            $table->float('amount');
            $table->float('capital_du');
            $table->enum('status', ['program', 'progress', 'finish', 'error'])->default('program');

            $table->foreignId('customer_pret_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('customer_sepa_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_loan_amortissements');
    }
};
