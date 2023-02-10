<?php

namespace Modules\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:20',
            'living_place' => 'nullable|string|max:20',
            'working_place' => 'nullable|string|max:20',
            'highschool' => 'array',
            'highschool.id' => 'nullable|integer',
            'highschool.school_name' => 'nullable|string|max:20',
            'highschool.start' => 'nullable|required_unless:highschool.school_name,null|date_format:Y-m-d',
            'highschool.end' => 'nullable|required_unless:highschool.school_name,null|after_or_equal:highschool.start|date_format:Y-m-d',
            'university' => 'array',
            'university.id' => 'nullable|integer',
            'university.school_name' => 'nullable|string|max:20',
            'university.start' => 'nullable|required_unless:university.school_name,null|date_format:Y-m-d',
            'university.end' => 'nullable|required_unless:university.school_name,null|after_or_equal:university.start|date_format:Y-m-d',
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
}
