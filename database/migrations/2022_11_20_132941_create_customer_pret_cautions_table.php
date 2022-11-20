<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customer_pret_cautions', function (Blueprint $table) {
            $table->id();
            // Info Usuel
            $table->enum('type_caution', ['simple', 'solidaire'])->default('solidaire');
            $table->enum('type', ['physique', 'moral'])->default('physique');
            $table->enum('status', ['waiting_validation', 'waiting_sign', 'process', 'retired', 'terminated'])->default('waiting_validation');
            $table->string('civility')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('company')->nullable();
            $table->boolean('ficap')->default(true)->comment("Organisme par default de cautionnement appartenant à FINTECH / Uniquement pour crédit personnel et à hauteur de 10 000 € maximum");

            // Coordonné
            $table->string('address');
            $table->string('postal');
            $table->string('city');
            $table->string('country')->comment("En toute lettre");
            $table->string('phone')->comment('Portable ou fixe');
            $table->string('email');
            $table->string('password')->nullable();

            // Information de caution (Personne Physique)
            $table->string('num_cni')->nullable();
            $table->timestamp('date_naissance')->nullable();
            $table->string('country_naissance')->nullable();
            $table->string('dep_naissance')->nullable();
            $table->string('ville_naissance')->nullable();
            $table->string('persona_reference_id')->nullable();
            $table->boolean('identityVerify')->default(false);
            $table->boolean('addressVerify')->default(false);

            // Information de caution (Personne Moral)
            $table->string('type_structure')->nullable()->comment("SASU, SARL, ETc..");
            $table->string('siret')->nullable();
            $table->boolean('identityVerify')->default(false);

            // Signature document
            $table->boolean('sign_caution')->default(false);
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_pret_cautions');
    }
};
