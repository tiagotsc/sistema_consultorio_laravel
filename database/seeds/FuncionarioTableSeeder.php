<?php

use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FuncionarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funcionario')->insert([
            'matricula' => 'F'.date('Ym').'001',
            'nome' => 'Paulo Roberto',
            'email' => 'paulo.roberto@teste.com.br',
            'telefone' => '(21) 3028-2045',
            'celular' => '(21) 98484-2040',
            'cpf' => '124.145.078-40',
            'medico' => 'S',
            'status' => 'A',
            'idPerfil' => 1
        ]);
    }
}
