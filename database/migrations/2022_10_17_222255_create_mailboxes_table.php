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
        Schema::create('mailbox', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->longText('body')->nullable();
            $table->bigInteger('sender_id')->unsigned();
            $table->string('time_sent');
            $table->bigInteger('parent_id')->default(0);
            $table->timestamps();

            $table->foreign('sender_id')
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
        Schema::dropIfExists('mailboxes');
    }
};
