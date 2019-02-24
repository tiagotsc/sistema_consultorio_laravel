<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    #protected $fillable = ['titulo','descricao'];
}
