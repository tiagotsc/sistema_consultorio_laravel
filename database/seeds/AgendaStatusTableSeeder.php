<?php

use Illuminate\Database\Seeder;

class AgendaStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agenda_status')->insert([
            ['nome' => 'Marcado', 'usuario_tipo' => 'secretaria'],
            ['nome' => 'Desistiu', 'usuario_tipo' => 'secretaria'],
            ['nome' => 'Presente', 'usuario_tipo' => 'secretaria,medico'],
            ['nome' => 'Chamado', 'usuario_tipo' => 'medico'],
            ['nome' => 'Em atendimento', 'usuario_tipo' => 'secretaria'],
            ['nome' => 'Finalizado', 'usuario_tipo' => 'medico']
        ]);
    }
}
