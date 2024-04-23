<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\BlogCategory;
use Auth;

class BlogCategoriesController extends Controller
{
    public function list(Request $request, $id='')
    {
        $page_title = __('Blog Category List');
        $blog_categories    = (new BlogCategory)->generateCategoryTreeArray(Null, "_", ['id', 'title', 'created_at', 'order']);
        if($blog_categories)
        {
            $blog_categories    = $this->paginate(collect($blog_categories), config('Reading.nodes_per_page'));
        }
        $blogCategory       = BlogCategory::find($id);
        $msg                = __('Blog category updated successfully.');
        if(empty($blogCategory))
        {
            $blogCategory = new BlogCategory();
            $msg = __('Blog category added successfully.');
        }

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required',
            ];

            $validationMsg = [
                'title.required'    => __('The title field is required.'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $blogCategory->parent_id    = $request->parent_id ? $request->parent_id : Null;
            $blogCategory->user_id      = Auth::id();
            $blogCategory->title        = $request->title;
            $blogCategory->slug         = $request->slug;
            $blogCategory->description  = $request->description;
            $res                        = $blogCategory->save();
            $blogCategory->order        = $blogCategory->id;
            $blogCategory->save();

            if($res)
            {
                return redirect()->route('blog_category.admin.list')->with('success', $msg);
            }
            return redirect()->route('blog_category.admin.list')->with('error', __('Something went wrong.'));
        }
        return view('admin.blog_categories.list', compact('blog_categories', 'blogCategory','page_title'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $page_title = __('All Blog Categories');

        $blogs_category_query = BlogCategory::query();
        if($request->isMethod('get'))
        {
            if($request->filled('title')) {
                $blogs_category_query->where('title', 'like', "%{$request->input('title')}%");
            }
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $blogs_category_query->orderBy($sortBy, $direction);

        $blog_categories = $blogs_category_query->withCount('blog')->paginate(config('Reading.nodes_per_page'));
        return view('admin.blog_categories.index', compact('blog_categories','page_title'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('Add New Blog Category');
        $blog_categories = (new BlogCategory)->generateCategoryTreeArray(Null, "_", ['id', 'title', 'created_at', 'order']);
        return view('admin.blog_categories.create', compact('blog_categories','page_title'));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $validation = [
                'data.BlogCategory.title'       => 'required',
                'data.BlogCategory.slug'        => 'required',
            ];

        $validationMsg = [
            'data.BlogCategory.title.required'      => __('The title field is required.'),
            'data.BlogCategory.slug.required'       => __('The slug field is required.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogCategoryReq                = $request->input('data.BlogCategory');
        $blogCategoryReq['user_id']     = \Auth::id();
        $blogCategory                   = BlogCategory::create($blogCategoryReq);
        if($blogCategory)
        {
            return redirect()->route('blog_category.admin.index')->with('success', __('Blog category added successfully.'));
        }
        return redirect()->back()->with('error', __('Sorry, Something went wrong.'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_show($id)
    {
        return view('admin.blog_categories.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $page_title = __('Edit Blog Category');
        $blog_category = BlogCategory::findorFail($id);
        $blog_categories = BlogCategory::get();
        return view('admin.blog_categories.edit', compact('blog_categories', 'blog_category','page_title'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_update(Request $request, $id)
    {

        $validation = [
                'data.BlogCategory.title'       => 'required',
                'data.BlogCategory.slug'        => 'required',
            ];

        $validationMsg = [
            'data.BlogCategory.title.required'      => __('The title field is required.'),
            'data.BlogCategory.slug.required'       => __('The slug field is required.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogCategoryReq                = $request->input('data.BlogCategory');
        $blogCategoryReq['user_id']     = \Auth::id();
        $blogCategory                   = BlogCategory::where('id', '=', $id)->update($blogCategoryReq);
        if($blogCategory)
        {
            return redirect()->route('blog_category.admin.index')->with('success', __('Blog category updated successfully.'));
        }
        return redirect()->back()->with('error', __('Sorry, Something went wrong.'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function admin_destroy($id)
    {

        $res = BlogCategory::destroy($id);

        if($res)
        {
            return redirect()->back()->with('success', __('Blog category deleted successfully.'));
        }
        return redirect()->back()->with('error', __('Something went wrong.'));
    }

    public function blogCategoryTree($id = Null, $level = 0)
    {
        $parents = BlogCategory::where('parent_id', '=', $id)->get();
        $res = isset($res) ? $res : array();
        $blank = "";
        if(!empty($parents))
        {
            $level++;
            $res[] = '<ul type="none">';

            $i = 0;
            for($i=1; $i< $level; $i++)
                $blank .= " ";

                foreach($parents as $value)
                {
                    $checkbox = '<input type="checkbox" name="data[BlogCategory][BlogCategory]" class="blog_categories" value="'.$value->id.'">';
                    $title = $value->title;
                    $res[] = sprintf('<li>'.$blank.$checkbox.$title.' %.htaccess</li>', $this->blogCategoryTree($value->id, $level));
                }

            $res[] = '</ul>';
        }
        return implode('', $res);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options =  array(
                        'path' => LengthAwarePaginator::resolveCurrentPath(),
                        'pageName' => 'page',
                    );
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function admin_ajax_add_category(Request $request)
    {
        $category = BlogCategory::where('title', '=', $request->title)->where('title', '=', $request->title)->first();
        if($category)
        {
            $category = array();
            return view('admin.blog_categories.ajax.admin_ajax_add_category', compact('category'));

        } else
        {
            $category               = new BlogCategory();
            $category->title        = $request->input('title');
            $category->parent_id    = $request->input('parent_id') ? $request->input('parent_id') : Null;
            $category->slug         = \Str::slug($request->input('title'));;
            $category->user_id      = \Auth::id();
            $category->save();
            $category->order = $category->id;
            $category->save();

            return view('admin.blog_categories.ajax.admin_ajax_add_category', compact('category'));
        }

    }

    /**
     * Admin moveup
     *
     * @param integer $id
     * @param integer $step
     * @return void
     * @access public
     */
    public function admin_moveup($id, $step = 1)
    {
        $blog_categorie = new BlogCategory();
        $res = $blog_categorie->moveUp($id, $step);
        if($res)
        {
            return redirect()->back()->with('success', __('Moved up successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Could not move up.'));
        }
    }

    /**
     * Admin moveup
     *
     * @param integer $id
     * @param integer $step
     * @return void
     * @access public
     */
    public function admin_movedown($id, $step = 1)
    {
        $blog_categorie = new BlogCategory();
        $res = $blog_categorie->moveDown($id, $step);
        if($res)
        {
            return redirect()->back()->with('success', __('Moved down successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Could not move down.'));
        }
    }
}
