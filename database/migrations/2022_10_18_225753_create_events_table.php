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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['customer', 'internal', 'external'])->default('customer');
            $table->string('reason');
            $table->string('subreason');
            $table->string('question')->nullable();
            $table->text('description')->nullable();
            $table->enum('canal', ['agency', 'phone', 'other'])->default('phone');
            $table->string('lieu')->nullable();
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->boolean('allDay');
            $table->timestamps();

            $table->bigInteger('agent_id')->unsigned();

            $table->foreign('agent_id')
                ->references('id')
                ->on('users');

            $table->foreignId('user_id')
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
        Schema::dropIfExists('events');
    }
};
