<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_info_insurances', function (Blueprint $table) {
            $table->id();
            $table->string('secu_number')->nullable();
            $table->boolean('fume')->default(false)->comment("Suis-je Fumeur ?");
            $table->boolean('sport_risk')->default(false)->comment("Pratique t'il un sport à risque ?");
            $table->boolean('politique')->default(false)->comment("Est-il exposer publiquement ?");
            $table->boolean('politique_proche')->default(false)->comment("A t'il une proche personne exposer publiquement ?");
            $table->boolean('manual_travaux')->default(false)->comment("Travaux Manuel");
            $table->enum('dep_pro', ['low', 'high'])->default('low')->comment("Déplacement Pro (low: moins de 20 000/km/an)");
            $table->enum('port_charge', ['low', 'middle', 'high'])->default('low')->comment("Port de charge (0/3/15kg)");
            $table->enum('work_height', ['low', 'middle', 'high'])->default('low')->comment("Port de charge (0/3-15/15)");

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_info_insurances');
    }
};
