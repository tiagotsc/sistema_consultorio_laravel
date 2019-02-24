<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relatorio extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'query', 'relatorio_categoria_id','permission_id','banco_conexao','status',
    ];
    /**
     * Um relatório tem uma categoria
     * 1..1 (Relação direta)
     */
    public function categoria()
    {
        return $this->hasOne('App\RelatorioCategoria', 'id', 'relatorio_categoria_id');
    }

    /**
     * Um ou mais relatórios pode ter N campos
     * N..N (Relação direta)
     */
    public function campos()
    {
        return $this->belongsToMany('App\RelatorioCampo', 'relatorio_config_campos', 'relatorio_id', 'relatorio_campo_id')
                ->withPivot('nome', 'legenda', 'obrigatorio','ordem')->orderBy('ordem')
                ->withTimestamps();
    }

    /**
     * Um relatório pode ter N sumarizações
     * 1..N (Relação direta)
     */
    public function sumarizacao()
    {
        return $this->hasMany('App\RelatorioSumarizacao','relatorio_id');
    }

    /**
     * Um relatório tem uma categoria
     * 1..1 (Relação direta)
     */
    public function permissao()
    {
        #return $this->hasOne('App\Permission', 'id', 'permission_id');
        return $this->hasOne('Spatie\Permission\Models\Permission', 'id', 'permission_id');
    }
}
