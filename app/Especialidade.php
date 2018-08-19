<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    public function funcionarios()
    {
        return $this->belongsToMany('App\Funcionario', 'funcionario_especialidade', 'especialidade_id', 'funcionario_id');
    }
}
