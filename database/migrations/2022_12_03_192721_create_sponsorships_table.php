<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->id();
            $table->enum('civility', ['M', 'Mme', 'Mlle']);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('postal');
            $table->string('city');
            $table->string('code');
            $table->boolean('closed')->default(0);
            $table->timestamps();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sponsorships');
    }
};
