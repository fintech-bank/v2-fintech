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
        Schema::create('epargne_plans', function (Blueprint $table) {
            $table->id();
            $table->string('type_customer');
            $table->enum('type_epargne', ['simple', 'logement', 'life', 'action', 'immobilier', 'tresorerie', 'retraite', 'salarie', 'jeune'])->default('simple');
            $table->string('name');
            $table->float('profit_percent');
            $table->integer('lock_days');
            $table->integer('profit_days')->default(30);
            $table->float('init')->default(0);
            $table->float('limit_amount');
            $table->boolean('unique')->default(false);
            $table->boolean('droit_credit')->default(false);
            $table->integer('duration')->default(0);
            $table->boolean('garantie_deces')->default(0);
            $table->boolean('partial_liberation')->default(0);
            $table->text('description');
            $table->json('info_versement');
            $table->json('info_retrait');
            $table->json('info_credit')->nullable();
            $table->json('info_deces')->nullable();
            $table->json('info_liberation')->nullable();
            $table->json('info_frais')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('epargne_plans');
    }
};
