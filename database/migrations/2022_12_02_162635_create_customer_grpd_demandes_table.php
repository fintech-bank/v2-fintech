<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_grpd_demandes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['com_pospecting', 'personal_data', 'inacurate', 'erasure', 'limit', 'portability']);
            $table->string('object');
            $table->text('comment');
            $table->enum('status', ['pending', 'terminated', 'cancel', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_grpd_demandes');
    }
};
