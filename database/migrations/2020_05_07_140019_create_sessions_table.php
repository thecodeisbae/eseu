<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            //$table->string('code',50);
            $table->string('nom',64);
            $table->date('start');
            $table->date('end');
            $table->boolean('current');
            $table->float('seuilOral',10);
            $table->dateTime('datetimeOral');
            $table->dateTime('datetimeEcrit');
            $table->string('viceRecteur');
            $table->text('viceRectorat');
            $table->string('service',64);
            $table->float('moyenne_passage');
            $table->integer('position');
            $table->text('numero');
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
        Schema::dropIfExists('sessions');
    }
}
