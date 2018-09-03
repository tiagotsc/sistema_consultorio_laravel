<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    public function funcionarios()
    {
        return $this->belongsToMany('App\Funcionario', 'funcionario_especialidade', 'especialidade_id', 'funcionario_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'users_especialidades', 'especialidade_id', 'user_id');
    }
}
