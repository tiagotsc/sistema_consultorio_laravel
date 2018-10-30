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
        $todosStatus = DB::table('agenda_status')->pluck('nome')->toArray();
        $status = [
            ['nome' => 'Marcado', 'usuario_tipo' => 'secretaria', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Desistiu', 'usuario_tipo' => 'secretaria', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Presente', 'usuario_tipo' => 'secretaria,medico', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Chamado', 'usuario_tipo' => 'medico', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Em atendimento', 'usuario_tipo' => 'secretaria', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Finalizado', 'usuario_tipo' => 'medico', 'created_at' => NOW(), 'updated_at' => NOW()]
        ];
        foreach($status as $st){
            if(!in_array($st['nome'], $todosStatus)){
                DB::table('agenda_status')->insert($st);
            }
        }
    }
}
