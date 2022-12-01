<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->string('poste')->default("Conseiller de clientèle");
            $table->string('phone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->removeColumn('poste');
            $table->removeColumn('phone');
        });
    }
};
