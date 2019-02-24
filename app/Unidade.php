<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function telefones()
    {

        return $this->hasMany('App\UnidadeTelefone');

    }

    public function estado()
    {
        return $this->hasOne('App\Estado', 'id', 'estado_id');
    }
}
