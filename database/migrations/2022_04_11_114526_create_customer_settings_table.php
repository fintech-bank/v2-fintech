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
        Schema::create('customer_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('notif_sms')->default(false);
            $table->boolean('notif_app')->default(false);
            $table->boolean('notif_mail')->default(false);
            $table->integer('nb_physical_card')->default(1);
            $table->integer('nb_virtual_card')->default(1);
            $table->boolean('check')->default(false);
            $table->boolean('alerta')->default(false);
            $table->boolean('card_code')->default(false);
            $table->boolean('gauge')->default(false);
            $table->boolean('gauge_show_solde')->default(false);
            $table->boolean('gauge_show_op_waiting')->default(false)->comment("Opération en traitement");
            $table->boolean('gauge_show_last_op')->default(false);
            $table->integer('gauge_start')->default(0);
            $table->integer('gauge_end')->default(0);

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
        Schema::dropIfExists('customer_settings');
    }
};
