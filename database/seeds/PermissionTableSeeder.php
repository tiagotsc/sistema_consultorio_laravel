<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPermissionsBD = DB::table('permissions')->pluck('name')->toArray();
        $permissions = [
            ['name' => 'menu-admin', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'menu-agenda', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'usuario-listar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'usuario-criar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'usuario-editar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'usuario-apagar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'paciente-listar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'paciente-criar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'paciente-editar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'paciente-apagar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'perfil-listar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'perfil-criar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'perfil-editar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'perfil-apagar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'agenda-listar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'agenda-criar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'agenda-editar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'agenda-apagar', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
            ['name' => 'agenda-status', 'guard_name' => 'web', 'created_at' => NOW(), 'updated_at' => NOW()],
         ];

         foreach($permissions as $perm){
            if(!in_array($perm['name'], $allPermissionsBD)){
                DB::table('permissions')->insert($perm);
            }
        }
    }
}
