<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioCategoria extends Model
{
    protected $fillable = ['nome','status'];

    /**
     * Uma categoria tem um ou mais relatórios
     * 1..N (Relação inversa)
     */
    public function relatorios()
    {
        return $this->belongsTo('App\Relatorio', 'id', 'relatorio_categoria_id');
    }
}
