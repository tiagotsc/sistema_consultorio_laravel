<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioSumarizacao extends Model
{
    protected $table = 'relatorio_sumarizacao';

    protected $fillable = ['campo', 'sumarizados', 'relatorio_id'];

    /**
     * Uma sumarização tem um ou mais relatórios
     * 1..N (Relação inversa)
     */
    public function relatorios()
    {
        return $this->belongsTo('App\Relatorio', 'id', 'id');
    }
}
