<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min: 8',
            'confirm_password' => 'required|min: 8|same:new_password',
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
            'old_password' => __('auth.common.old_password'),
            'new_password' => __('auth.common.new_password'),
            'confirm_password' => __('auth.common.confirm_password'),
        ];
    }
}
