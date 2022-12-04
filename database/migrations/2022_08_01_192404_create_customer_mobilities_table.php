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
        Schema::create('customer_mobilities', function (Blueprint $table) {
            $table->id();
            $table->string('name_mandate');
            $table->string('ref_mandate');
            $table->string('name_account');
            $table->string('iban');
            $table->string('bic');
            $table->string('address');
            $table->string('addressbis')->nullable();
            $table->string('postal');
            $table->string('ville');
            $table->string('country');
            $table->timestamp('date_transfer')->default(now());
            $table->boolean('cloture');
            $table->enum('status', ['pending', 'bank_start', 'select_mvm', 'bank_end', 'creditor_start', 'select_mvm', 'creditor_end', 'terminated'])->default('pending');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreignId('mobility_type_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('customer_wallet_id')
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
        Schema::dropIfExists('customer_mobilities');
    }
};
