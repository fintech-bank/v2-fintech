<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('credit_card_insurances', function (Blueprint $table) {
            $table->id();

            $table->boolean('insurance_sante')->default(false);
            $table->boolean('insurance_accident_travel')->default(false);
            $table->boolean('trip_cancellation')->default(false);
            $table->boolean('civil_liability_abroad')->default(false);
            $table->boolean('cash_breakdown_abroad')->default(false);
            $table->boolean('guarantee_snow')->default(false);
            $table->boolean('guarantee_loan')->default(false);
            $table->boolean('guarantee_purchase')->default(false);
            $table->boolean('advantage')->default(false);
            $table->boolean('business_travel')->default(false);


            $table->foreignId('credit_card_support_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_card_insurances');
    }
};
