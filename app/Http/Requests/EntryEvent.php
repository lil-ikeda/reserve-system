<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntryEvent extends FormRequest
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
        $rules = [
            'paymentMethod' => 'required', Rule::in(1, 2),
        ];

        return $this->updateRules($rules);
    }

    public function updateRules($rules)
    {
        if ($this->input('price') === 0) {
            unset($rules['paymentMethod']);
        }

        return $rules;
    }
}
