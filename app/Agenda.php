<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Agenda extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::saving(function($model){ // Insert ou Update
            $model->data = ($model->data != null)? Carbon::createFromFormat('d/m/Y', $model->data): null;
            return $model;
        });

        self::retrieved(function($model){ // Select
            $model->horario = substr($model->horario,0, 5);
            $model->data = ($model->data != null)? Carbon::createFromFormat('Y-m-d', $model->data)->format('d/m/Y'): null;
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
