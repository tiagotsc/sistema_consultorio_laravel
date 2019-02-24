<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaSms extends Model
{
    protected $table = 'agenda_sms';
    protected $guarded = ['created_at', 'updated_at'];

    public function agenda()
    {
        return $this->hasOne('App\Agenda', 'id', 'agenda_id');
    }
}
