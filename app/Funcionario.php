<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
#use Spatie\Permission\Traits\HasRoles;

class Funcionario extends Model
{
    #use HasRoles;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    #protected $guard_name = 'web';

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){ // Insert
            $matQtd =  DB::table('funcionarios')->where('matricula', 'like', 'F'.date('ym').'%')->count() + 1; 
            $matricula = 'F'.date('ym').str_pad($matQtd, 3, "0", STR_PAD_LEFT);
            $model->matricula = $matricula;
            return $model;
        });
        self::saving(function($model){ // Insert ou Update
            $model->dataNasc = ($model->dataNasc != null)? Carbon::createFromFormat('d/m/Y', $model->dataNasc): null;
            return $model;
        });

        self::retrieved(function($model){ // Select
            $model->dataNasc = ($model->dataNasc != null)? Carbon::createFromFormat('Y-m-d', $model->dataNasc)->format('d/m/Y'): null;
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
