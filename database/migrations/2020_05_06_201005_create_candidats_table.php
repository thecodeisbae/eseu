<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifiant',60);
            //$table->primary('code')->on('candidats');
            $table->string('nom',40);
            $table->string('prenoms',100);
            $table->char('sexe');
            $table->date('date_naissance');
            $table->string('lieu_naissance',40)->nullable();
            $table->string('adresse',40)->nullable();
            $table->string('pays',40)->nullable();
            $table->char('sm')->nullable();
            $table->integer('enfants')->nullable();
            $table->string('fonction',40)->nullable();
            $table->string('lieu_travail',40)->nullable();
            $table->string('email',50);
            $table->string('contact',30);
            //$table->integer('image_id');
            $table->timestamps();
            //$table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidats');
    }
}
