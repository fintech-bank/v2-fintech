<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->enum('civility', ['M', 'Mme', 'Mlle']);
            $table->string('firstname');
            $table->string('lastname');
            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });
    }

    public function down()
    {
        Schema::dropIfExists('agents');
    }
};
