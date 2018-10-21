<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaStatus extends Model
{
    protected $table = 'agenda_status';

    public function statusSequencia($usuarioTipo)
    { 
        $res = $this->belongsToMany('App\AgendaStatus', 'agenda_status_sequencias', 'agenda_status_id', 'agenda_status_id_sequencia');
        return $res->where('agenda_status_sequencias.usuario_tipo','like','%'.$usuarioTipo.'%')->orderBy('ordem')->withTimestamps();
    }
}
