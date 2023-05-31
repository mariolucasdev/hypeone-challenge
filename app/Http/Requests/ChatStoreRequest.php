<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'username' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título do chat é um campo obrigatório.',
            'title.max' => 'O tamanho máximo do titulo é de 255 caracteres.',
            'username.required' => 'O seu campo nome de usuário é obrigatório.',
            'username.max' => 'O tamanho máximo do nome de usuário é de 255 caracteres.',
        ];
    }
}
