<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SendMailToEntries extends FormRequest
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
        return [
            'subject' => 'required|string',
            'text' => 'required|string',
            'user_mails' => 'required',
            'user_mails.*' => 'required|string|exists:users,email',
            'user_names' => 'required',
            'user_names.*' => 'required|string|exists:users,name',
        ];
    }
}
