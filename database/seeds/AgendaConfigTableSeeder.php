<?php

use Illuminate\Database\Seeder;

class AgendaConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agenda_configs')->delete();
        DB::table('agenda_configs')->insert(['inicio' => '09:00', 'fim' => '18:00', 'intervalo' => '15', 'created_at' => NOW(), 'updated_at' => NOW()]);
    }
}
