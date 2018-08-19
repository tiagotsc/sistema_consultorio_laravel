<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        #$this->path() URI
        #$dados = $this->all(); 
        #$dados['dataNasc'] = implode('-',array_reverse(explode('/',$dados['dataNasc'])));
        #echo '<pre>';
        #print_r($dados);
        #exit();
        return [
            'nome' => 'required',
            'medico' => 'required',
            'idPerfil' => 'required'
        ];
    }
}
