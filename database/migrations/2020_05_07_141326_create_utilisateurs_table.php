<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom',40);
            $table->string('prenom',64);
            $table->char('sexe');
            $table->string('email',64);
            $table->string('contact');
            $table->string('adresse');
            $table->string('pays',64);
            $table->string('fonction',64);
            $table->string('identifiant',64);
            $table->string('motdepasse');
            $table->date('validite');
            $table->boolean('status');
            $table->integer('id_createur');
            $table->boolean('candidat')->nullable()->default(0);;
            $table->boolean('convocation')->nullable()->default(0);;
            $table->boolean('numero')->nullable()->default(0);;
            $table->boolean('note')->nullable()->default(0);;
            $table->boolean('note_edit')->nullable()->default(0);;
            $table->boolean('resultat')->nullable()->default(0);;
            $table->boolean('session')->nullable()->default(0);;
            $table->boolean('utilisateur')->nullable()->default(0);;
            $table->boolean('reinscription')->nullable()->default(0);;
            $table->boolean('releve')->nullable()->default(0);;
            $table->boolean('attestation')->nullable()->default(0);;
            $table->foreign('id_createur')->references('id')->on('utilisateurs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
}
