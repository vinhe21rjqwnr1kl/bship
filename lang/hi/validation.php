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

    'accepted' => ':attribute को स्वीकार किया जाना चाहिए।',
    'accepted_if' => ':attribute को तब स्वीकार किया जाना चाहिए जब :other :value हो।',
    'active_url' => ':attribute मान्य यूआरएल नहीं है।',
    'after' => ':attribute :तारीख के बाद की तारीख होनी चाहिए।',
    'after_or_equal' => ':attribute:तारीख के बाद या उसके बराबर की तारीख होनी चाहिए।',
    'alpha' => ':attribute में केवल अक्षर होने चाहिए।',
    'alpha_dash' => ':attribute में केवल अक्षर, संख्याएं, डैश और अंडरस्कोर होने चाहिए।',
    'alpha_num' => ':attribute में केवल अक्षर और अंक होने चाहिए।',
    'array' => ':attribute एक सरणी होनी चाहिए।',
    'before' => ':attribute:date से पहले की तारीख होनी चाहिए।',
    'before_or_equal' => ':attribute:तारीख से पहले या उसके बराबर की तारीख होनी चाहिए।',
    'between' => [
        'array' => ':attribute में :min और :max आइटम के बीच होना चाहिए।',
        'file' => ':attribute :min और :max किलोबाइट्स के बीच होना चाहिए।',
        'numeric' => ':attribute :min और :max के बीच होनी चाहिए।',
        'string' => ':attribute :min और :max वर्णों के बीच होनी चाहिए।',
    ],
    'boolean' => ':attribute क्षेत्र सही या गलत होना चाहिए।',
    'confirmed' => ':attribute पुष्टि मेल नहीं खाती।',
    'current_password' => 'पासवर्ड गलत है।',
    'date' => ':attribute मान्य तिथि नहीं है।',
    'date_equals' => ':attribute का दिनांक :date के बराबर होना चाहिए।',
    'date_format' => ':attribute प्रारूप :format से मेल नहीं खाती।',
    'declined' => ':attribute को अस्वीकार किया जाना चाहिए।',
    'declined_if' => ':attribute को अस्वीकार किया जाना चाहिए जब :अन्य :value हो।',
    'different' => ':attribute और : अन्य अलग होना चाहिए।',
    'digits' => ':गुण :अंक अंक होना चाहिए।',
    'digits_between' => ':attribute :min और :max अंकों के बीच होनी चाहिए।',
    'dimensions' => ':attribute में अमान्य छवि आयाम हैं।',
    'distinct' => ':attribute फील्ड में डुप्लीकेट वैल्यू है।',
    'doesnt_start_with' => ':attribute निम्नलिखित में से किसी एक के साथ शुरू नहीं हो सकती है:values',
    'email' => ':attribute एक मान्य ईमेल पता होना चाहिए।',
    'ends_with' => ':attribute निम्नलिखित में से किसी एक के साथ समाप्त होनी चाहिए: :value।',
    'enum' => 'चयनित :attribute अमान्य है।',
    'exists' => 'चयनित :attribute अमान्य है।',
    'file' => ':attribute एक फ़ाइल होनी चाहिए।',
    'filled' => ':attribute क्षेत्र में एक मान होना चाहिए।',
    'gt' => [
        'array' => ':attribute में इससे अधिक होना चाहिए:value आइटम।',
        'file' => ':attribute:value किलोबाइट्स से अधिक होनी चाहिए।',
        'numeric' => ':attribute :value से अधिक होनी चाहिए।',
        'string' => ':attribute:value वर्णों से अधिक होना चाहिए।',
    ],
    'gte' => [
        'array' => ':attribute में:value आइटम या अधिक होना चाहिए।',
        'file' => ':attribute:value किलोबाइट्स से अधिक या उसके बराबर होनी चाहिए।',
        'numeric' => ':attribute :value से अधिक या उसके बराबर होनी चाहिए।',
        'string' => ':attribute :value वर्णों से अधिक या उसके बराबर होनी चाहिए।',
    ],
    'image' => ':attribute एक छवि होनी चाहिए।',
    'in' => 'चयनित :attribute अमान्य है।',
    'in_array' => ':attribute फील्ड :other में मौजूद नहीं है।',
    'integer' => ':attribute एक पूर्णांक होनी चाहिए।',
    'ip' => ':attribute एक वैध आईपी पता होना चाहिए।',
    'ipv4' => ':attribute एक मान्य IPv4 पता होना चाहिए।',
    'ipv6' => ':attribute एक मान्य IPv6 पता होना चाहिए।',
    'json' => ':attribute एक मान्य JSON स्ट्रिंग होनी चाहिए।',
    'lt' => [
        'array' => ':attribute में इससे कम होना चाहिए:value आइटम।',
        'file' => ':attribute:value किलोबाइट्स से कम होना चाहिए।',
        'numeric' => ':attribute :value से कम होना चाहिए।',
        'string' => ':attribute :value वर्णों से कम होनी चाहिए।',
    ],
    'lte' => [
        'array' => ':attribute में इससे अधिक नहीं होना चाहिए:value आइटम।',
        'file' => ':attribute :value किलोबाइट्स से कम या बराबर होनी चाहिए।',
        'numeric' => ':attribute :value से कम या उसके बराबर होनी चाहिए।',
        'string' => ':attribute :value वर्णों से कम या बराबर होनी चाहिए।',
    ],
    'mac_address' => ': attribute एक मान्य मैक पता होना चाहिए.',
    'max' => [
        'array' => ':attribute में :max आइटम से अधिक नहीं होना चाहिए।',
        'file' => ':attribute :max किलोबाइट्स से अधिक नहीं होनी चाहिए।',
        'numeric' => ':attribute :max से अधिक नहीं होनी चाहिए।',
        'string' => ':attribute:max वर्णों से अधिक नहीं होनी चाहिए।',
    ],
    'mimes' => ':attribute: :values प्रकार की फ़ाइल होनी चाहिए।',
    'mimetypes' => ':attribute: :values प्रकार की फ़ाइल होनी चाहिए।',
    'min' => [
        'array' => ':attribute में कम से कम :min आइटम होने चाहिए।',
        'file' => ':attribute कम से कम :min किलोबाइट होना चाहिए।',
        'numeric' => ':गुण कम से कम :min होना चाहिए।',
        'string' => ':attribute कम से कम :min अक्षर होना चाहिए।',
    ],
    'multiple_of' => ':attribute को :value का गुणज होना चाहिए।',
    'not_in' => 'चयनित :attribute अमान्य है।',
    'not_regex' => ':attribute प्रारूप अमान्य है।',
    'numeric' => ':attribute एक संख्या होनी चाहिए।',
    'password' => [
        'letters' => ':attribute में कम से कम एक अक्षर होना चाहिए।',
        'mixed' => ':attribute में कम से कम एक अपरकेस और एक लोअरकेस अक्षर होना चाहिए।',
        'numbers' => ':attribute में कम से कम एक संख्या होनी चाहिए।',
        'symbols' => ':attribute में कम से कम एक प्रतीक होना चाहिए।',
        'uncompromised' => 'दी गई :attribute डेटा लीक में प्रकट हुई है। कृपया कोई भिन्न :attribute चुनें।',
    ],
    'present' => ':attribute क्षेत्र मौजूद होना चाहिए।',
    'prohibited' => ':attribute क्षेत्र निषिद्ध है।',
    'prohibited_if' => ' :attribute फील्ड प्रतिबंधित है जब :other :value हो।',
    'prohibited_unless' => ':attribute फील्ड तब तक प्रतिबंधित है जब तक कि :other :values में न हो।',
    'prohibits' => ':attribute क्षेत्र :other को उपस्थित होने से रोकता है।',
    'regex' => ':attribute प्रारूप अमान्य है।',
    'required' => ':attribute फ़ील्ड आवश्यक है।',
    'required_array_keys' => ':attribute फ़ील्ड में इसके लिए प्रविष्टियाँ होनी चाहिए:values',
    'required_if' => ' :attribute फील्ड तब आवश्यक होता है जब :other :value हो।',
    'required_unless' => ' :attribute फील्ड आवश्यक है जब तक कि :other :values में न हो।',
    'required_with' => ' :attribute फील्ड तब आवश्यक होता है जब :values मौजूद हों।',
    'required_with_all' => ':attribute फ़ील्ड आवश्यक है जब :values मौजूद हों।',
    'required_without' => ':attribute फील्ड तब जरूरी होता है जब :values मौजूद न हो।',
    'required_without_all' => ':attribute फ़ील्ड आवश्यक है जब कोई भी :values मौजूद न हो।',
    'same' => 'द :attribute और :other को मेल खाना चाहिए।',
    'size' => [
        'array' => ':attribute में :size आइटम शामिल होने चाहिए।',
        'file' => ':attribute :size किलोबाइट होनी चाहिए।',
        'numeric' => ':attribute का आकार होना चाहिए।',
        'string' => ':attribute :size कैरेक्टर होना चाहिए।',
    ],
    'start_with' => ':attribute निम्नलिखित में से किसी एक के साथ शुरू होनी चाहिए :values',
    'string' => ':attribute एक स्ट्रिंग होनी चाहिए।',
    'timezone' => ':attribute एक मान्य समयक्षेत्र होना चाहिए।',
    'unique' => ':attribute पहले ही ली जा चुकी है।',
    'uploaded' => ':attribute अपलोड करने में विफल',
    'url' => ':attribute एक मान्य URL होना चाहिए।',
    'uuid' => ':attribute एक मान्य UUID होनी चाहिए।',

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
            'rule-name' => 'सीमा शुल्क संदेश',
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
