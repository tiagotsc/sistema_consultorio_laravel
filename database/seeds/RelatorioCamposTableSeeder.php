<?php

use Illuminate\Database\Seeder;

class RelatorioCamposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $todosCampos = DB::table('relatorio_campos')->pluck('nome')->toArray();

        $campos = [
            /* Campos do tipo data */
            [
                'nome' => 'CAMPO_DATA1',
                'legenda' => "Somente data permitida para o usuário! Na query ficará YYYY-MM-DD. Exemplo de uso na query de data_inicio ='CAMPO_DATA1'",
                'mascara' => '00/00/0000',
                'tipo' => 'data',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_DATA2',
                'legenda' => "Somente data permitida para o usuário! Na query ficará YYYY-MM-DD. Exemplo de uso na query data_inicio ='CAMPO_DATA2'",
                'mascara' => '00/00/0000',
                'tipo' => 'data',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_DATA3',
                'legenda' => "Somente data permitida para o usuário! Na query ficará YYYY-MM-DD. Exemplo de uso na query data_inicio ='CAMPO_DATA3'",
                'mascara' => '00/00/0000',
                'tipo' => 'data',
                'status' => 'I',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],

            /* Campos do tipo mês/ano */
            [
                'nome' => 'CAMPO_MESANO1',
                'legenda' => "Somente mês/ano permitido para o usuário! Na query ficará MM/YYYY. Exemplo de uso na query data_inicio ='CAMPO_MESANO1'",
                'mascara' => '00/0000',
                'tipo' => 'mesano',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],

            [
                'nome' => 'CAMPO_MESANO2',
                'legenda' => "Somente mês/ano permitido para o usuário! Na query ficará MM/YYYY. Exemplo de uso na query data_inicio ='CAMPO_MESANO2'",
                'mascara' => '00/0000',
                'tipo' => 'mesano',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],

            [
                'nome' => 'CAMPO_MESANO3',
                'legenda' => "Somente mês/ano permitido para o usuário! Na query ficará MM/YYYY. Exemplo de uso na query data_inicio ='CAMPO_MESANO3'",
                'mascara' => '00/0000',
                'tipo' => 'mesano',
                'status' => 'I',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],

            /* Campos do tipo hora */
            [
                'nome' => 'CAMPO_HORARIO1',
                'legenda' => "Somente horário permitido para o usuário! Na query ficará HH:MM. Exemplo de uso na query horario_inicial ='CAMPO_HORARIO1'",
                'mascara' => '00:00',
                'tipo' => 'horario',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_HORARIO2',
                'legenda' => "Somente horário permitido para o usuário! Na query ficará HH:MM. Exemplo de uso na query horario_inicial ='CAMPO_HORARIO2'",
                'mascara' => '00:00',
                'tipo' => 'horario',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_HORARIO3',
                'legenda' => "Somente horário permitido para o usuário! Na query ficará HH:MM. Exemplo de uso na query horario_inicial ='CAMPO_HORARIO3'",
                'mascara' => '00:00',
                'tipo' => 'horario',
                'status' => 'I',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],

            /* Campos do tipo número */
            [
                'nome' => 'CAMPO_NUMERO1',
                'legenda' => "Somente número permitido para o usuário! Na query ficará 234243242... . Exemplo de uso na query valor ='CAMPO_NUMERO1'",
                'mascara' => '#0',
                'tipo' => 'numero',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_NUMERO2',
                'legenda' => "Somente número permitido para o usuário! Na query ficará 234243242... . Exemplo de uso na query valor ='CAMPO_NUMERO2'",
                'mascara' => '#0',
                'tipo' => 'numero',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_NUMERO3',
                'legenda' => "Somente número permitido para o usuário! Na query ficará 234243242... . Exemplo de uso na query valor ='CAMPO_NUMERO3'",
                'mascara' => '#0',
                'tipo' => 'numero',
                'status' => 'I',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],

            /* Campos do tipo texto */
            [
                'nome' => 'CAMPO_TEXTO1',
                'legenda' => "Texto livre! Na query ficará 'bla 123 %$#'. Exemplo de uso na query texto LIKE '%CAMPO_TEXTO1%'",
                'tipo' => 'texto',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_TEXTO2',
                'legenda' => "Texto livre! Na query ficará 'bla 123 %$#'. Exemplo de uso na query texto LIKE '%CAMPO_TEXTO2%'",
                'tipo' => 'texto',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_TEXTO3',
                'legenda' => "Texto livre! Na query ficará 'bla 123 %$#'. Exemplo de uso na query texto LIKE '%CAMPO_TEXTO3%'",
                'tipo' => 'texto',
                'status' => 'I',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],

            /* Campos do tipo dinheiro */
            [
                'nome' => 'CAMPO_DINHEIRO1',
                'legenda' => "Somente número real permitido para o usuário! Na query ficará 2300.50 . Exemplo de uso na query valor ='CAMPO_DINHEIRO1'",
                'mascara' => '#0.00',
                'tipo' => 'dinheiro',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_DINHEIRO2',
                'legenda' => "Somente número real permitido para o usuário! Na query ficará 2300.50 . Exemplo de uso na query valor ='CAMPO_DINHEIRO2'",
                'mascara' => '#0.00',
                'tipo' => 'dinheiro',
                'status' => 'A',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
            [
                'nome' => 'CAMPO_DINHEIRO3',
                'legenda' => "Somente número real permitido para o usuário! Na query ficará 2300.50 . Exemplo de uso na query valor ='CAMPO_DINHEIRO3'",
                'mascara' => '#0.00',
                'tipo' => 'dinheiro',
                'status' => 'I',
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ],
           
        ];
        foreach($campos as $campo){
            if(!in_array($campo['nome'], $todosCampos)){
                DB::table('relatorio_campos')->insert($campo);
            }
        }
    }
}
