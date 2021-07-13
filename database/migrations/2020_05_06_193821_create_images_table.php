<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('candidat_id');
            $table->foreign('candidat_id')->references('id')->on('candidats');
            $table->text('nom_original');
            $table->boolean('rogne');
            $table->text('nom');
            $table->text('type');
            $table->text('chemin');
            $table->text('miniature');
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
        Schema::dropIfExists('images');
    }
}
