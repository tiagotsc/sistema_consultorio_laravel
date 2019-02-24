<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relatorios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao');
            $table->text('aba_planilha',50)->nullable();
            $table->text('query');
            $table->unsignedInteger('relatorio_categoria_id');
            $table->unsignedInteger('permission_id');
            $table->text('banco_conexao',50);
            $table->enum('status', ['A', 'I'])->default('A');
            $table->foreign('relatorio_categoria_id')->references('id')->on('relatorio_categorias');
            $table->foreign('permission_id')->references('id')->on('permissions');
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
        Schema::dropIfExists('relatorios');
    }
}
