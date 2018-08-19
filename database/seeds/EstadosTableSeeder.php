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
        DB::table('estados')->insert(['nome' => 'ACRE', 'sigla' => 'AC']);
        DB::table('estados')->insert(['nome' => 'ALAGOAS', 'sigla' => 'AL']);
        DB::table('estados')->insert(['nome' => 'AMAPÁ', 'sigla' => 'AP']);
        DB::table('estados')->insert(['nome' => 'AMAZONAS', 'sigla' => 'AM']);
        DB::table('estados')->insert(['nome' => 'BAHIA', 'sigla' => 'BA']);
        DB::table('estados')->insert(['nome' => 'CEARÁ', 'sigla' => 'CE']);
        DB::table('estados')->insert(['nome' => 'DISTRITO FEDERAL', 'sigla' => 'DF']);
        DB::table('estados')->insert(['nome' => 'ESPÍRITO SANTO', 'sigla' => 'ES']);
        DB::table('estados')->insert(['nome' => 'GOIÁS', 'sigla' => 'GO']);
        DB::table('estados')->insert(['nome' =>  'MARANHÃO', 'sigla' => 'MA']);
        DB::table('estados')->insert(['nome' =>  'MATO GROSSO', 'sigla' => 'MT']);
        DB::table('estados')->insert(['nome' =>  'MATO GROSSO DO SUL', 'sigla' => 'MS']);
        DB::table('estados')->insert(['nome' =>  'MINAS GERAIS', 'sigla' => 'MG']);
        DB::table('estados')->insert(['nome' =>  'PARÁ', 'sigla' => 'PR']);
        DB::table('estados')->insert(['nome' =>  'PARAÍBA', 'sigla' => 'PB']);
        DB::table('estados')->insert(['nome' =>  'PARANÁ', 'sigla' => 'PA']);
        DB::table('estados')->insert(['nome' =>  'PERNAMBUCO', 'sigla' => 'PE']);
        DB::table('estados')->insert(['nome' =>  'PIAUÍ', 'sigla' => 'PI']);
        DB::table('estados')->insert(['nome' =>  'RIO DE JANEIRO', 'sigla' => 'RJ']);
        DB::table('estados')->insert(['nome' =>  'RIO GRANDE DO NORTE', 'sigla' => 'RN']);
        DB::table('estados')->insert(['nome' =>  'RIO GRANDE DO SUL', 'sigla' => 'RS']);
        DB::table('estados')->insert(['nome' =>  'RONDÔNIA', 'sigla' => 'RO']);
        DB::table('estados')->insert(['nome' =>  'RORAIMA', 'sigla' => 'RR']);
        DB::table('estados')->insert(['nome' =>  'SANTA CATARINA', 'sigla' => 'SC']);
        DB::table('estados')->insert(['nome' =>  'SÃO PAULO', 'sigla' => 'SP']);
        DB::table('estados')->insert(['nome' =>  'SERGIPE', 'sigla' => 'SE']);
        DB::table('estados')->insert(['nome' =>  'TOCANTINS', 'sigla' => 'TO']);

    }
}
