<?php



return [

	'version' => '1.3',
	'user_default_img' => env('ASSET_URL').'/images/no-user.png',

	'category_default_img' => env('ASSET_URL').'/images/no-category.png',

	'extensions'	=>	array(
							'Excel' => array( '.xls', '.xlt', '.xlm', '.xlsx', '.xlsm', '.xltx', '.xltm', '.xlsb', '.xla', '.xlam', '.xll', '.xlw' ),
							'Docs' => array( '.doc', '.dot', '.wbk', '.docx', '.docm', '.dotx', '.dotm', '.docb' ),
							'Text' => array( '.txt' ),
							'Image' => array( '.jpg', '.jpeg', '.gif', '.png', '.pdf', '.jpe', '.jif', '.jfif', '.jfi', '.webp', '.tiff', '.tif', '.psd', '.svg', '.svgz' ),
							'Video' => array( '.mp4', '.mov', '.wmv', '.flv', '.avi', '.avchd', '.webm', '.mkv', '.f4v', '.swf', '.mpeg-2', '.mpg', '.mp2', '.mpeg', '.mpe', '.mpv', '.ogg', '.m4p', '.m4v'),

						),
	'roles' => array(
		'admin' => 'Super Admin'
	),
	
	'available_langs' => [
	  'en' => 'English',
	  'ru' => 'Russian',
	  'fr' => 'French',
	  'hi' => 'Hindi',
	],

];