<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description');
            $table->integer('numero_rue');
            $table->string('rue');
            $table->string('ville');
            $table->string('image')->nullable();
            $table->string('arrondissement');
            $table->string('region');
            $table->string('departement');
            $table->decimal('prix_loc');
            $table->decimal('prix_charge',);
            $table->integer('preavis');
            $table->date('date_libre');
            $table->integer('id_proprietaire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logements');
    }
};
