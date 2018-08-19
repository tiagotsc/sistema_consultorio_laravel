<?php

use Illuminate\Database\Seeder;

class EspecialidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('especialidades')->insert(['nome' => 'Acupuntura']);
		DB::table('especialidades')->insert(['nome' => 'Alergia e Imunologia']);
		DB::table('especialidades')->insert(['nome' => 'Anestesiologia']);
		DB::table('especialidades')->insert(['nome' => 'Angiologia']);
		DB::table('especialidades')->insert(['nome' => 'Cancerologia (oncologia)']);
		DB::table('especialidades')->insert(['nome' => 'Cardiologia']);
		DB::table('especialidades')->insert(['nome' => 'Cirurgia Cardiovascular']);
		DB::table('especialidades')->insert(['nome' => 'Cirurgia da Mão']);
		DB::table('especialidades')->insert(['nome' => 'Cirurgia de cabeça e pescoço']);
		DB::table('especialidades')->insert(['nome' =>  'Cirurgia do Aparelho Digestivo']);
		DB::table('especialidades')->insert(['nome' =>  'Cirurgia Geral']);
		DB::table('especialidades')->insert(['nome' =>  'Cirurgia Pediátrica']);
		DB::table('especialidades')->insert(['nome' =>  'Cirurgia Plástica']);
		DB::table('especialidades')->insert(['nome' =>  'Cirurgia Torácica']);
		DB::table('especialidades')->insert(['nome' =>  'Cirurgia Vascular']);
		DB::table('especialidades')->insert(['nome' =>  'Clínica Médica (Medicina interna) ']);
		DB::table('especialidades')->insert(['nome' =>  'Coloproctologia']);
		DB::table('especialidades')->insert(['nome' =>  'Dermatologia']);
		DB::table('especialidades')->insert(['nome' =>  'Endocrinologia e Metabologia']);
		DB::table('especialidades')->insert(['nome' =>  'Endoscopia']);
		DB::table('especialidades')->insert(['nome' =>  'Gastroenterologia']);
		DB::table('especialidades')->insert(['nome' =>  'Genética médica']);
		DB::table('especialidades')->insert(['nome' =>  'Geriatria']);
		DB::table('especialidades')->insert(['nome' =>  'Ginecologia e obstetrícia']);
		DB::table('especialidades')->insert(['nome' =>  'Hematologia e Hemoterapia']);
		DB::table('especialidades')->insert(['nome' =>  'Homeopatia']);
		DB::table('especialidades')->insert(['nome' =>  'Infectologia']);
		DB::table('especialidades')->insert(['nome' =>  'Mastologia']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina de Família e Comunidade']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina do Trabalho']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina do Tráfego']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina Esportiva']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina Física e Reabilitação']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina Intensiva']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina Legal e Perícia Médica (ou medicina forense)']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina Nuclear']);
		DB::table('especialidades')->insert(['nome' =>  'Medicina Preventiva e Social']);
		DB::table('especialidades')->insert(['nome' =>  'Nefrologia']);
		DB::table('especialidades')->insert(['nome' =>  'Neurocirurgia']);
		DB::table('especialidades')->insert(['nome' =>  'Neurologia']);
		DB::table('especialidades')->insert(['nome' =>  'Nutrologia']);
		DB::table('especialidades')->insert(['nome' =>  'Oftalmologia']);
		DB::table('especialidades')->insert(['nome' =>  'Ortopedia e Traumatologia']);
		DB::table('especialidades')->insert(['nome' =>  'Otorrinolaringologia']);
		DB::table('especialidades')->insert(['nome' =>  'Patologia']);
		DB::table('especialidades')->insert(['nome' =>  'Patologia Clínica/Medicina laboratorial']);
		DB::table('especialidades')->insert(['nome' =>  'Pediatria']);
		DB::table('especialidades')->insert(['nome' =>  'Pneumologia']);
		DB::table('especialidades')->insert(['nome' =>  'Psiquiatria']);
		DB::table('especialidades')->insert(['nome' =>  'Radiologia e Diagnóstico por Imagem']);
		DB::table('especialidades')->insert(['nome' =>  'Radioterapia']);
		DB::table('especialidades')->insert(['nome' =>  'Reumatologia']);
		DB::table('especialidades')->insert(['nome' =>  'Urologia']);
    }
}
