<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_insurance_claims', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('status', ['waiting', 'progress', 'finish'])->default('waiting');
            $table->boolean('responsability')->default(false);
            $table->date('incidentDate');
            $table->time('incidentTime')->nullable();
            $table->text("incidentDesc");
            $table->timestamps();

            $table->foreignId('customer_insurance_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_insurance_claims');
    }
};
