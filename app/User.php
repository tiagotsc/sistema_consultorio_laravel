<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name', 'email', 'password',
    ];*/
    protected $guarded = ['id','created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){ // Insert
            $matQtd =  DB::table('users')->where('matricula', 'like', 'F'.date('ym').'%')->count() + 1; 
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
        return $this->belongsToMany('App\Especialidade', 'users_especialidades', 'user_id', 'especialidade_id')
                ->withTimestamps();
    }

    public function estado()
    {
        return $this->hasOne('App\Estado', 'id', 'estado_id');
    }

    public function unidades()
    {
        return $this->belongsToMany('App\Unidade', 'unidade_users', 'user_id', 'unidade_id')
                ->withTimestamps();
    }
}
