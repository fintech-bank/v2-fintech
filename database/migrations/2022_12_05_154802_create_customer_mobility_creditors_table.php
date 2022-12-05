<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_mobility_creditors', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('reference');
            $table->string('creditor');
            $table->float('amount');
            $table->timestamp('date');
            $table->boolean('valid');
            
            $table->foreignId('customer_mobility_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_mobility_creditors');
    }
};
