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
        $dados = $this->all(); 
        #echo '<pre>';
        #print_r($dados);
        #exit();
        return [
            'nome' => 'required',
            'tipoUsuario' => 'required',
            'perfil' => 'required'
        ];
    }
}
