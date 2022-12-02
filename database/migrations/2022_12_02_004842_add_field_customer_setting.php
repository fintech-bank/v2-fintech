<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('customer_settings', function (Blueprint $table) {
            $table->boolean('securpass')->default(false);
            $table->string('securpass_key')->nullable();
            $table->string('securpass_model')->nullable();
            $table->string('code_auth')->nullable();
            $table->boolean('cashback')->default(true);
            $table->boolean('tos_cashback')->default(false);
        });
    }

    public function down()
    {
        Schema::table('customer_settings', function (Blueprint $table) {
            $table->removeColumn('securpass');
            $table->removeColumn('securpass_key');
            $table->removeColumn('securpass_model');
            $table->removeColumn('code_auth');
        });
    }
};
