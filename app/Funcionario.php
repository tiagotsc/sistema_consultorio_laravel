<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Funcionario extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $matQtd =  DB::table('funcionarios')->where('matricula', 'like', 'F'.date('ym').'%')->count() + 1; 
            $matricula = 'F'.date('ym').str_pad($matQtd, 3, "0", STR_PAD_LEFT);
            $model->matricula = $matricula;
            return $model;
        });
        self::saving(function($model){
            $model->dataNasc = ($model->dataNasc != null)? implode('-',array_reverse(explode('/',$model->dataNasc))): null;
            return $model;
        });
    }

    public function especialidades()
    {
        return $this->belongsToMany('App\Especialidade', 'funcionarios_especialidades', 'funcionario_id', 'especialidade_id')
                ->withTimestamps();
    }

    public function estado()
    {
        return $this->hasOne('App\Estado', 'id', 'estado_id');
    }
}
