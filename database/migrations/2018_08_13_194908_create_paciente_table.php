<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paciente', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula', 15)->unique();
            $table->string('nome');
            $table->string('rg', 15)->nullable();
            $table->enum('sexo', ['M', 'F']);
            $table->enum('nacionalidade', ['BRA', 'EST','NAC'])->default('BRA');
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
            $table->char('medico', 1)->nullable();
            $table->date('dataNasc')->nullable();
            $table->enum('novoPaciente', ['S', 'N'])->default('S');
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
        Schema::dropIfExists('paciente');
    }
}
