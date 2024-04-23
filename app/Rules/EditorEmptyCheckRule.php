<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EditorEmptyCheckRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $descriptionString =  str_replace('&nbsp;','',trim(strip_tags($value, '<img>')));
        if(!empty($descriptionString)) {
            return true;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The description field is required.');
    }
}
