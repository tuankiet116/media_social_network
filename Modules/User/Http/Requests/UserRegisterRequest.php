<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min: 8',
            'password_cf' => 'required|same:password'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'email' => __('auth.common.email'),
            'password' => __('auth.common.password'),
            'password_cf' => __('auth.common.reenter_password'),
            'name' => __('auth.common.name')
        ];
    }
}
