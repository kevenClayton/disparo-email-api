<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EmailDisparoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'titulo' => 'required',
            'remetente' => 'required',
            'destinatario' => 'required',
            'corpo' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'remetente.required' => 'O campo remetente é obrigatório.',
            'destinatario.required' => 'O campo destinatário é obrigatório.',
            'corpo.required' => 'O campo conteúdo é obrigatório.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        throw new HttpResponseException(response()->json([
            'message' => 'Erro de validação',
            'errors' => $errors
        ], 422));


    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

}
