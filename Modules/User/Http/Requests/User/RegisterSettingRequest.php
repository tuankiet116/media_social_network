<?php

namespace Modules\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // dd($this->all());
        return [
            'avatar_image' => 'nullable|required_if:avatar_image_choose,null|image|max:20000',
            'banner_image' => 'nullable|image|max:20000',
            'avatar_image_choose' => 'nullable|required_if:avatar_image,null',
            'living_place' => 'nullable|string|max:20',
            'working_place' => 'nullable|string|max:20',
            'highschool_name' => 'nullable|string|max:20',
            'highschool_time_start' => 'nullable|required_unless:highschool_name,null|date_format:d/m/Y',
            'highschool_time_end' => 'nullable|required_unless:highschool_name,null|after_or_equal:highschool_time_start|date_format:d/m/Y',
            'university_name' => 'nullable|string|max:20',
            'university_time_start' => 'nullable|required_unless:university_name,null|date_format:d/m/Y',
            'university_time_end' => 'nullable|required_unless:university_name,null|after_or_equal:university_time_start|date_format:d/m/Y',
            'gender' => 'required|in:male,female,other'
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
            'avatar_image' => __('attributes.avatar_image'),
            'banner_image' => __('attributes.banner_image'),
            'avatar_image_choose' => __('attributes.avatar_image_choose'),
            'living_place' => __('attributes.living_place'),
            'working_place' => __('attributes.working_place'),
            'highschool_name' => __('attributes.highschool_name'),
            'highschool_time_start' => __('attributes.highschool_time_start'),
            'highschool_time_end' => __('attributes.highschool_time_end'),
            'university_name' => __('attributes.university_name'),
            'university_time_start' => __('attributes.university_time_start'),
            'university_time_end' => __('attributes.university_time_end'),
            'gender' => __('attributes.gender')
        ];
    }

    public function messages()
    {
        return [
            'avatar_image.required_if' => __('messages.001'),
            'avatar_image_choose.required_if' => __('messages.001'),
        ];
    }
}
