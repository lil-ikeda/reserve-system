<?php
namespace App\Http\Requests;

use App\Repositories\Params\UserParams;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
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
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->id],
            'phone' => ['required', 'string'],
            'circle_id' => ['required', 'integer', 'exists:circles,id'],
            'birthday' => ['required'],
            'sex' => ['required', Rule::in([config('const.sex.male.id'), config('const.sex.female.id'), config('const.sex.do_not_answer.id')])],
        ];
    }

    /**
     * パラメータを取得
     *
     * @return UserParams
     */
    public function getParams(): UserParams
    {
        return new UserParams(
            $this->file,
            $this->input('name'),
            $this->input('email'),
            $this->input('phone'),
            (int)$this->input('circle_id'),
            $this->input('birthday'),
            $this->input('sex')
        );
    }
}
