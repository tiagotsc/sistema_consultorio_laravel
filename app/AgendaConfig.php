<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaConfig extends Model
{
    protected $guarded = ['created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::saving(function($model){ // Insert ou Update
            $model->inicio = $model->inicio.":00:00";
            $model->fim = $model->fim.":00:00";
            return $model;
        });

        self::retrieved(function($model){ // Select
            $model->inicio = substr($model->inicio,0,2);
            $model->fim = substr($model->fim,0,2);
            return $model;
        });
    }
}
