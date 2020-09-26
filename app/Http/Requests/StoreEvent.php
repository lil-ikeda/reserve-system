<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEvent extends FormRequest
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
            'image' => 'file|mimes:jpg,jpeg,png',
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'date' => 'required|date',
            'open_time' => 'required',
            'close_time' => 'required',
            'place' => 'required|string|max:100',
            'price' => 'required|integer',
        ];
    }
}
