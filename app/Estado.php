<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public function funcionarios()
    {                                              #Id do funcionario Id da tabela estado
        return $this->belongsTo('App\Funcionario', 'id', 'id');
    }
}
