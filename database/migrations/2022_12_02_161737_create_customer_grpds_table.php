<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_grpds', function (Blueprint $table) {
            $table->id();
            $table->boolean('edocument')->default(true);
            $table->boolean('content_com')->default(true);
            $table->boolean('content_geo')->default(true);
            $table->boolean('content_social')->default(true);
            $table->boolean('rip_newsletter')->default(true);
            $table->boolean('rip_commercial')->default(true);
            $table->boolean('rip_survey')->default(true);
            $table->boolean('rip_sponsorship')->default(true);
            $table->boolean('rip_canal_mail')->default(true);
            $table->boolean('rip_canal_sms')->default(true);

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_grpds');
    }
};
