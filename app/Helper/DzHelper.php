<?php
namespace App\Helper;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Configuration;

class DzHelper
{
	
	public static function action() {
		$chunks = explode("@",Route::currentRouteAction());
		return end($chunks);
	}
	
	public static function controller() {
		$chunks = explode("\\",Route::currentRouteAction());
		$controller = explode("@",end($chunks));
		return $controller[0]; 
	}
	
	/********************************
	* get base url using this function
	* $key is @params 
	* $key = 'AppUrl' || 'AssetUrl';
	*********************************/
	public static function GetBaseUrl($key = 'AppUrl') {

		if (isset($_SERVER['HTTPS']) && 
			($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || 
			isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && 
			$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') 
		{
			$protocol = 'https://';
		}
		else 
		{
			$protocol = 'http://';
		}

		if (!empty($_SERVER['SUBDOMAIN_DOCUMENT_ROOT'])) {
			$_SERVER['DOCUMENT_ROOT'] = $_SERVER['SUBDOMAIN_DOCUMENT_ROOT'];
		}
		/* For All Oher Server */ 
		$DOCUMENT_PATH = str_replace( $_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', base_path()));
		$url['AppUrl'] = $protocol.request()->getHost().$DOCUMENT_PATH.'/';
		$url['AssetUrl'] = $protocol.request()->getHost().$DOCUMENT_PATH.'/public';

		return $url[$key];
	}

	/*
    * nav_menu function use for return menu on menuLocations with view nav_menu.blade.php,
    * this function get menu name by menu locations array,
    * this function get menu items by menu name from menu model by get_nav_menu() function,
    * if menu items has child menu items then this function calls ChildMenuLink() function.
    */
	public static function nav_menu($args = array())
	{

		$theme_location 	= !empty($args['theme_location']) ? $args['theme_location'] : '';
		$menu_class 		= !empty($args['menu_class']) ? $args['menu_class'] : '';
		$menusLocations 	= unserialize(config('Site.menu_location'));
		$menuName = '';

		if ($menusLocations) {
			foreach($menusLocations as $location => $value)
			{
				if (!empty($value['menu'] && $theme_location == $location)) {
					$menuName = self::getMenuTitle($value['menu']);
				}
			}
		}

		if(\Schema::hasTable('menus') && !empty($menuName))
		{
			$menu = New Menu();
			$menuItems = $menu->get_nav_menu($menuName);
			
			if($menuItems)
			{
				foreach($menuItems as &$menuitem )
				{
					if ($menuitem->type == 'Page'){
						$menuitem->link = self::laraPageLink($menuitem->item_id);
					}
					else if ($menuitem->type == 'Post'){
						$menuitem->link = self::laraBlogLink($menuitem->item_id);
					}
					else if ($menuitem->type == 'Category'){
						$menuitem->link = self::laraBlogCategoryLink($menuitem->item_id);
					}
					else if ($menuitem->type == 'Tag'){
						$menuitem->link = self::laraBlogTagLink($menuitem->item_id);
					}

					if (!empty($menuitem->child_menu_items) && $theme_location == 'primary'){
						$menuitem->child_menu_items = self::ChildMenuLink($menuitem->child_menu_items);
					}
				}
			}
			
			$menus = $menuItems;
			return view('elements.nav_menu',compact('menus','menu_class'));
		}
		return null;
	}

	/*
    * ChildMenuLink function used by nav_menu() function for fill link column of child menu items,
    * this function put current link in menu items link column,
    * if child menu items has child then this function calls self recursively.
    */
	public static function ChildMenuLink($menuItems){
		if($menuItems)
		{
			foreach($menuItems as &$menuitem ){
				if ($menuitem->type == 'Page'){
					$menuitem->link = self::laraPageLink($menuitem->item_id);
				}
				else if ($menuitem->type == 'Post'){
					$menuitem->link = self::laraBlogLink($menuitem->item_id);
				}
				else if ($menuitem->type == 'Category'){
					$menuitem->link = self::laraBlogCategoryLink($menuitem->item_id);
				}
				else if ($menuitem->type == 'Tag'){
					$menuitem->link = self::laraBlogTagLink($menuitem->item_id);
				}

				if (!empty($menuitem->child_menu_items)){
					$menuitem->child_menu_items = self::ChildMenuLink($menuitem->child_menu_items);
				}
			}
		}
		return $menuItems;
	}

	/*
    * the_content function use for get data of content column of page by page id,
    * this function get page content in $pageContent from page model by $page->get_the_content($pageId) function,
    */
	public static function the_content($pageId='')
	{
		if(!empty($pageId))
		{
			$page = New Page();
			$pageContent = $page->get_the_content($pageId);
			return $pageContent;
		}
		return false;
	}

	public function laraLink($id)
	{
		$permalink = config('Permalink.settings');
	}

	/*
    * laraPageLink function use for get link of single page by page id,
    * this function get page slug in $link from page model by $page->laraPageLink($id) function,
    * if $link has no slug than $link = page id,
    * this function return page slug or id on route ('permalink.page_action').
    */
	public static function laraPageLink($id)
	{
		if (Page::whereId($id)->count() > 0) {
			
			$permalink = config('Permalink.settings');

			$link = ['page_id' => $id];
			if($permalink)
			{
				$page = New Page();
				$slug = $page->laraPageLink($id);
				$link = ['slug' => $slug];
			}
		
			return route('permalink.page_action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogLink function use for get link of  single blog by blog id,
    * this function get blog slug in $link from blog model by $blog->laraBlogLink($id) function,
    * if $link has no slug than $link = blog id,
    * this function return blog slug or id on route ('permalink.action').
    */
	public static function laraBlogLink($id)
	{
		if (Blog::whereId($id)->count() > 0) {
			$blog = New Blog();
			$link = $blog->laraBlogLink($id);
			if(empty($link))
			{
				$link = ['p' => $id];
			}
			return route('permalink.action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogCategoryLink function use for get link of blog category by category id,
    * this function get category slug in $link from blog model by $blog->laraBlogCategoryLink($id) function,
    * this function return category slug on route ('permalink.category_action').
    */
	public static function laraBlogCategoryLink($id)
	{
		if (BlogCategory::whereId($id)->count() > 0) {
			
			$blog = New Blog();
			$link = $blog->laraBlogCategoryLink($id);
			return route('permalink.category_action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogTagLink function use for get link of blog tag by tag id,
    * this function get tag title in $link from blog model by $blog->laraBlogTagLink($id) function, 
    * this function return tag name on route ('permalink.blogtag_action').
    */	
	public static function laraBlogTagLink($id)
	{
		if (BlogTag::whereId($id)->count() > 0) {
			
			$blog = New Blog();
			$link = $blog->laraBlogTagLink($id);
			return route('permalink.blogtag_action', $link);
		}
		return 'javascript:void(0);';
	}

	/*
    * laraBlogArchiveLink function use for get link of blog archive by year and month,
    * this function return array of month and year on route ('permalink.archive_action').
    */
	public static function laraBlogArchiveLink($yy,$mm)
	{
		$link = [
			'year' 	=> $yy,
			'month' => $mm
		];
		return route('permalink.archive_action', $link);
	}

	/*
    * author function use for get link of blog or page author by author id,
    * this function get author name in $name from blog model by $blog->author($id) function, 
    * this function return author name on route ('permalink.author_action').
    */
	public static function author($id)
	{
		$blog = New Blog();
		$name = $blog->author($id);
		return route('permalink.author_action', $name);
	}

	/*
    * recentBlogs function use for get Widget of recent Blogs( used in side bar),
    * this function get record in $blogs from blog model by $blog->recentBlogs() function,
    * this function returns view(html) of recent blogs widget from resorces/views/front/widgets/recent_blogs.blade.php.
    */
	public static function recentBlogs($atts = array())
    {
    	$configs = array(
            'limit'		=> isset($atts['limit']) ? $atts['limit'] : config('Reading.nodes_per_page') , 
            'order' 	=> isset($atts['order']) ? $atts['order'] : 'desc',
            'orderby' 	=> isset($atts['orderby']) ? $atts['orderby'] : 'created_at'
        );

		$blog = New Blog();
		$blogs = $blog->recentBlogs($configs);

		if (!empty(config('Widget.show_recent_post_widget'))) {
	        return view('widgets.recent_blogs', compact('blogs'));
		}
    }

    /*
    * categoryBlogs function use for get Widget of Blogs category( used in side bar),
    * this function get record in $blogcategories from blog model by $blog->categoryBlogs() function,
    * this function returns view(html) of category widget from resorces/views/front/widgets/blog_category.blade.php.
    */
	public static function categoryBlogs($atts = array())
    {
    	$configs = array(
            'limit'		=> isset($atts['limit']) ? $atts['limit'] : config('Reading.nodes_per_page') , 
            'order' 	=> isset($atts['order']) ? $atts['order'] : 'desc',
            'orderby' 	=> isset($atts['orderby']) ? $atts['orderby'] : 'id'
        );
		$blog = New Blog();
		$blogcategories = $blog->categoryBlogs($configs);

		if (!empty(config('Widget.show_category_widget'))) {
	        return view('widgets.blog_category', compact('blogcategories'));
		}
    }

    /*
    * archiveBlogs function use for get Widget of Blogs archive( used in side bar),
    * this function get record in $archives from blog model by archiveBlogs() function,
    * this function returns view(html) of blog archives widget from resorces/views/front/widgets/blog_archive.blade.php.
    */
	public static function archiveBlogs()
    {
		$blog = New Blog();
		$archives = $blog->archiveBlogs();
		if (!empty(config('Widget.show_archives_widget'))) {
	        return view('widgets.blog_archive', compact('archives'));
		}
    }

    /*
    * BlogTags function use for get Widget of tags( used in side bar),
    * all blog tags record stored in $tags,
    * this function returns view(html) of blog tags widget from resorces/views/front/widgets/tags.blade.php.
    */
	public static function BlogTags()
    {
		$tags = BlogTag::whereHas('blog',function($query){
			$query->where('visibility', '!=', 'Pr');
		})->get();

        if (!empty(config('Widget.show_tags_widget'))) {
        	return view('widgets.tags', compact('tags'));
        }
    }

	/*
    * SearchWidget function use for get Widget of search( used in side bar),
    * this function returns view(html) of search widget from resorces/views/front/widgets/search.blade.php.
    */
	public static function SearchWidget()
    {
    	if (!empty(config('Widget.show_search_widget'))) {	
        	return view('widgets.search');
        }
    }

    /*
    * siteLogo function use for get site Logo from configurations,
    */
	public static function siteLogo()
	{
		$logo = config('Site.logo');
		if(empty($logo))
		{
			return asset('images/'.config('menu.Site.logo-dark'));
		}
		return asset('storage/configuration-images/'.$logo);
	}

	/*
    * siteFooterText function use for get site footer text from configurations,
    */
	public static function siteFooterText()
	{
		$text = config('Site.footer_text');
		if(empty($text))
		{
			return __('© 2022. All Rights Reserved.');
		}
		return $text;
	}
	/*
    * siteCopyrightText function use for get site copyright text from configurations,
    */
	public static function siteCopyrightText()
	{
		$text = config('Site.copyright');
		if(empty($text))
		{
			return __('© 2022. All Rights Reserved.');
		}
		return $text;
	}

	/*
    * getMenuTitle function use for get menu title by id,
    */
	public static function getMenuTitle($id=null)
	{
        $menu_name = Menu::select('title')->where('id', '=', $id)->first();
        return isset($menu_name->title) ? $menu_name->title : '';
    }

    /*
    * getChildPage function use for get child pages of parent page,
    * this function used in page.blade.php(single page detail),
    * if child page has child page then this function calls recursively(self::getChildPage()).
    */
	public static function getChildPage($child_pages)
	{
        if(!empty($child_pages))
		{
        	$res[] = '<ul class="sub-child-page ps-4">';
			foreach ($child_pages as $child_page) {
				$res[] = '<li> <a href="'.self::laraPageLink($child_page->id).'" class="pl-2 ">'.$child_page->title.'</a>';
				if ($child_page->child_pages->isNotEmpty()) {
					$res[] = self::getChildPage($child_page->child_pages);
				}
				$res[] = '</li>';
			}
			$res[] = '</ul>';
		}
        
		return $res ? implode(' ', $res) : '';
    }

    /*
    * dzSortable function use for sorting record
    * $column has column name if have relation in column than explode with '.',
    * $title has column display title.
    */
	public static function dzSortable($column, $title)
    {
		$columns = explode('.', $column);
		$column = $columns[0];
		$params = request()->except('sort', 'direction', 'with');
		$direction = 'asc';
		if(request()->get('direction') == 'asc'){
			$direction = 'desc';
		}
		$sortUri = ['sort' => $column, 'direction' => $direction];
		if(isset($columns[1]) && !empty($columns[1]))
		{
			$sortUri['with'] = $columns[1];
		}
		$uriString = array_merge($params, $sortUri);
		$url = url()->current().'?'.http_build_query($uriString);
		return '<a href="'.$url.'">'.$title.'<i class="fa fa-sort '.$direction.'"></i></a>';
    }

    /*
    * dzHasSidebar function use for checking site has sidebar or not. 
    * this function returns boolean value true or false.
    * this function used for column class "col-8" or "col-12". 
    */
    public static function dzHasSidebar()
    {
		$col_class = false; 
        $allconfigs = Configuration::pluck('name', 'value');
	    foreach($allconfigs as $value => $full_name){
	         $name = explode('.', $full_name);
	         if ($name['0'] == 'Widget' && $value == 1 && !empty(config('Widget.show_sidebar'))){
	            $col_class = true;
	            break;
	         }
	    }
	    return $col_class; 
    }
}