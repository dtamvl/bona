<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminTagRequest extends FormRequest
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
            'name'    => 'required|max:190|min:3|unique:tags,name,' .$this->id
        ];
    }
    public function messages()
    {
        return [
            'name.required'     => 'Dữ liệu không được để trống',
            'name.unique'       => 'Dữ liệu đã tồn tại',
            'name.max'          => 'Dữ liệu không quá 190 ký tự',
            'name.min'          => 'Dữ liệu từ 3 ký tự trở lên'
        ];
    }
}
