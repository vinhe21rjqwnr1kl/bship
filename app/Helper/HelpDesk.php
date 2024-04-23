<?php
namespace App\Helper;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\PageMeta;

class HelpDesk
{
	public static function configuration_menu()
	{
		$allprefix = array();
		$Configuration = new \App\Models\Configuration();
		$allprefixarray = $Configuration->getprefix();

		return $allprefixarray;
		
	}

	public static function user_img($value='')
	{
		$user_img = config('constants.user_default_img');
		if($value) {
			$user_img = asset('storage/user-images/'.$value);
		}
		return $user_img;
	}

	public static function get_page_meta($page_id='', $key='')
	{
		$data = PageMeta::where('page_id', '=', $page_id)->where('title', '=', $key)->first();
		return $data;
	}
}