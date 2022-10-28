<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('credit_card_supports', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->enum('type_customer', ['part', 'pro', 'orga', 'assoc'])->default('part');
            $table->boolean('payment_internet')->default(true);
            $table->boolean('payment_abroad')->default(false);
            $table->boolean('payment_contact')->default(true);
            $table->float('limit_retrait', 50);
            $table->float('limit_payment', 50);
            $table->boolean('visa_spec')->default(false);
            $table->boolean('choice_code')->default(false);

        });
    }

    public function down()
    {
        Schema::dropIfExists('credit_card_supports');
    }
};
