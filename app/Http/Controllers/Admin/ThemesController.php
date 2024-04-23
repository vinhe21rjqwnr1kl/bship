<?php

namespace App\Http\Controllers\Admin;

use Hexadog\ThemesManager\Facades\ThemesManager;
use Hexadog\ThemesManager\Facades\Theme;
use App\Http\Traits\DzImportTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Models\Page;
use App\Models\Blog;
use App\Models\Menu;

class ThemesController extends Controller
{
    use DzImportTrait;
    /**
     * Get all themes.
     * Important for get composer
     * use this to get description -> $themes['hexadog/bodyshape']->get('description');
     *
     * @return mixed
     */
    public function index(Request $request)
    {

        $page_title     = __('Themes');
        $themes         = ThemesManager::all()->toArray();
        $currentTheme   = ThemesManager::current() ? ThemesManager::current()->getName() : '' ;

        if($request->isMethod('get'))
        {
            if ($request->get('activate')) {

                $themeName = $request->get('activate');
                $config = New Configuration();
                $config->saveConfig('Theme.select_theme', $themeName);

                return redirect()->back()->with('success', __('Theme Activate Successfully'));
            }

            if($request->filled('title')) {

                foreach ($themes as $fullName => $theme) {

                    $themeName = $theme->getName();
                    if (\Str::contains($themeName, $request->input('title'))) {
                        $findedThemes[$fullName] = $theme;
                    }
                }
                $themes = $findedThemes;
            }
        }

        return view('admin.themes.index', compact('themes', 'currentTheme', 'page_title'));
    }

    public function import_theme(Request $request)
    {
        if($request->isMethod('post'))
        {

            $xml = simpleXML_load_file($request->db_file);
            $user_id = \Auth::user()->id;

            if($request->input('import_type') == 'draft')
            {
                Blog::query()->update(['status' => 2]);
                Page::query()->update(['status' => 2]);
                Menu::with('menu_items')->delete(); 
            }
            else if($request->input('import_type') == 'delete')
            {
                Blog::with('blog_categories', 'blog_tags', 'blog_seos', 'blog_metas')->delete();
                Page::with('page_metas', 'page_seos')->delete();
                Menu::with('menu_items')->delete();
            }

            $message = $this->importData($xml, $user_id);
            return redirect()->back()->with('success', $message); 
        }
    }
}
