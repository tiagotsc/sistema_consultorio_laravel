<?php

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $todosEstados = DB::table('estados')->pluck('nome')->toArray();
        $estados = [
            ['nome' => 'Acre', 'sigla' => 'AC', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Alagoas', 'sigla' => 'AL', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Amapá', 'sigla' => 'AP', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Amazonas', 'sigla' => 'AM', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Bahia', 'sigla' => 'BA', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Ceará', 'sigla' => 'CE', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Distrito Federal', 'sigla' => 'DF', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Espírito Santo', 'sigla' => 'ES', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Goiás', 'sigla' => 'GO', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Maranhão', 'sigla' => 'MA', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Mato Grosso', 'sigla' => 'MT', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Mato GRosso do Sul', 'sigla' => 'MS', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Minas Gerais', 'sigla' => 'MG', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Pará', 'sigla' => 'PR', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Paraíba', 'sigla' => 'PB', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Paraná', 'sigla' => 'PA', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Pernambuco', 'sigla' => 'PE', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Piauí', 'sigla' => 'PI', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rio de Janeiro', 'sigla' => 'RJ', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rio Grande do Norte', 'sigla' => 'RN', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rio Grande do Sul', 'sigla' => 'RS', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rondônia', 'sigla' => 'RO', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Roraima', 'sigla' => 'RR', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Santa Catarina', 'sigla' => 'SC', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'São Paulo', 'sigla' => 'SP', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Sergipe', 'sigla' => 'SE', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Tocantins', 'sigla' => 'TO', 'created_at' => NOW(), 'updated_at' => NOW()]
        ];

        foreach($estados as $est){
            if(!in_array($est['nome'], $todosEstados)){
                DB::table('estados')->insert($est);
            }
        }
        
    }
}
