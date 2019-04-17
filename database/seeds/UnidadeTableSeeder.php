<?php

use Illuminate\Database\Seeder;

class UnidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidadePrimeira = DB::table('unidades')->where('nome','Primeira unidade')->first();
        if($unidadePrimeira == null){
            DB::table('unidades')->insert(
                [
                    'nome' => 'Primeira unidade',
                    'estado_id' => 19,
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]
            );
        }
    }
}
