<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute cần được chấp nhận.',
    'accepted_if' => ':attribute cần được chấp nhận khi :other là :value.',
    'active_url' => ':attribute không phải là URL hợp lệ.',
    'after' => 'Ngày :attribute phải là ngày sau ngày :date.',
    'after_or_equal' => 'Ngày :attribute phải là ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ được chứa chữ cái.',
    'alpha_dash' => ':attribute chỉ được chứa chữ cái, số , dấu gạch ngang hoặc dấu gạch ngang dưới.',
    'alpha_num' => ':attribute chỉ được chứa số và chữ cái.',
    'array' => ':attribute phải là 1 mảng.',
    'before' => 'Ngày :attribute phải là ngày trước ngày :date.',
    'before_or_equal' => 'Ngày :attribute phải là ngày trước hoặc bằng với :date.',
    'between' => [
        'numeric' => ':attribute phải nằm giữa :min và :max.',
        'file' => ':attribute phải nằm giữa :min và :max kilobytes.',
        'string' => ':attribute có độ dài ký tự phải nằm giữa :min và :max.',
        'array' => ':attribute phải có các thành phần nằm giữa :min và :max.',
    ],
    'boolean' => ':attribute chỉ là true hoặc false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute và :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute phải nằm giữa :min và :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'string' => 'The :attribute must be greater than :value characters.',
        'array' => 'The :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
        'array' => 'The :attribute must have :value items or more.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'The :attribute must not be greater than :max.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'string' => 'The :attribute must not be greater than :max characters.',
        'array' => 'The :attribute must not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute tối thiểu phải là :min.',
        'file' => 'Kích cỡ :attribute tối thiểu phải là :min kilobytes.',
        'string' => ':attribute tối thiểu phải là :min ký tự.',
        'array' => ':attribute tối thiểu phải chứa :min thành phần.',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    'password' => 'The password is incorrect.',
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute là bắt buộc.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => ':attribute là bắt buộc khi :other is :value.',
    'required_unless' => ':attribute là bắt buộc unless :other is in :values.',
    'required_with' => ':attribute là bắt buộc khi :values tồn tại.',
    'required_with_all' => ':attribute là bắt buộc khi :values đang tồn tại.',
    'required_without' => ':attribute là bắt buộc khi :values không tồn tại.',
    'required_without_all' => ':attribute là bắt buộc khi không có :values đang tồn tại.',
    'same' => ':attribute và :other phải trùng nhau.',
    'size' => [
        'numeric' => ':attribute phải là :size.',
        'file' => 'Kích cỡ :attribute phải là :size kilobytes.',
        'string' => ':attribute phải là :size ký tự.',
        'array' => ':attribute phải chứa :size thành phần.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute phải là a string.',
    'timezone' => 'The :attribute phải là a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute phải là a valid URL.',
    'uuid' => 'The :attribute phải là a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
