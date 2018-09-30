<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Paciente extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){ // Insert
            $matQtd =  DB::table('pacientes')->where('matricula', 'like', 'P'.date('ym').'%')->count() + 1; 
            $matricula = 'P'.date('ym').str_pad($matQtd, 3, "0", STR_PAD_LEFT);
            
            $model->matricula = $matricula;
            return $model;
        });
        self::saving(function($model){ // Insert ou Update
            $model->dataNasc = ($model->dataNasc != null)? Carbon::createFromFormat('d/m/Y', $model->dataNasc): null;
            #$model->status = (strlen($model->status) > 1)? substr($model->status,0,1): $model->status;
            return $model;
        });

        self::retrieved(function($model){ // Select
            $model->dataNasc = ($model->dataNasc != null)? Carbon::createFromFormat('Y-m-d', $model->dataNasc)->format('d/m/Y'): null;
            #$model->status = ($model->status == 'A')? 'Ativo': 'Inativo';
            return $model;
        });
    }

    public function getStatusNomeAttribute($valor)
    {
        return ($valor == 'A')? 'Ativo': 'Inativo';
    }
}
