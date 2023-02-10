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
    'before' => ':attribute phải là ngày trước :date.',
    'before_or_equal' => ':attribute phải là ngày trước hoặc bằng với :date.',
    'between' => [
        'numeric' => ':attribute phải nằm giữa :min và :max.',
        'file' => ':attribute phải nằm giữa :min và :max kilobytes.',
        'string' => ':attribute có độ dài ký tự phải nằm giữa :min và :max.',
        'array' => ':attribute phải có các thành phần nằm giữa :min và :max.',
    ],
    'boolean' => ':attribute chỉ là true hoặc false.',
    'confirmed' => ':attribute xác nhận không khớp.',
    'current_password' => 'Mật khẩu không chính xác.',
    'date' => ':attribute không phải là ngày hợp lệ.',
    'date_equals' => ':attribute phải bằng với ngày :date.',
    'date_format' => ':attribute không đúng với định dạng :format.',
    'declined' => ':attribute phải là từ chối.',
    'declined_if' => ':attribute phải là từ chối khi :other là :value.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải có :digits số.',
    'digits_between' => ':attribute phải nằm giữa :min và :max số.',
    'dimensions' => ':attribute có kích thước không phù hợp.',
    'distinct' => ':attribute bị trùng lặp giá trị.',
    'email' => ':attribute phải là địa chỉ email hợp lệ.',
    'ends_with' => ':attribute phải kết thúc với một trong các giá trị: :values.',
    'enum' => ':attribute được chọn không hợp lệ.',
    'exists' => ':attribute được chọn hợp lệ.',
    'file' => ':attribute phải là 1 tệp.',
    'filled' => ':attribute phải có 1 giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải có nhiều hơn hoặc :value ký tự.',
        'array' => ':attribute phải có ít nhất :value phần tử.',
    ],
    'image' => ':attribute phải là hình ảnh.',
    'in' => ':attribute được chọn không hợp lệ.',
    'in_array' => ':attribute không tồn tại trong :other.',
    'integer' => ':attribute phải là một số nguyên.',
    'ip' => ':attribute phải là địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là địa chỉ IPv4 hợp lệ IPv4.',
    'ipv6' => ':attribute phải là địa chỉ IPv6 hợp lệ IPv6.',
    'json' => ':attribute phải là chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải có ít hơn :value.',
        'file' => ':attribute phải có ít hơn :value kilobytes.',
        'string' => ':attribute phải có ít hơn :value ký tự.',
        'array' => ':attribute phải chứa ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải ít hơn hoặc bằng :value.',
        'file' => ':attribute phải ít hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải ít hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được chứa nhiều hơn :value phần tử.',
    ],
    'mac_address' => ':attribute phải là địa chỉ MAC hợp lệ.',
    'max' => [
        'numeric' => ':attribute không được lớn hơn :max.',
        'file' => ':attribute không được lớn hơn :max kilobytes.',
        'string' => ':attribute không được lớn hơn :max ký tự.',
        'array' => ':attribute không được nhiều hơn :max phần tử.',
    ],
    'mimes' => ':attribute phải là tệp kiểu: :values.',
    'mimetypes' => ':attribute phải là tệp kiểu: :values.',
    'min' => [
        'numeric' => ':attribute tối thiểu phải là :min.',
        'file' => 'Kích cỡ :attribute tối thiểu phải là :min kilobytes.',
        'string' => ':attribute tối thiểu phải là :min ký tự.',
        'array' => ':attribute tối thiểu phải chứa :min thành phần.',
    ],
    'multiple_of' => ':attribute phải là số nhiều của :value.',
    'not_in' => ':attribute được chọn không hợp lệ.',
    'not_regex' => ':attribute định dạng không hợp lệ.',
    'numeric' => ':attribute phải là số.',
    'password' => 'Mật khẩu không chính xác.',
    'present' => 'Trường :attribute phải đang hiện hữu.',
    'prohibited' => ':attribute đã bị cấm.',
    'prohibited_if' => 'The :attribute bị cấm khi :other là :value.',
    'prohibited_unless' => 'The :attribute bị cấm trừ khi :other nằm trong :values.',
    'prohibits' => 'Trường :attribute cấm :other hiện hữu.',
    'regex' => ':attribute định dạng không chính xác.',
    'required' => ':attribute là bắt buộc.',
    'required_array_keys' => 'Trường :attribute phải chứa các mục của: :values.',
    'required_if' => ':attribute là bắt buộc khi :other là :value.',
    'required_unless' => ':attribute là bắt buộc trừ khi :other trong giá trị :values.',
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
    'starts_with' => ':attribute phải bắt đầu bằng 1 trong các giá trị sau: :values.',
    'string' => ':attribute phải là chuỗi.',
    'timezone' => ':attribute phải là timezone hợp lệ.',
    'unique' => ':attribute đã được chọn.',
    'uploaded' => ':attribute tải lên lỗi.',
    'url' => ':attribute phải là a URL hợp lệ.',
    'uuid' => ':attribute phải là a UUID hợp lệ.',

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
