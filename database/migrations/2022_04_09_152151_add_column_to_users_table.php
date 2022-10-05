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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('admin')->default(false);
            $table->boolean('agent')->default(false);
            $table->boolean('customer')->default(true);
            $table->boolean('reseller')->default(false);
            $table->string('identifiant')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->string('pushbullet_device_id')->nullable();
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('admin');
            $table->removeColumn('agent');
            $table->removeColumn('customer');
            $table->removeColumn('reseller');
            $table->removeColumn('identifiant');
            $table->removeColumn('last_seen');
            $table->removeColumn('pushbullet_device_id');
            $table->removeColumn('avatar');
        });
    }
};
