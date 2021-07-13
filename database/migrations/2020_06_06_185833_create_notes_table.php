<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id');
            $table->integer('matiere_id');
            $table->integer('candidat_id');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('matiere_id')->references('id')->on('matieres');
            $table->foreign('candidat_id')->references('id')->on('candidats');
            $table->double('note')->nullable();
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
        Schema::dropIfExists('notes');
    }
}
