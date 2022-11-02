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
        Schema::create('insurance_package_forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('synopsis')->nullable();
            $table->float('typed_price');
            $table->float('percent')->nullable();

            $table->foreignId('insurance_package_id')
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
        Schema::dropIfExists('insurance_package_forms');
    }
};
