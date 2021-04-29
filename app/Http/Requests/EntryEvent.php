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
            'payment_method' => 'required', Rule::in(config('const.payment_method')),
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
