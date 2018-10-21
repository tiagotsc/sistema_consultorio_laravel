<?php

use Illuminate\Database\Seeder;

class AgendaStatusSequenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sequencia = [
            /* Menu sequencia */
            [
                'agenda_status_id' => '1', # Marcado
                'agenda_status_id_sequencia' => '2', # Desistiu
                'usuario_tipo' => 'secretaria',
                'ordem' => '1'
            ],
            [
                'agenda_status_id' => '1', # Marcado
                'agenda_status_id_sequencia' => '1', # Marcado
                'usuario_tipo' => 'secretaria',
                'ordem' => '2'
            ],
            [
                'agenda_status_id' => '1', # Marcado
                'agenda_status_id_sequencia' => '3', # Presente
                'usuario_tipo' => 'secretaria,medico',
                'ordem' => '3'
            ],
            [
                'agenda_status_id' => '2', # Desistiu
                'agenda_status_id_sequencia' => '2', # Desistiu
                'usuario_tipo' => 'secretaria',
                'ordem' => '1'
            ],
            [
                'agenda_status_id' => '2', # Desistiu
                'agenda_status_id_sequencia' => '1', # Marcado
                'usuario_tipo' => 'secretaria',
                'ordem' => '2'
            ],
            [
                'agenda_status_id' => '2', # Desistiu
                'agenda_status_id_sequencia' => '3', # Presente
                'usuario_tipo' => 'secretaria,medico',
                'ordem' => '3'
            ],
            [
                'agenda_status_id' => '3', # Presente
                'agenda_status_id_sequencia' => '2', # Desistiu
                'usuario_tipo' => 'secretaria',
                'ordem' => '1'
            ],
            [
                'agenda_status_id' => '3', # Presente
                'agenda_status_id_sequencia' => '1', # Marcado
                'usuario_tipo' => 'secretaria',
                'ordem' => '2'
            ],
            [
                'agenda_status_id' => '3', # Presente
                'agenda_status_id_sequencia' => '3', # Presente
                'usuario_tipo' => 'secretaria,medico',
                'ordem' => '3'
            ],
            [
                'agenda_status_id' => '3', # Presente
                'agenda_status_id_sequencia' => '4', # Chamado
                'usuario_tipo' => 'medico',
                'ordem' => '4'
            ],
            [
                'agenda_status_id' => '4', # Chamado
                'agenda_status_id_sequencia' => '3', # Presente
                'usuario_tipo' => 'secretaria,medico',
                'ordem' => '1'
            ],
            [
                'agenda_status_id' => '4', # Chamado
                'agenda_status_id_sequencia' => '4', # Chamado
                'usuario_tipo' => 'medico',
                'ordem' => '2'
            ],
            [
                'agenda_status_id' => '4', # Chamado
                'agenda_status_id_sequencia' => '5', # Em atendimento
                'usuario_tipo' => 'secretaria',
                'ordem' => '3'
            ],
            [
                'agenda_status_id' => '5', # Em atendimento
                'agenda_status_id_sequencia' => '4', # Chamado
                'usuario_tipo' => 'medico',
                'ordem' => '1'
            ],
            [
                'agenda_status_id' => '5', # Em atendimento
                'agenda_status_id_sequencia' => '5', # Em atendimento
                'usuario_tipo' => 'secretaria',
                'ordem' => '2'
            ],
            [
                'agenda_status_id' => '5', # Em atendimento
                'agenda_status_id_sequencia' => '6', # Finalizado
                'usuario_tipo' => 'medico',
                'ordem' => '3'
            ],
            [
                'agenda_status_id' => '6', # Finalizado
                'agenda_status_id_sequencia' => '5', # Em atendimento
                'usuario_tipo' => 'secretaria,medico',
                'ordem' => '1'
            ],
            [
                'agenda_status_id' => '6', # Finalizado
                'agenda_status_id_sequencia' => '6', # Finalizado
                'usuario_tipo' => 'medico',
                'ordem' => '2'
            ]
        ];
        DB::table('agenda_status_sequencias')->insert($sequencia);
    }
}
