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

    'accepted' => 'The :attribute должен быть принят.',
    'accepted_if' => ':attribute должен быть принят, когда :other равно :value.',
    'active_url' => ':attribute не является допустимым URL.',
    'after' => ':attribute должна быть датой после :date.',
    'after_or_equal' => ':attribute должна быть датой после или равной :date.',
    'alpha' => ':attribute должен содержать только буквы.',
    'alpha_dash' => ':attribute должен содержать только буквы, цифры, дефисы и символы подчеркивания.',
    'alpha_num' => ':attribute должен содержать только буквы и цифры.',
    'array' => ':attribute должен быть массивом.',
    'before' => ':attribute должна быть датой до :date.',
    'before_or_equal' => ':attribute должна быть датой, предшествующей или равной :date.',
    'between' => [
         'array' => ':attribute должно содержать от :min до :max элементов.',
         'file' => ':attribute должно быть от :min до :max килобайт.',
         'numeric' => ':attribute должен быть между :min и :max.',
         'string' => ':attribute должен быть между символами :min и :max.',
     ],
    'boolean' => 'Поле :attribute должно быть истинным или ложным.',
    'confirmed' => 'Подтверждение :attribute не совпадает.',
    'current_password' => 'Неверный пароль.',
    'date' => ':attribute не является допустимой датой.',
    'date_equals' => ':attribute должна быть датой, равной :date.',
    'date_format' => ':attribute не соответствует формату :format.',
    'declined' => ':attribute должен быть отклонен.',
    'declined_if' => ':attribute должен быть отклонен, если :other равен :value.',
    'other' => ':attribute и :other должны быть разными.',
    'digits' => ':attribute должны быть :digits цифры.',
    'digits_between' => ':attribute должно быть от :min до :max цифр.',
    'dimensions' => ':attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute имеет повторяющееся значение.',
    'doesnt_start_with' => ':attribute не может начинаться с одного из следующих: :values.',
    'email' => ':attribute должен быть действительным адресом электронной почты.',
    'ends_with' => ':attribute должен заканчиваться одним из следующих символов: :values.',
    'enum' => 'Выбранный :attribute недействителен.',
    'exists' => 'Выбранный :attribute недействителен.',
    'file' => ':attribute должен быть файлом.',
    'filled' => 'Поле :attribute должно иметь значение.',
    'gt' => [
        'array' => ':attribute должно содержать более :value элементов.',
        'file' => ':attribute должно быть больше :value килобайт.',
        'numeric' => ':attribute должно быть больше :value.',
        'string' => ':attribute должно быть больше символов :value.',
    ],
    'gte' => [
        'array' => 'В :attribute должно быть не менее :value элементов.',
        'file' => ':attribute должно быть больше или равно :value килобайтам.',
        'numeric' => ':attribute должно быть больше или равно :value.',
        'string' => ':attribute должно быть больше или равно :value символов.',
    ],
    'image' => ':attribute должно быть изображением.',
    'in' => 'Выбранный :attribute недействителен.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => ':attribute должно быть целым числом.',
    'ip' => ':attribute должен быть действительным IP-адресом.',
    'ipv4' => ':attribute должен быть действительным адресом IPv4.',
    'ipv6' => ':attribute должен быть действительным адресом IPv6.',
    'json' => ':attribute должен быть допустимой строкой JSON.',
    'lt' => [
        'array' => 'В :attribute должно быть меньше :value элементов.',
        'file' => ':attribute должно быть меньше :value килобайт.',
        'numeric' => ':attribute должно быть меньше :value.',
        'string' => ':attribute должно содержать менее :value символов.',
    ],
    'lte' => [
        'array' => ':attribute не должно содержать более :value элементов.',
        'file' => ':attribute должно быть меньше или равно :value килобайтам.',
        'numeric' => ':attribute должно быть меньше или равно :value.',
        'string' => ':attribute должно быть меньше или равно :value символов.',
    ],
    'mac_address' => ':attribute должен быть действительным MAC-адресом.',
    'max' => [
        'array' => ':attribute не может содержать более :max элементов.',
        'file' => ':attribute не должен превышать :max килобайт.',
        'numeric' => ':attribute не должно быть больше, чем :max.',
        'string' => ':attribute не должно быть больше, чем :max символов.',
    ],
    'mimes' => ':attribute должен быть файлом типа: :values.',
    'mimetypes' => ':attribute должен быть файлом типа: :values.',
    'min' => [
        'array' => 'В :attribute должно быть не менее :min элементов.',
        'file' => ':attribute должен быть не менее :min килобайт.',
        'numeric' => ':attribute должно быть не меньше :min.',
        'string' => ':attribute должно содержать не менее :min символов.',
    ],
    'multiple_of' => ':attribute должно быть кратно :value.',
    'not_in' => 'Выбранный :attribute недействителен.',
    'not_regex' => 'Недопустимый формат :attribute.',
    'numeric' => ':attribute должен быть числом.',
    'password' => [
        'letters' => ':attribute должен содержать хотя бы одну букву.',
        'mixed' => ':attribute должен содержать хотя бы одну прописную и одну строчную букву.',
        'numbers' => ':attribute должен содержать хотя бы одно число.',
        'symbols' => ':attribute должен содержать хотя бы один символ.',
        'uncompromised' => 'Данный :attribute появился в результате утечки данных. Пожалуйста, выберите другой :attribute.',
    ],
    'present' => 'Поле :attribute должно присутствовать.',
    'prohibited' => 'Поле :attribute запрещено.',
    'prohibited_if' => 'Поле :attribute запрещено, если :other равно :value.',
    'prohibited_unless' => 'Поле :attribute запрещено, если только :other не находится в :values.',
    'prohibits' => 'Поле :attribute запрещает присутствие :other.',
    'regex' => 'Недопустимый формат :attribute.',
    'required' => 'Обязательно для заполнения поля :attribute.',
    'required_array_keys' => 'Поле :attribute должно содержать записи для: :values.',
    'required_if' => 'Поле :attribute обязательно, если :other равно :value.',
    'required_unless' => 'Поле :attribute является обязательным, если только :other не находится в :values.',
    'required_with' => 'Поле :attribute обязательно, когда :values настоящее.',
    'required_with_all' => 'Поле :attribute обязательно, когда :values присутствуют.',
    'required_without' => 'Поле :attribute обязательно, когда :values нет.',
    'required_without_all' => 'Поле :attribute обязательно, если ни одно из :values присутствуют.',
    'same' => ':attribute и :other должны совпадать.',
    'size' => [
        'array' => ':attribute должен содержать :size элементов.',
        'file' => ':attribute должно быть :size килобайт.',
        'numeric' => ':attribute должно быть :size.',
        'string' => ':attribute должно состоять из :size символов.',
    ],
    'starts_with' => ':attribute должен начинаться с одного из следующих: :values.',
    'string' => ':attribute должен быть строкой.',
    'timezone' => ':attribute должен быть действительным часовым поясом.',
    'unique' => ':attribute уже занято.',
    'uploaded' => ':attribute не удалось загрузить.',
    'url' => ':attribute должен быть действительным URL.',
    'uuid' => ':attribute должен быть действительным UUID.',

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
