<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    public function usuarios()
    {                                              #Id do user Id da tabela estado
        return $this->belongsTo('App\User', 'id', 'id');
    }
}
