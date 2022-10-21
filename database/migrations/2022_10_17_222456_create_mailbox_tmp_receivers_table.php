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
        Schema::create('mailbox_tmp_receiver', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mailbox_id')->unsigned();
            $table->bigInteger('receiver_id')->unsigned();
            $table->timestamps();

            $table->foreign('mailbox_id')
                ->references('id')
                ->on('mailbox')
                ->onDelete('cascade');

            $table->foreign('receiver_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailbox_tmp_receivers');
    }
};
