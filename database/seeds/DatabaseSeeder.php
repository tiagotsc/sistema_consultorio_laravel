<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                        AgendaConfigTableSeeder::class,
                        AgendaStatusTableSeeder::class,
                        AgendaStatusSequenciaTableSeeder::class,
                        EspecialidadesTableSeeder::class,
                        EstadosTableSeeder::class,
                        PermissionTableSeeder::class,
                    ]);
    }
}
