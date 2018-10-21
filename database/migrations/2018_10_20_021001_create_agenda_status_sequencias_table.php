<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaStatusSequenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_status_sequencias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('agenda_status_id');
            $table->unsignedInteger('agenda_status_id_sequencia');
            $table->string('usuario_tipo');
            $table->unsignedSmallInteger('ordem');
            $table->enum('status', ['A', 'I'])->default('A');
            $table->foreign('agenda_status_id')->references('id')->on('agenda_status')->onDelete('cascade');
            $table->foreign('agenda_status_id_sequencia')->references('id')->on('agenda_status');
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
        Schema::dropIfExists('agenda_status_sequencias');
    }
}
