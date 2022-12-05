<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_transfer_agencies', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->enum('status', ['waiting', 'progress', 'terminated', 'failed'])->default('waiting');
            $table->boolean('transfer_account')->default(false);
            $table->boolean('transfer_joint')->default(false);
            $table->boolean('transfer_all')->default(false);
            $table->timestamps();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('agency_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_transfer_agencies');
    }
};
