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
            $table->string('matricula', 15)->unique()->after('name')->nullable();
            $table->string('telefone', 15)->after('matricula')->nullable();
            $table->string('celular', 15)->after('telefone')->nullable();
            $table->string('cpf', 15)->after('celular')->nullable();
            $table->string('endereco')->after('cpf')->nullable();
            $table->string('endNumero', 50)->after('endereco')->nullable();
            $table->string('cidade', 100)->after('endNumero')->nullable();
            $table->string('bairro', 100)->after('cidade')->nullable();
            $table->char('cep', 9)->after('bairro')->nullable();
            $table->enum('medico', ['S', 'N'])->after('cep');
            $table->date('dataNasc')->after('medico')->nullable();
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
