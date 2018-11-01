<?php

use Illuminate\Database\Seeder;

class UsuarioAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfilAdm = DB::table('roles')->where('name','Administrador Sistema')->first();
        if($perfilAdm == null){
            DB::table('roles')->insert(
                [
                    'name' => 'Administrador Sistema',
                    'guard_name' => 'web',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]
            );
            $perfilAdm = DB::table('roles')->where('name','Administrador Sistema')->first();
        }
        $permissoesAdmin = DB::table('role_has_permissions')->where('role_id',$perfilAdm->id)->pluck('permission_id')->toArray();
        $todasPermissoes = DB::table('permissions')->whereNotIn('id',$permissoesAdmin)->get()->toArray();
        foreach($todasPermissoes as $perm){
            DB::insert('insert into role_has_permissions (permission_id, role_id) values ('.$perm->id.', '.$perfilAdm->id.')');
        }
        $userAdm = DB::table('users')->where('name','Administrador Sistema')->first();
        if($userAdm == null){
            DB::table('users')->insert(
                [
                    'name' => 'Administrador Sistema',
                    'email' => 'adm@adm.com.br',
                    'password' => bcrypt('123456'),
                    'medico' => 'S',
                    'created_at' => NOW(),
                    'updated_at' => NOW()
                ]
            );
            $userAdm = DB::table('users')->where('name','Administrador Sistema')->first();
        }
        DB::table('model_has_roles')->where([['role_id', $perfilAdm->id],['model_id', $userAdm->id]])->delete();
        DB::insert("insert into model_has_roles (role_id, model_type, model_id) values (".$perfilAdm->id.", 'App\\\User', ".$userAdm->id.")");
    }
}
