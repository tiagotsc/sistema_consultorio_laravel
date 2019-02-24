<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelatorioCampo extends Model
{
    /**
     * Um campo pode estar em ou muitos relatórios
     * n..n (Relação inversa)
     */
    public function relatorios()
    {
        return $this->belongsToMany('App\Relatorio', 'relatorio_config_campos', 'relatorio_campo_id', 'relatorio_id')
                ->withTimestamps();
    }
}
