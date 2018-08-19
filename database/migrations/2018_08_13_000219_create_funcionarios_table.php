<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
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
            $table->string('cidade', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->char('cep', 9)->nullable();
            $table->enum('medico', ['S', 'N']);
            $table->date('dataNasc')->nullable();
            $table->timestamps();
            $table->unsignedInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
