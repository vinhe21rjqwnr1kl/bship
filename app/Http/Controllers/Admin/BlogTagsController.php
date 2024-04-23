<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogTag;
use Auth;

class BlogTagsController extends Controller
{
    public function list(Request $request, $id='')
    {
        $page_title = __('Blog Tag List');
        $blog_tags    = BlogTag::withCount('blog')->paginate(config('Reading.nodes_per_page'));
        $blogTag       = BlogTag::find($id);
        $msg           = __('Blog tag updated successfully.');
        if(empty($blogTag))
        {
            $blogTag = new BlogTag();
            $msg = __('Blog tag added successfully.');
        }

        if($request->isMethod('post'))
        {

            $validation = [
                'title'             => 'required',
                'slug'             => 'required',
            ];

            $validationMsg = [
                'title.required'    => __('The title field is required.'),
                'title.required'    => __('The slug field is required.'),
            ];

            $this->validate($request, $validation, $validationMsg);

            $blogTag->user_id      = Auth::id();
            $blogTag->title        = $request->title;
            $blogTag->slug         = $request->slug;
            $res                   = $blogTag->save();
            $blogTag->save();

            if($res)
            {
                return redirect()->route('blog_tag.admin.list')->with('success', $msg);
            }
            return redirect()->route('blog_tag.admin.list')->with('error', __('Something went wrong.'));
        }
        return view('admin.blog_tags.list', compact('blog_tags', 'blogTag','page_title'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $page_title = __('All Blog Tags');
        
        $blogs_tag_query = BlogTag::query();
        if($request->isMethod('get'))
        {
            if($request->filled('title')) {
                $blogs_tag_query->where('title', 'like', "%{$request->input('title')}%");
            }
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $blogs_tag_query->orderBy($sortBy, $direction);

        $blog_tags = $blogs_tag_query->withCount('blog')->paginate(config('Reading.nodes_per_page'));
        return view('admin.blog_tags.index', compact('blog_tags','page_title'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('Add New Blog Tag');
        $blog_tags = BlogTag::get();
        return view('admin.blog_tags.create', compact('blog_tags','page_title'));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $validation = [
                'data.BlogTag.title'      => 'required',
                'data.BlogTag.slug'       => 'required',
            ];

        $validationMsg = [
            'data.BlogTag.title.required'     => __('The title field is required.'),
            'data.BlogTag.slug.required'      => __('The slug field is required.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogTagReq                = $request->input('data.BlogTag');
        $blogTagReq['user_id']     = \Auth::id();
        $blogTag                   = BlogTag::create($blogTagReq);
        if($blogTag)
        {
            return redirect()->route('blog_tag.admin.index')->with('success', __('Blog tag added successfully.'));
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
        return view('admin.blog_tags.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function admin_edit($id)
    {
        $page_title = __('Edit Blog Tag');
        $blog_tag = BlogTag::findorFail($id);
        $blog_tags = BlogTag::get();
        return view('admin.blog_tags.edit', compact('blog_tags', 'blog_tag','page_title'));
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
                'data.BlogTag.title'       => 'required',
            ];

        $validationMsg = [
            'data.BlogTag.title.required'      => __('The title field is required.'),
        ];

        $this->validate($request, $validation, $validationMsg);

        $blogTagReq                = $request->input('data.BlogTag');
        $blogTagReq['user_id']     = \Auth::id();
        $blogTag                   = BlogTag::where('id', '=', $id)->update($blogTagReq);
        if($blogTag)
        {
            return redirect()->route('blog_tag.admin.index')->with('success', __('Blog tag updated successfully.'));
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
        $res = BlogTag::destroy($id);
        
        if($res)
        {
            return redirect()->back()->with('success', __('Blog tag deleted successfully.'));
        }
        return redirect()->back()->with('error', __('Sorry, Something went wrong.'));
    }
}
