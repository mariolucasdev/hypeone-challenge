<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
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
            'chat_id' => 'required|exists:chats,id',
            'content' => 'required',
            'username' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'chat_id.required' => 'Chat não encontrado.',
            'chat_id.exists' => 'Não localizamos o chat o qual deseja enviar mensagem.',
            'content.required' => 'Não é possível enviar uma mensagem vazia.',
            'username.required' => 'O nome do usuário não pode ser vazio.',
            'username.max' => 'O tamanho máximo do nome de usuário é de 255 caracteres.',
        ];
    }
}
