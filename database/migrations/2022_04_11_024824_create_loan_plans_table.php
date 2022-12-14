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
        Schema::create('loan_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type_pret', ['particulier', 'professionnel', 'authority'])->default('particulier');
            $table->float('minimum');
            $table->float('maximum');
            $table->integer('duration')->comment('En Mois');
            $table->text('instruction')->nullable();
            $table->json('avantage')->nullable();
            $table->json('condition')->nullable();
            $table->json('tarif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_plans');
    }
};
