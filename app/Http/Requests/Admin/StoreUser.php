<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'name' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-zA-ZÀ-ẾỀỂỆỄÍÌĨỈÓÒỎỌÕỐỒỔỖỘÔỐỒỔỖỘƠỚỜỞỢỠÚÙỦỤŨỨỪỬỮỰÝỲỴỶỸĐđà-ếềểệễíìĩỉóòỏọõốồổỗộôồỗộơớờởợỡúùủụũưứừửữựýỳỵỷỹ\s]+$/u'],            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:100|same:password_confirmation',
            'password_confirmation'=>'required',
            'role' => 'required'
        ];
    }
}