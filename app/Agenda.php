<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    public static function boot()
    {
        parent::boot();
        self::saving(function($model){ // Insert ou Update
            #$model->dataNasc = ($model->dataNasc != null)? Carbon::createFromFormat('d/m/Y', $model->dataNasc): null;
            #$model->status = ($model->status == 'Ativo')? 'A': 'I';
            return $model;
        });

        self::retrieved(function($model){ // Select
            $model->horario = substr($model->horario,0, 5);
            return $model;
        });
    }

    public function medico()
    {
        return $this->hasOne('App\User', 'id', 'medico_id');
    }

    public function status()
    {
        return $this->hasOne('App\AgendaStatus', 'id', 'agenda_status_id');
    }

    public function paciente()
    {
        return $this->hasOne('App\Paciente', 'id', 'paciente_id');
    }

    public function especialidade()
    {
        return $this->hasOne('App\Especialidade', 'id', 'especialidade_id');
    }

    public function usuarioMarcou()
    {
        return $this->hasOne('App\User', 'id', 'marcou_user_id');
    }
}
