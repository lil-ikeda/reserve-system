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
            'image' => 'file|image|mimes:jpg,jpeg,png|max:1024',
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:5000',
            'date' => 'required|date|after:yesterday',
            'open_time' => 'required',
            'close_time' => 'required|after_or_equal:open_time',
            'place' => 'required|string|max:100',
            'price' => 'required|integer|min:0|max:9999999',
        ];
    }

    public function messages()
    {
        return [
            'date.after' => '日程には本日以降の日付を指定してください。'
        ];
    }
}
