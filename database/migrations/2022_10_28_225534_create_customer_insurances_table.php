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
        Schema::create('customer_insurances', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'resilied', 'terminated', 'suspended', 'juris'])->default('active');
            $table->string('reference');
            $table->timestamp('date_member');
            $table->timestamp('effect_date');
            $table->timestamp('end_date');
            $table->float('mensuality')->default(0);
            $table->timestamps();

            $table->foreignId('customer_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('insurance_package_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('customer_insurances');
    }
};
