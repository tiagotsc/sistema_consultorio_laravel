<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula', 15)->unique();
            $table->string('nome');
            $table->integer('idPerfil');
            $table->enum('status', ['A', 'I'])->default('A');
            $table->string('telefone', 15)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('cpf', 15)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('senha')->nullable();
            $table->string('endereco')->nullable();
            $table->string('endNumero', 50)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->integer('idEstado')->nullable();
            $table->char('cep', 9)->nullable();
            $table->enum('medico', ['S', 'N']);
            $table->date('dataNasc')->nullable();
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
        Schema::dropIfExists('funcionario');
    }
}
