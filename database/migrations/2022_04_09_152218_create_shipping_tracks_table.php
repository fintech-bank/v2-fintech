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
        Schema::create('shipping_tracks', function (Blueprint $table) {
            $table->id();
            $table->enum('state', ['ordered', 'prepared', 'in_transit', 'delivered', 'error']);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreignId('shipping_id')
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
        Schema::dropIfExists('shipping_tracks');
    }
};
