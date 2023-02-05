<?php

namespace Modules\User\Http\Requests\Post;

use App\Models\Community;
use Illuminate\Foundation\Http\FormRequest;

class PostCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'community' => 'integer|min:1|exists:' . Community::class . ',id|nullable',
            'share' => 'integer|min:1|nullable',
            'video' => 'mimetypes:video/mp4,video/avi,video/mpeg|prohibited_unless:share,null|nullable'
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
