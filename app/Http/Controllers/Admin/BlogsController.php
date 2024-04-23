<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogBlogCategory;
use App\Models\BlogTag;
use App\Models\BlogBlogTag;
use App\Models\BlogMeta;
use App\Models\BlogSeo;
use App\Models\User;
use App\Rules\EditorEmptyCheckRule;
use Storage;

class BlogsController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $page_title = __('All Blogs');
        $resultQuery = Blog::query();
        $users = User::get();
        $blog_categories = BlogCategory::get();
        $blog_tags = BlogTag::get();

        if($request->isMethod('get') && $request->input('todo') == 'Filter')
        {
            if($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('title')}%");
            }
            if($request->filled('status')) {
                $resultQuery->where('status', '=', $request->input('status'));
            }
            if($request->filled('from') && $request->filled('to')) {
                $resultQuery->whereBetween('blogs.created_at', [$request->input('from'), $request->input('to')]);
            }
            if($request->filled('publish_on')) {
                $resultQuery->whereDate('publish_on', '=', $request->input('publish_on'));
            }
            if($request->filled('user')) {
                $resultQuery->where('user_id', '=', $request->input('user'));
            }
            if($request->filled('visibility')) {
                $resultQuery->where('visibility', '=', $request->input('visibility'));
            }
            if($request->filled('category')) {
                $resultQuery->whereHas('blog_categories',function($query) use($request){
                    $query->where('blog_categories.id', '=', $request->input('category'));
                });
            }
            if($request->filled('tag')) {
                $resultQuery->whereHas('blog_tags',function($query) use($request){
                    $query->where('blog_tags.id', '=', $request->input('tag'));
                });
            }
        }
        $resultQuery->join('users', 'blogs.user_id', '=', 'users.id');
        $resultQuery->select('blogs.*','users.name as user_name');
        $resultQuery->where('status', '!=', 3);

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        if($sortWith == 'users')
        {
            $resultQuery->orderBy('users.'.$sortBy, $direction);
        }
        else{
            $resultQuery->orderBy('blogs.'.$sortBy, $direction);
        }

        $blogs = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $status = config('blog.status');

        return view('admin.blogs.index', compact('blogs','blog_categories','blog_tags','users','page_title', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('Add New Blog');
        $blogs = Blog::get();
        $users = User::get();
        $categoryArr = (new BlogCategory())->generateCategoryTreeListCheckbox(Null, ' ');
        $parentCategoryArr = (new BlogCategory())->generateCategoryTreeArray(Null, '&nbsp;&nbsp;&nbsp;');
        $screenOption = config('blog.ScreenOption');
        return view('admin.blogs.create', compact('users', 'blogs', 'categoryArr', 'parentCategoryArr', 'page_title', 'screenOption'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $validation = [
            'data.Blog.title'           => 'required',
            'data.Blog.content'         => ['required', new EditorEmptyCheckRule],
            'data.Blog.slug'            => 'unique:blogs,slug',
            'data.Blog.publish_on'      => 'required',
            'data.BlogMeta.0.value'     => 'mimes:jpg,png,jpeg,gif',
        ];

        $validationMsg = [
            'data.Blog.title.required'      => __('The title field is required.'),
            'data.Blog.content.required'    => __('The blog content field is required.'),
            'data.Blog.publish_on.required' => __('The published on field is required.'),
            'data.Blog.slug.unique'         => __('The slug has already been taken.'),
            'data.BlogMeta.0.value.mimes'   => __('The feature image must be a file of type: jpg, png, jpeg, gif.'),
        ];

        $this->validate($request, $validation, $validationMsg);
        $blogData   = $request->input('data.Blog');
        $blogData['user_id'] = $request->input('data.Blog.user_id') ? $request->input('data.Blog.user_id') : Auth::id();
        $blog       = Blog::create($blogData);
        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();
        $blog_tags  = !empty($request->input('data.BlogTag')) ? explode(',', $request->input('data.BlogTag')) : '';

        if($blog)
        {
            $BlogSeo                    = new BlogSeo();
            $BlogSeo->blog_id           = $blog->id;
            $BlogSeo->page_title        = $request->input('data.BlogSeo.page_title');
            $BlogSeo->meta_keywords     = $request->input('data.BlogSeo.meta_keywords');
            $BlogSeo->meta_descriptions = $request->input('data.BlogSeo.meta_descriptions');
            $BlogSeo->blog_url          = $request->input('data.BlogSeo.blog_url');
            $BlogSeo->save();

            $BlogTagIds = array();

            if(!empty($blog_tags))
            {
                foreach ($blog_tags as $blog_tag)
                {
                    $BlogTag = BlogTag::where('title', '=', $blog_tag)->where('user_id', '=', \Auth::id())->first();

                    if(!empty($BlogTag))
                    {
                        $BlogTagIds[] = $BlogTag->id;
                    }
                    else
                    {
                        $BlogTag = new BlogTag();
                        $BlogTag->title = $blog_tag;
                        $BlogTag->slug = $blog_tag;
                        $BlogTag->user_id = \Auth::id();
                        $BlogTag->save();
                        $BlogTagIds[] = $BlogTag->id;
                    }

                }
            }

            $blog->blog_categories()->sync($request->input('data.BlogCategory'));
            $blog->blog_tags()->sync($BlogTagIds);

            if(!empty($blog_metas))
            {
                foreach ($blog_metas as $blog_meta) {

                    if($blog_meta['title'] != 'ximage')
                    {
                        $blog->blog_meta()->create($blog_meta);
                    }
                    else
                    {
                        if(!empty($blog_meta['value']))
                        {
                            $OriginalName = $blog_meta['value']->getClientOriginalName();
                            $fileName = time().'_'.$OriginalName;
                            $blog_meta['value']->storeAs('public/blog-images/', $fileName);
                            $blog_meta['value'] = $fileName;
                        }

                        $blog->blog_meta()->create($blog_meta);
                    }
                }
            }

            return redirect()->route('blog.admin.index')->with('success', __('Blog added successfully.'));

        }
        return redirect()->back()->with('error', __('Something went wrong. Please try again.'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('admin.blogs.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $page_title = __('Blog Edit');
        $blogs = Blog::where('id', '!=', $id)->get();
        $users = User::get();
        $blog = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user', 'feature_img', 'video')->findorFail($id);
        $blogCatArr = array_column($blog->blog_categories->toArray(), 'id');
        $categoryArr = (new BlogCategory())->generateCategoryTreeListCheckbox(Null, ' ', $blogCatArr);
        $parentCategoryArr = (new BlogCategory())->generateCategoryTreeArray(Null, '&nbsp;&nbsp;&nbsp;');
        $tags = array_column($blog->blog_tags->toArray(), 'title');
        $blog_tags = implode(',', $tags);
        $screenOption = config('blog.ScreenOption');
        return view('admin.blogs.edit', compact('blogs', 'users', 'blog', 'categoryArr', 'parentCategoryArr', 'blog_tags', 'page_title', 'screenOption'));
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
                'data.Blog.title'           => 'required',
                'data.Blog.content'         => ['required', new EditorEmptyCheckRule],
                'data.Blog.publish_on'      => 'required',
                'data.Blog.slug'            => 'unique:blogs,slug,'.$id,
                'data.BlogMeta.0.value'     => 'mimes:jpg,png,jpeg,gif',
            ];

        $validationMsg = [
            'data.Blog.title.required'      => __('The title field is required.'),
            'data.Blog.content.required'    => __('The blog content field is required.'),
            'data.Blog.publish_on.required' => __('The published on field is required.'),
            'data.Blog.slug.unique'         => __('The slug has already been taken.'),
            'data.BlogMeta.0.value.mimes'   => __('The feature image must be a file of type: jpg, png, jpeg, gif.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blog               = Blog::findorFail($id);
        $blogArr            = $request->input('data.Blog');
        $blogArr['slug']    = $request->input('data.Blog.editslug');
        $blog->fill($blogArr)->save();
        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();
        $blog_tags  = !empty($request->input('data.BlogTag')) ? explode(',', $request->input('data.BlogTag')) : '';

        if($blog)
        {
            BlogSeo::updateOrCreate(
                ['blog_id' => $blog->id],
                [
                    'blog_id'           => $blog->id,
                    'page_title'        => $request->input('data.BlogSeo.page_title'),
                    'meta_keywords'     => $request->input('data.BlogSeo.meta_keywords'),
                    'meta_descriptions' => $request->input('data.BlogSeo.meta_descriptions'),
                    'blog_url'          => $request->input('data.BlogSeo.blog_url'),
                ]
            );

            $BlogTagIds = array();

            if(!empty($blog_tags))
            {
                foreach ($blog_tags as $blog_tag)
                {
                    $BlogTag = BlogTag::where('title', '=', $blog_tag)->where('user_id', '=', \Auth::id())->first();

                    if(!empty($BlogTag))
                    {
                        $BlogTagIds[] = $BlogTag->id;
                    }
                    else
                    {
                        $BlogTag = new BlogTag();
                        $BlogTag->title = $blog_tag;
                        $BlogTag->slug = $blog_tag;
                        $BlogTag->user_id = \Auth::id();
                        $BlogTag->save();
                        $BlogTagIds[] = $BlogTag->id;
                    }

                }
            }

            $blog->blog_categories()->sync($request->input('data.BlogCategory'));
            $blog->blog_tags()->sync($BlogTagIds);

            if(!empty($blog_metas))
            {
                $blogMetaIds = array_column($blog_metas, 'meta_id');
                BlogMeta::where('blog_id', '=', $id)->whereNotIn('id', $blogMetaIds)->delete();

                foreach ($blog_metas as $blog_meta) {

                    if($blog_meta['title'] != 'ximage')
                    {
                        $blog->blog_meta()->create($blog_meta);
                    }
                    else
                    {
                        if(!empty($blog_meta['value']))
                        {
                            $OriginalName = $blog_meta['value']->getClientOriginalName();
                            $fileName = time().'_'.$OriginalName;
                            $blog_meta['value']->storeAs('public/blog-images/', $fileName);
                            if($blog_meta['old_value'] && Storage::exists('public/blog-images/'.$blog_meta['old_value']))
                            {
                                Storage::delete('public/blog-images/'.$blog_meta['old_value']);
                            }
                            $blog_meta['value'] = $fileName;
                        }
                        else
                        {
                            if(Storage::exists('public/blog-images/'.$blog_meta['old_value']))
                            {
                                $blog_meta['value'] = $blog_meta['old_value'];
                            }
                        }
                        $blog->blog_meta()->create($blog_meta);
                    }

                }
            }

            return redirect()->route('blog.admin.index')->with('success', __('Blog added successfully.'));

        }
        return redirect()->back()->with('error', __('Something went wrong. Please try again.'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function admin_destroy($id)
    {

        $blog           = Blog::findOrFail($id);
        $res            = $blog->delete();
        if($res)
        {
            return redirect()->back()->with('success', __('Blog Deleted successfully.'));
        }
        return redirect()->back()->with('error', __('Something went wrong. Please try again.'));
    }

    public function admin_trash_status($id)
    {
        $blog           = Blog::findOrFail($id);
        $blog->status   = 3;
        $res            = $blog->save();

        if($res)
        {
            return redirect()->back()->with('success', __('Blog is trashed successfully.'));
        }
        return redirect()->back()->with('error', __('Something went wrong. Please try again.'));
    }

    public function restore_blog($id)
    {
        $blog           = Blog::findOrFail($id);
        $blog->status   = 1;
        $res            = $blog->update();

        if($res)
        {
            return redirect()->back()->with('success', 'Blog is restored successfully.');
        }
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }

    public function trash_list(Request $request)
    {
        $page_title = 'Trashed Blogs';
        $resultQuery = Blog::query();


        $resultQuery->join('users', 'blogs.user_id', '=', 'users.id');
        $resultQuery->select('blogs.*','users.name as user_name');
        $resultQuery->where('status', '=', 3);

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        if($sortWith == 'users')
        {
            $resultQuery->orderBy('users.'.$sortBy, $direction);
        }
        else{
            $resultQuery->orderBy('blogs.'.$sortBy, $direction);
        }

        $blogs = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.blogs.trashed_blogs', compact('blogs'));
    }

    public function blogCategoryTree1($id = Null, $level = 0)
    {
        $parents    = BlogCategory::where('parent_id', '=', $id)->get();
        $res        = isset($res) ? $res : array();
        $blank = "";

        if(!empty($parents))
        {
            $level++;
            $res[] = '<ul type="none">';

            $i = 0;
            for($i=1; $i< $level; $i++) {

                $blank .= " ";

                foreach($parents as $value)
                {
                    $checkbox = '<input type="checkbox" name="data[BlogCategory][BlogCategory]" class="blog_categories" value="'.$value->id.'">';
                    $title = $value->title;
                    $res[] = sprintf('<li>'.$blank.$checkbox.$title.' %.htaccess</li>', $this->blogCategoryTree($value->id, $level));
                }
            }

            $res[] = '</ul>';
        }
        return implode('', $res);
    }

    public function blogCategoryTree($id = Null, $level = 0)
    {
        $parents    = BlogCategory::where('parent_id', '=', $id)->get();
        $res        = !empty($res) ? $res : array();
        $blank = "";
        if(!empty($parents))
        {
            $level++;
            for($i=0; $i< $level; $i++) {
                $blank .= " ";
                foreach($parents as $value)
                {
                    $title = $blank.$value->title;
                    $res[] = $title;
                    array_merge($res, $this->blogCategoryTree($value->id, $level));
                }
            }
        }
        return $res;
    }

    public function remove_feature_image($id)
    {
        $blog_meta  = BlogMeta::where('title', '=', 'ximage')->where('blog_id', '=', $id)->first();
        if(!empty($blog_meta->value) && Storage::exists('public/blog-images/'.$blog_meta->value))
        {
            Storage::delete('public/blog-images/'.$blog_meta->value);
            return $blog_meta->delete();
        }
    }
}
