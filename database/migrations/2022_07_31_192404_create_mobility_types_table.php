<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mobility_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->boolean('contact_banque')->default(true);
            $table->boolean('liste_mvm')->default(true);
            $table->boolean('select_mvm')->default(false);
            $table->boolean('transmission_rib_orga')->default(true);
            $table->boolean('cloture')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mobility_types');
    }
};
