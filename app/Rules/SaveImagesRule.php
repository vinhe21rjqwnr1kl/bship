<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SaveImagesRule implements Rule
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
		$allImages = request()->file();

		if (!empty($allImages))
		{
			$extension          = array_values(config('constants.extensions'));
			$extension          = array_reduce($extension, 'array_merge', array());
			foreach ($allImages as $image) 
			{
				if (!empty($image) && is_array($image))
				{
					foreach ($image as $value) 
					{
						$imageExt 	= '.'.$value->getClientOriginalExtension();
						$zipSize	= number_format($value->getSize() / 1048576,2);

						if (!in_array($imageExt, $extension))
						{
							return false;
						}
					}
				}
			}
		}

		return true;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		$extension          = array_values(config('constants.extensions'));
		$extension          = array_reduce($extension, 'array_merge', array());
		$extension          = implode(', ', $extension);

		return __('Only '.$extension.' files are allowed');
	}
}
