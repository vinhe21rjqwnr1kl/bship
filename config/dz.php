<?php

return [

    /*
        |--------------------------------------------------------------------------
        | Application Name
        |--------------------------------------------------------------------------
        |
        | This value is the name of your application. This value is used when the
        | framework needs to place the application'.htaccess name in a notification or
        | any other location as required by the application or its packages.
        |
    */

    'name' => env('APP_NAME', 'W3CMS Laravel'),


    'public' => [
	    'favicon' => 'media/img/logo/favicon.ico',
	    'fonts' => [
			'google' => [
				'families' => [
					'Poppins:300,400,500,600,700'
				]
			]
		],
	    'global' => [
	    	'css' => [
		    	'vendor/bootstrap-select/dist/css/bootstrap-select.min.css',
		    	'css/custom.css',
		    	'css/style.css',
		    	'css/tags-input.css',
		    ],
		    'js' => [
		    	'top'=>[
					'vendor/global/global.min.js',
					'vendor/bootstrap-select/dist/js/bootstrap-select.min.js',
				],
				'bottom'=>[
					'js/deznav-init-min.js',
					'js/custom-min.js',
					'js/rdxjs-min.js',
					'js/tags-input.js',
                    'installer/js/sweet-alert2.min.js',
                ],
		    ],
	    ],
	    'pagelevel' => [
			'css' => [
				'PermissionsController_index' => [
					'css/acl-custom.css',
				],
				'PermissionsController_role_permissions' => [
					'css/acl-custom.css',
				],
				'PermissionsController_roles_permissions' => [
					'css/acl-custom.css',
				],
				'PermissionsController_user_permissions' => [
					'css/acl-custom.css',
				],
				'PermissionsController_manage_user_permissions' => [
					'css/acl-custom.css',
				],
				'PermissionsController_temp_permissions' => [
					'vendor/jstree/dist/themes/default/style.min.css',
				],

				'DashboardController_dashboard' => [
					'vendor/jqvmap/css/jqvmap.min.css',
		    		'vendor/owl-carousel/owl.carousel.css',
					'vendor/chartist/css/chartist.min.css',
				],
				'UsersController_index' => [
				],
				'UsersController_create' => [
				],
				'UsersController_edit' => [
				],

				'RolesController_index' => [
				],
				'RolesController_create' => [
				],
				'RolesController_edit' => [
				],

				'PagesController_admin_index' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'PagesController_admin_create' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'PagesController_admin_edit' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],

				'BlogsController_index' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'BlogsController_admin_index' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],
				'BlogsController_admin_create' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'css/bootstrap-tagsinput.css'
				],
				'BlogsController_admin_edit' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
					'css/bootstrap-tagsinput.css'
				],

				'BlogCategoriesController_admin_index' => [
				],
				'BlogCategoriesController_admin_create' => [
				],
				'BlogCategoriesController_admin_edit' => [
				],

				'MenusController_admin_index' => [
					'vendor/nestable2/css/jquery.nestable.min.css'
				],
				'MenusController_admin_create' => [
				],
				'MenusController_admin_edit' => [
				],

				'MenuItemsController_admin_index' => [
				],
				'MenuItemsController_admin_create' => [
				],
				'MenuItemsController_admin_edit' => [
				],

				'ConfigurationsController_admin_prefix' => [
					'vendor/pickadate/themes/default.css',
					'vendor/pickadate/themes/default.date.css',
				],

			],
		    'js' => [
				'PermissionsController_index' => [
				],
				'PermissionsController_role_permissions' => [
				],
				'PermissionsController_roles_permissions' => [
				],
				'PermissionsController_user_permissions' => [
				],
				'PermissionsController_manage_user_permissions' => [
				],
				'PermissionsController_temp_permissions' => [
					'vendor/jstree/dist/jstree.min.js',
				    'js/custom-min.js',
				],

				'DashboardController_dashboard' => [
				    'vendor/chart.js/Chart.bundle.min.js',
				    'vendor/peity/jquery.peity.min.js',
				    'vendor/apexchart/apexchart.js',
				    'js/dashboard/dashboard-min.js',
				    '/vendor/owl-carousel/owl.carousel.js',
				],
				'UsersController_index' => [
				],
				'UsersController_create' => [
				],
				'UsersController_edit' => [
				],
				'RolesController_index' => [
				],
				'RolesController_create' => [
				],
				'RolesController_edit' => [
				],

				'PagesController_admin_index' => [
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],
				'PagesController_admin_create' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'js/pages-min.js',
				],
				'PagesController_admin_edit' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'js/pages-min.js',
				],

				'BlogsController_admin_index' => [
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],
				'BlogsController_admin_create' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
					'js/bootstrap-tagsinput.min.js',
				],
				'BlogsController_admin_edit' => [
					'vendor/ckeditor/ckeditor.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
					'js/bootstrap-tagsinput.min.js',
				],

				'BlogCategoriesController_admin_index' => [
				],
				'BlogCategoriesController_admin_create' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],
				'BlogCategoriesController_admin_edit' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'BlogTagsController_admin_create' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'BlogCategoriesController_list' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'BlogTagsController_list' => [
					'js/jquery-slug-min.js',
					'js/blogs-min.js',
				],

				'MenusController_admin_index' => [
					'vendor/nestable2/js/jquery.nestable.min.js',
					'js/menu-min.js',
				],
				'MenusController_admin_create' => [
				],
				'MenusController_admin_edit' => [
				],

				'MenuItemsController_admin_index' => [
				],
				'MenuItemsController_admin_create' => [
				],
				'MenuItemsController_admin_edit' => [
				],

				'ConfigurationsController_admin_prefix' => [
					'vendor/moment/moment.min.js',
					'vendor/pickadate/picker.js',
					'vendor/pickadate/picker.date.js',
				],

		    ]
   		],
	]
];
