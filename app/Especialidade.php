<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User', 'users_especialidades', 'especialidade_id', 'user_id');
    }
}
