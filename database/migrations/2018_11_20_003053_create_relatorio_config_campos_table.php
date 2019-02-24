<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatorioConfigCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorio_config_campos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('legenda');
            $table->enum('obrigatorio', ['S', 'N'])->default('S');
            $table->unsignedInteger('ordem')->nullable();
            $table->unsignedInteger('relatorio_id');
            $table->unsignedInteger('relatorio_campo_id');
            $table->foreign('relatorio_id')->references('id')->on('relatorios')->onDelete('cascade');
            $table->foreign('relatorio_campo_id')->references('id')->on('relatorio_campos');
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
        Schema::dropIfExists('relatorio_config_campos');
    }
}
