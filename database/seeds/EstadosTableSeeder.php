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
            ['nome' => 'Acre', 'sigla' => 'AC', 'timezone' => 'America/Rio_branco', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Alagoas', 'sigla' => 'AL', 'timezone' => 'America/Maceio', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Amapá', 'sigla' => 'AP', 'timezone' => 'America/Belem', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Amazonas', 'sigla' => 'AM', 'timezone' => 'America/Manaus', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Bahia', 'sigla' => 'BA', 'timezone' => 'America/Bahia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Ceará', 'sigla' => 'CE', 'timezone' => 'America/Fortaleza', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Distrito Federal', 'sigla' => 'DF', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Espírito Santo', 'sigla' => 'ES', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Goiás', 'sigla' => 'GO', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Maranhão', 'sigla' => 'MA', 'timezone' => 'America/Fortaleza', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Mato Grosso', 'sigla' => 'MT', 'timezone' => 'America/Cuiaba', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Mato GRosso do Sul', 'sigla' => 'MS', 'timezone' => 'America/Campo_Grande', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Minas Gerais', 'sigla' => 'MG', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Pará', 'sigla' => 'PR', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Paraíba', 'sigla' => 'PB', 'timezone' => 'America/Fortaleza', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Paraná', 'sigla' => 'PA', 'timezone' => 'America/Belem', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Pernambuco', 'sigla' => 'PE', 'timezone' => 'America/Recife', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Piauí', 'sigla' => 'PI', 'timezone' => 'America/Fortaleza', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rio de Janeiro', 'sigla' => 'RJ', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rio Grande do Norte', 'sigla' => 'RN', 'timezone' => 'America/Fortaleza', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rio Grande do Sul', 'sigla' => 'RS', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Rondônia', 'sigla' => 'RO', 'timezone' => 'America/Porto_Velho', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Roraima', 'sigla' => 'RR', 'timezone' => 'America/Boa_Vista', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Santa Catarina', 'sigla' => 'SC', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'São Paulo', 'sigla' => 'SP', 'timezone' => 'America/Sao_Paulo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Sergipe', 'sigla' => 'SE', 'timezone' => 'America/Maceio', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Tocantins', 'sigla' => 'TO', 'timezone' => 'America/Araguaia', 'created_at' => NOW(), 'updated_at' => NOW()]
        ];

        foreach($estados as $est){
            if(!in_array($est['nome'], $todosEstados)){
                DB::table('estados')->insert($est);
            }
        }
        
    }
}
