<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCamposUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('matricula', 15)->unique()->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('cpf', 15)->nullable();
            $table->string('endereco')->nullable();
            $table->string('endNumero', 50)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->char('cep', 9)->nullable();
            $table->enum('medico', ['S', 'N']);
            $table->date('dataNasc')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
