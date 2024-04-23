<?php

namespace App\Http\Traits;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogBlogCategory;
use App\Models\BlogTag;
use App\Models\BlogBlogTag;
use App\Models\BlogMeta;
use App\Models\BlogSeo;
use App\Models\Page;
use App\Models\PageMeta;
use App\Models\PageSeo;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Configuration;
use XMLWriter;

trait DzImportTrait {

    public function importData($xml, $user_id) {

        /*================ Get data from saved xml file and Save to database ================*/

        if (isset($xml->pages->pages)) {

            function checkAndInsertPage(&$pageXml, $parent_id=Null, $user_id, &$xml)  {

                $pageJson = json_decode(json_encode($pageXml), TRUE);
                $pageJson['user_id'] = $user_id;
                $pageJson['parent_id'] = $parent_id;
                $page = Page::create($pageJson);
                $pageNewId = $page->id;



                if ($pageXml->children->children) {
                    checkAndInsertPage($pageXml->children->children, $pageNewId, $user_id, $xml);
                }

                /*========== For replace page item_id in MenuItems ==========*/
                if (isset($xml->menus->menus)) {
                    foreach ($xml->menus->menus as $menuXml) {
                        foreach ($menuXml->menu_items->menu_items as $item) {
                            if ((string)$item->type == 'Page' && (int)$pageXml->id == (int) $item->item_id) {
                                $item->item_id = $page->id;
                            }
                        }
                    }
                }

                /*========== For replace page item_id in MenuItems ==========*/

                if (isset($pageXml->page_metas->page_metas)) {
                    foreach($pageXml->page_metas->page_metas as $page_meta) {

                        $pageMetaJson = json_decode(json_encode($page_meta), TRUE);
                        $pageMetaJson['page_id'] = $page->id;
                        $pageMeta = PageMeta::create($pageMetaJson);
                    }
                }

                if (isset($pageXml->page_seo->id)) {

                    $pageSeoJson = json_decode(json_encode($pageXml->page_seo), TRUE);
                    $pageSeoJson['page_id'] = $page->id;
                    $pageSeo = PageSeo::create($pageSeoJson);
                }
            }

            foreach($xml->pages->pages as $pageXml) {

                checkAndInsertPage($pageXml, (int)$pageXml->parent_id, $user_id, $xml);
            }


        }

        // dd($xml);

        if (isset($xml->blogs->blogs)) {

            foreach($xml->blogs->blogs as $blogXml) {

                /*========== Check Xml Blog by slug in Database ==========*/

                /*========== Save Blog to database ==========*/
                $blogJson = json_decode(json_encode($blogXml), TRUE);
                $blogJson['user_id'] = $user_id;
                $blog = Blog::create($blogJson);
                /*========== Save Blog to database ==========*/

                /*========== For replace blog id to item_id in MenuItems ==========*/
                if (isset($xml->menus->menus)) {
                    foreach ($xml->menus->menus as $menuXml) {
                        foreach ($menuXml->menu_items->menu_items as $item) {
                            if ((string) $item->type == 'Post' && (int)$blogXml->id == (int) $item->item_id) {
                                $item->item_id = $blog->id;
                            }
                        }
                    }
                }
                /*========== For replace blog id to item_id in MenuItems ==========*/

                /*========== For create BlogMeta If exist ==========*/
                if (isset($blogXml->blog_meta->blog_meta)) {
                    foreach($blogXml->blog_meta->blog_meta as $blog_meta) {

                        $blogMetaJson = json_decode(json_encode($blog_meta), TRUE);
                        $blogMetaJson['blog_id'] = $blog->id;
                        $blogMeta = BlogMeta::create($blogMetaJson);
                    }
                }
                /*========== For create BlogMeta If exist ==========*/

                /*========== For create BlogSeo If exist ==========*/
                if (isset($blogXml->blog_seo->id)) {

                    $blogSeoJson = json_decode(json_encode($blogXml->blog_seo), TRUE);
                    $blogSeoJson['blog_id'] = $blog->id;
                    $blogSeo = BlogSeo::create($blogSeoJson);
                }
                /*========== For create BlogSeo If exist ==========*/

                /*========== For create BlogSeo If exist ==========*/
                if (isset($blogXml->blog_categories->blog_categories)) {

                    foreach($blogXml->blog_categories->blog_categories as $blog_category) {

                        if (!BlogCategory::whereSlug($blog_category->slug)->exists()) {

                            $blogCategoryJson = json_decode(json_encode($blog_category), TRUE);
                            $blogCategoryJson['user_id'] = $user_id;
                            $blogCategory = BlogCategory::create($blogCategoryJson);
                            $categoryId = $blogCategory->id;
                            $categoryOldId = $blog_category->id;

                            foreach ($blogXml->blog_categories->blog_categories as $category) {
                                if ((int) $category->parent_id == (int)$categoryOldId) {
                                    $category->parent_id = $categoryId;
                                }
                            }
                        }
                        else {
                            $categoryId = BlogCategory::whereSlug($blog_category->slug)->first()->id;
                        }

                        foreach($blog_category->pivot as $pivot) {
                            $blogBlogCategory = BlogBlogCategory::create([
                                'blog_id'           => $blog->id,
                                'blog_category_id'  => $categoryId,
                            ]);
                        }
                    }
                }

                if (isset($blogXml->blog_tags->blog_tags)) {

                    foreach($blogXml->blog_tags->blog_tags as $blog_tag) {

                        if (!BlogTag::whereSlug($blog_tag->slug)->exists()) {

                            $blogTagJson = json_decode(json_encode($blog_tag), TRUE);
                            $blogTagJson['user_id'] = $user_id;
                            $blogTag = BlogTag::create($blogTagJson);
                            $tagId = $blogTag->id;
                        }
                        else {
                            $tagId = BlogTag::whereSlug($blog_tag->slug)->first()->id;
                        }

                        foreach($blog_tag->pivot as $pivot) {
                            $blogBlogTag = BlogBlogTag::create([
                                'blog_id'       => $blog->id,
                                'blog_tag_id'   => $tagId,
                            ]);
                        }
                    }
                }
            }
        }

        if(!empty($xml->configurations)){
            $config = New Configuration();
            foreach($xml->configurations->configurations as $configurationsXml) {
                //dd($xml->configurations);
                $key = (string)$configurationsXml->name;
                $value = (string)$configurationsXml->value;
                $config->saveConfig($key, $value);
            }

        }



        if (isset($xml->menus->menus)) {
            foreach($xml->menus->menus as $menuXml) {

                $menuJson = json_decode(json_encode($menuXml), TRUE);
                $menuJson['user_id'] = $user_id;
                $menu = Menu::create($menuJson);




                /*========== save menuId in Configuration for menu Locations =======*/
                $menusLocations = unserialize(config('Site.menu_location'));

                foreach($menusLocations as $location => $value)
                {
                    if($menu->slug == 'primary-menu' && $menusLocations[$location]['title'] == 'Desktop Horizontal Menu'){

                        $menusLocations[$location]['menu'] = $menu->id;

                    }else if($menu->slug == 'footer-menu' && $menusLocations[$location]['title'] == 'Footer Menu'){

                        $menusLocations[$location]['menu'] = $menu->id;

                    }else if($menu->slug == 'secodary-menu' && $menusLocations[$location]['title'] == 'Desktop Expanded Menu'){

                        $menusLocations[$location]['menu'] = $menu->id;
                    }
                }

                $menuLocationArr = serialize($menusLocations);
                $config = New Configuration();
                $config->saveConfig('Site.menu_location', $menuLocationArr);

                /* Configuration Export & Import also required.  */

                /*========== save menuId in Configuration for menu Locations =======*/

                if ($menuXml->menu_items->menu_items) {

                    foreach($menuXml->menu_items->menu_items as $menu_item) {

                        $menuItemJson = json_decode(json_encode($menu_item), TRUE);
                        $menuItemJson['menu_id'] = $menu->id;
                        $menuItem = MenuItem::create($menuItemJson);
                        $newId = $menuItem->id;
                        $oldId = (int) $menu_item->id;

                        foreach ($menuXml->menu_items->menu_items as $item) {
                            if ((int) $item->parent_id == $oldId) {
                                $item->parent_id = $newId;
                            }
                        }
                    }
                }
            }
        }
        /*================ Get data from saved xml file and Save to database ================*/

        return __('Data imported successfully.');
    }

    public function exportData($request, $filename)
    {

        $storage_path   = storage_path();

        if ($request->content == 'all_content') {
            $content['w3cms']['blogs'] = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags')->orderBy('created_at', 'asc')->get()->toArray();

            $content['w3cms']['pages'] = Page::with('page_metas', 'page_seo', 'children')->orderBy('created_at', 'asc')->get()->toArray();

            $content['w3cms']['menus'] = Menu::with('menu_items')->orderBy('created_at', 'asc')->get()->toArray();
        }
        elseif ($request->content == 'posts') {
            $resultQuery = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags')->orderBy('created_at', 'asc');

            if($request->filled('start_date') && $request->filled('end_date')) {
                $resultQuery->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
            }
            if($request->category_id != 0) {
                $resultQuery->whereHas('blog_categories',function($query) use($request){
                    $query->where('blog_categories.id', '=', $request->input('category_id'));
                });
            }
            if($request->post_user_id != 0) {
                $resultQuery->where('user_id', '=', $request->input('post_user_id'));
            }
            if($request->post_status != 0) {
                $resultQuery->where('status', '=', $request->input('post_status'));
            }

            $content['w3cms']['blogs'] = $resultQuery->get()->toArray();
        }
        elseif ($request->content == 'pages') {
            $resultQuery = Page::with('page_metas', 'page_seo')->orderBy('created_at', 'asc');

            if($request->filled('page_start_date') && $request->filled('page_end_date')) {
                $resultQuery->whereBetween('created_at', [$request->input('page_start_date'), $request->input('page_end_date')]);
            }
            if($request->page_user_id != 0) {
                $resultQuery->where('user_id', '=', $request->page_user_id);
            }
            if($request->page_status != 0) {
                $resultQuery->where('status', '=', $request->page_status);
            }

            $content['w3cms']['pages'] = $resultQuery->get()->toArray();
        }
        elseif ($request->content == 'menus') {
            $content['w3cms']['menus'] = Menu::with('menu_items')->orderBy('created_at', 'asc')->get()->toArray();
        }

        try {

            $xml = new XMLWriter();
            $xml->openURI($storage_path.'/app/public/system-export-data/'.$filename);
            $xml->startDocument('1.0', 'UTF-8');
            $startText = "<!--  This is a .xss file generated by w3cms as an export of your site.  -->
<!--  It contains information about your site'.htaccess posts, pages, categories, menus and other content.  -->
<!--  You may use this file to transfer that content from one site to another.  -->
<!--  This file is not intended to serve as a complete backup of your site.  -->
<!--  To import this information into a w3cms site follow these steps:  -->
<!--  1. Log in to that site as an administrator.  -->
<!--  2. Go to Tools: Import in the w3cms admin panel.  -->
<!--  3. Upload this file using the form provided on that page.  -->
<!--  4. You will first select the author on that page.  -->
<!--  5. w3cms will then import each of the posts, pages, comments, categories, etc.  -->
<!--     contained in this file into your site.  -->
<!--  File imported Date : ".date('F j, Y, g:i a').".  -->
";
            $xml->text($startText);
            $xml->setIndent(true);
            $xml->setIndentString("\t");

            /*======= recursive function for array to xml convert with child =======*/
            function array_to_xml($content, &$xml, $table=Null) {
                foreach($content as $key => $value) {

                    if(is_array($value)) {
                        if (!is_string($key)) {
                            $xml->startElement($table);
                            array_to_xml($value, $xml);
                            $xml->endElement();
                        }
                        else {
                            $xml->startElement($key);
                            $table = $key;
                            array_to_xml($value, $xml, $table);
                            $xml->endElement();
                        }
                    }
                    else {
                        if (!empty($value)) {
                            $xml->startElement($key);
                            $xml->text($value);
                            $xml->endElement();
                        }
                    }
                }
            }

            array_to_xml($content, $xml);

            $xml->endElement();
            $xml->endDocument();
            $xml->flush();

            /*==== XML file is stored under /storage/app/public/system-export-data/content.xml =======*/
            $file = $storage_path.'/app/public/system-export-data/'.$filename;
            $headers = array('Content-Type: text/xml');

            return \Response::download($file, $filename, $headers);
        }
        catch(Exception $e)
        {
            echo $e;
        }
    }

}
