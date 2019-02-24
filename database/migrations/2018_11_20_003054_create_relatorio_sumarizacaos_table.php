<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatorioSumarizacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorio_sumarizacao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('campo');
            $table->text('sumarizados');
            $table->unsignedInteger('relatorio_id');
            $table->foreign('relatorio_id')->references('id')->on('relatorios')->onDelete('cascade');
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
        Schema::dropIfExists('relatorio_sumarizacao');
    }
}
