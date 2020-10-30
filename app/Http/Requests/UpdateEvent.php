<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvent extends FormRequest
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
            'image' => 'file|image|mimes:jpg,jpeg,png',
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:5000',
            'date' => 'required|date',
            'open_time' => 'required',
            'close_time' => 'required|after_or_equal:open_time',
            'place' => 'required|string|max:100',
            'price' => 'required|integer|min:0',
        ];
    }
}
