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
        Schema::create('insurance_package_warranties', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->boolean('check');
            $table->float('price');
            $table->string('condition')->nullable();
            $table->integer('count')->nullable();

            $table->foreignId('insurance_package_form_id')
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
        Schema::dropIfExists('insurance_package_warranties');
    }
};
