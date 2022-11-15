<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->default(generateReference(15));
            $table->string('sujet');
            $table->text('commentaire')->nullable();
            $table->enum('status', ['waiting', 'progress', 'terminated', 'expired'])->default('waiting');
            $table->string('link_model')->nullable();
            $table->integer('link_id')->nullable();
            $table->timestamps();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_requests');
    }
};
