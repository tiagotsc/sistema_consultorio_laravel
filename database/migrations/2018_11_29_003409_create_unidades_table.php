<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero', 50)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->unsignedInteger('estado_id')->nullable();
            $table->string('bairro', 100)->nullable();
            $table->char('cep', 9)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->enum('status', ['A', 'I'])->default('A');
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
        Schema::dropIfExists('unidades');
    }
}
