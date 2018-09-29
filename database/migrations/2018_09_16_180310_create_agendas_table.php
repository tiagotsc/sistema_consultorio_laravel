<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->time('horario');
            $table->unsignedInteger('agenda_status_id')->default(1);
            $table->foreign('agenda_status_id')->references('id')->on('agenda_status');
            $table->unsignedInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->enum('plano_saude', ['S', 'N'])->default('N');
            $table->unsignedInteger('medico_id');
            $table->foreign('medico_id')->references('id')->on('users');
            $table->unsignedInteger('especialidade_id');
            $table->foreign('especialidade_id')->references('id')->on('especialidades');
            $table->text('medico_anotacoes')->nullable();
            $table->time('hora_presenca')->nullable(); # Hora que o paciente se identificou com a secretária
            $table->time('hora_inicio')->nullable(); # Hora que o médico começou o atendiemnto
            $table->time('hora_fim')->nullable(); # Hora que o médico encerrou o atendimento
            $table->enum('envio_sms', ['S', 'N'])->default('N'); # Verifica se já foi enviado SMS
            $table->unsignedInteger('marcou_user_id'); # Pessoa que marcou a consulta
            $table->foreign('marcou_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('agendas');
    }
}
