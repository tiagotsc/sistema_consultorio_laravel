<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatorioCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('relatorio_campos', function (Blueprint $table) {
             $table->increments('id');
             $table->string('nome')->unique();
             $table->string('legenda');
             $table->string('mascara')->nullable();
             $table->enum('tipo', ['data','mesano','horario','numero','texto','dinheiro']);
             $table->enum('status', ['A', 'I'])->default('A');
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
        Schema::dropIfExists('relatorio_campos');
    }
}
