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
            ['nome' => 'Marcado'],
            ['nome' => 'Desistiu'],
            ['nome' => 'Presente'],
            ['nome' => 'Chamado'],
            ['nome' => 'Consultando'],
            ['nome' => 'Finalizado']
        ]);
    }
}
