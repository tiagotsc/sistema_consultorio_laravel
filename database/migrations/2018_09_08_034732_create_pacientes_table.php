<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula', 15)->unique()->nullable();
            $table->string('nome')->nullable();
            $table->enum('sexo', ['M', 'F'])->nullable();
            $table->enum('nacionalidade', ['BRA', 'EST','NAC'])->nullable();
            $table->string('cpf', 15)->nullable();
            $table->string('rg', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('celular', 15)->nullable();
            $table->char('cep', 9)->nullable();
            $table->string('endereco')->nullable();
            $table->string('endNumero', 50)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->date('dataNasc')->nullable();
            $table->enum('novoPaciente', ['S', 'N'])->default('S');
            $table->string('senha')->nullable();
            $table->enum('status', ['A', 'I'])->default('A');
            $table->unsignedInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('pacientes');
    }
}
