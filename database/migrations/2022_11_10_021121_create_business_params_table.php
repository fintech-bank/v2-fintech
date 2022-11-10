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
        Schema::create('business_params', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('forme', ['EI', 'EURL', 'SASU', 'SARL', 'SAS', 'SCI', 'Other']);
            $table->boolean('financement')->default(false);

            $table->float('ca')->default(0);
            $table->float('achat')->default(0);
            $table->float('frais')->default(0);
            $table->float('salaire')->default(0);
            $table->float('impot')->default(0);
            $table->float('other')->default(0);

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
        Schema::dropIfExists('business_params');
    }
};
