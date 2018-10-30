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
        $todasEspecialidades = DB::table('especialidades')->pluck('nome')->toArray();
        $especialidades = [
            ['nome' => 'Acupuntura', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Alergia e Imunologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Anestesiologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Angiologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Cancerologia (oncologia)', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Cardiologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Cirurgia Cardiovascular', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Cirurgia da Mão', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' => 'Cirurgia de cabeça e pescoço', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Cirurgia do Aparelho Digestivo', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Cirurgia Geral', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Cirurgia Pediátrica', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Cirurgia Plástica', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Cirurgia Torácica', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Cirurgia Vascular', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Clínica Médica (Medicina interna) ', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Coloproctologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Dermatologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Endocrinologia e Metabologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Endoscopia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Gastroenterologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Genética médica', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Geriatria', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Ginecologia e obstetrícia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Hematologia e Hemoterapia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Homeopatia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Infectologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Mastologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina de Família e Comunidade', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina do Trabalho', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina do Tráfego', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina Esportiva', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina Física e Reabilitação', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina Intensiva', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina Legal e Perícia Médica (ou medicina forense)', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina Nuclear', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Medicina Preventiva e Social', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Nefrologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Neurocirurgia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Neurologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Nutrologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Oftalmologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Ortopedia e Traumatologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Otorrinolaringologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Patologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Patologia Clínica/Medicina laboratorial', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Pediatria', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Pneumologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Psiquiatria', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Radiologia e Diagnóstico por Imagem', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Radioterapia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Reumatologia', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['nome' =>  'Urologia', 'created_at' => NOW(), 'updated_at' => NOW()]
        ];
        
        foreach($especialidades as $esp){
            if(!in_array($esp['nome'], $todasEspecialidades)){
                DB::table('especialidades')->insert($esp);
            }
        }
    }
}
