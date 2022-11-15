<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('credit_card_opposits', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['vol', 'perte', 'fraude']);
            $table->text('description');
            $table->boolean('verif_fraude')->default(0);
            $table->enum('status', ['submit', 'progress', 'terminate'])->default('submit');
            $table->string('link_opposit')->nullable();
            $table->timestamps();

            $table->foreignId('customer_credit_card_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_card_opposits');
    }
};
