<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('candidat_id');
            $table->integer('session_id');
            $table->integer('option_id');
            $table->float('oral')->nullable();
            $table->boolean('oralAdmis')->nullable()->default(0);
            $table->string('code_secret',64)->nullable();
            $table->string('numero_table',64)->nullable();
            $table->float('moyenne')->nullable()->default(0);
            $table->string('decision')->nullable();
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('utilisateurs');
            $table->foreign('candidat_id')->references('id')->on('candidats');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->foreign('option_id')->references('id')->on('options');
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
        Schema::dropIfExists('inscriptions');
    }
}
