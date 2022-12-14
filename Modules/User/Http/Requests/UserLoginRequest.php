<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|min:8',
            'email' => 'required|email',
            'remember_me' => 'nullable|in:' . REMEMBER_ME
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

    public function messages()
    {
        return [
            
        ];
    }

    public function attributes()
    {
        return [
            'email' => __('auth.common.email'),
            'password' => __('auth.common.password'),
            'remember_me' => __('auth.common.remember_me')
        ];
    }
}
