<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\User;
use App\Models\BlogTag;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Cookie;
use DB;
use Mail;

class HomeController extends Controller
{
    public function all(Request $request)
    {
        return redirect()->route('admin.dashboard');

        if(config('Reading.show_on_front') == 'Page')
        {
            $homepage = Page::where('slug', 'like', config('Reading.home_page'))->first();

            if (!empty($homepage)) {
                $request->slug = config('Reading.home_page');
                return $this->detail($request);
            }
        }


        if(optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $blogs   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->where(['status' => 1])->latest()->paginate(config('Reading.nodes_per_page'));
        }else {
            $blogs   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->where(['status' => 1])->where('visibility', '!=', 'Pr')->latest()->paginate(config('Reading.nodes_per_page'));
        }

        return view('blog', compact('blogs'));
    }

    public function detail(Request $request)
    {

        $single = false;
        $blog   = Blog::select('id', 'title', 'content', 'user_id', 'excerpt', 'comment', 'password','visibility', 'publish_on');
        if($request->route('year'))
        {
            $blog->whereYear('publish_on', '=', $request->year);
            $single = true;
        }
        if($request->route('month'))
        {
            $blog->whereMonth('publish_on', '=', $request->month);
            $single = true;
        }
        if($request->route('day'))
        {
            $blog->whereDay('publish_on', '=', $request->day);
            $single = true;
        }
        if($request->slug)
        {
            $blog->where('slug', '=', $request->slug);
            $single = true;
        }
        if($request->p)
        {
            $blog->where('id', '=', $request->p);
            $single = true;
        }
        if($request->post_id)
        {
            $blog->where('id', '=', $request->post_id);
            $single = true;
        }

        $blog = $blog->where('status', '=', '1')->with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->first();
        $blog_categories = !empty($blog->blog_categories) ? $blog->blog_categories : array();

        /* For Private Blogs - if the current user does not have admin role then show 404 for private blog */
        if(!optional(Auth::user())->hasRole(config('constants.roles.admin')) && optional($blog)->visibility == 'Pr'){
            abort(404);
        }
        /* For Private Blogs end */

        /* For Password Protected Blogs */
        $status = 'unlock_'.optional($blog)->id;
        $StatusCookie = Cookie::get('StatusCookie');

        if (optional($blog)->visibility == 'PP' && $StatusCookie != $status) {
            $status = 'locked';

            if (isset($request->password) && !empty($request->password)) {
                if ($request->password == $blog->password) {
                    $status = 'unlock_'.$blog->id;
                    Cookie::queue('StatusCookie', $status, 60);
                }else {
                    return redirect()->back()->withErrors(['password' => 'The Password is Incorrect.']);;

                }
            }
        }
        /* For Password Protected Blogs */


        if(!empty($blog) && empty($request->page_id))
        {
            /* For Single Blog Detail Start*/
            if(optional(Auth::user())->hasRole(config('constants.roles.admin'))){
                $blogs   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->where('status', '=', 1)->latest();
            }else {
                $blogs   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->where('status', '=', 1)->where('visibility', '!=', 'Pr')->latest();
            }

            if($single)
            {
                $blogs = $blogs->where('id', '!=', $blog->id)->limit(2)->get();
                return view('single', compact('blog', 'blogs','blog_categories','status'));
            }

            $blogs = $blogs->paginate(config('Reading.nodes_per_page'));
            return view('blog', compact('blogs'));
            /* For Single Blog Detail End*/
        }
        else
        {
            /* For Single Page Detail Start*/

            $where = array();
            $type = 'page';
            if($request->page_id)
            {
                $where[] = array('id', '=', $request->page_id);
            }
            if($request->slug)
            {
                $where[] = array('slug', '=', $request->slug);
            }
            if (empty($where)) {
                abort(404);
            }
            $page = Page::with('page_metas', 'page_seo', 'user')->with(['child_pages' => function($query) {
                $query->where('visibility', '!=', 'Pr');
            }])->where($where)->firstOrFail();

            /* For Private Page - if current user not has admin role then show 404 for private page */
            if(!optional(Auth::user())->hasRole(config('constants.roles.admin')) && optional($page)->visibility == 'Pr'){
                abort(404);
            }
            /* For Private Page */

            /* For Password Protected Page */
            $status = 'unlock_'.optional($page)->id;
            $StatusCookie = Cookie::get('StatusCookie');

            if (optional($page)->visibility == 'PP' && $StatusCookie != $status) {
                $status = 'locked';

                if (isset($request->password) && !empty($request->password)) {
                    if ($request->password == $page->password) {
                        $status = 'unlock_'.$page->id;
                        Cookie::queue('StatusCookie', $status, 60);
                    }else {
                        return redirect()->back()->withErrors(['password' => 'The Password is Incorrect.']);;

                    }
                }
            }
            /* For Password Protected Page */

            $blog = null;
            return view('page', compact('page','blog','status'));
        }
        /* For Single Page Detail End*/
    }

    /*
    * Created By : Chandan Singh.
    * Created On : 29 / 10 / 2022.
    * blogcategory() function use for return view of category.blade.php based on slug,
    * this function return single category view with blogs of the category.
    */
    public function blogcategory(Request $request)
    {

        if(!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $blog_category = BlogCategory::with(['blog' => function($query) {
                $query->where('visibility', '!=', 'Pr');
            }])
            ->where('slug', '=', $request->slug)
            ->firstOrFail();
        }else {
            $blog_category = BlogCategory::with('blog')->where('slug', '=', $request->slug)->firstOrFail();
        }
        $title = $blog_category->title;
        $blogs = !empty($blog_category->blog) ? $blog_category->blog()->paginate(config('Reading.nodes_per_page')) : array();

        return view('category',compact('blogs','title'));
    }

    /*
	* Created By : Chandan Singh.
	* Created On : 29 / 10 / 2022.
	* blogtag() function use for return view of Blog tags based on title,
    * this function return single tag view with blogs of the tag.
	*/
    public function blogtag(Request $request)
    {
        if(!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $blog_tag = BlogTag::with(['blog' => function($query) {
                $query->where('visibility', '!=', 'Pr');
            }])
            ->where('slug', '=', $request->slug)
            ->firstOrFail();
        }else {
            $blog_tag = BlogTag::with('blog')->where('title', '=', $request->slug)->firstOrFail();
        }
        $blogs = !empty($blog_tag->blog) ? $blog_tag->blog()->paginate(config('Reading.nodes_per_page')) : array();
        return view('tag',compact('blog_tag','blogs'));
    }


	/*
	* Created By : Chandan Singh.
	* Created On : 30 / 10 / 2022.
    * author() function use for return view of archive.blade.php,
    * this function return single author page with blogs of the user.
	*/
    public function author(Request $request)
    {

        if(!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {

            $user = User::with(['blog' => function($query) {
                $query->where('visibility', '!=', 'Pr');
            }])
            ->where('name', '=', $request->name)
            ->firstOrFail();

        }else {
            $user = User::with('blog')->where('name', '=', $request->name)->firstOrFail();
        }

        $blogs = !empty($user->blog) ? $user->blog()->paginate(config('Reading.nodes_per_page')) : array();
        return view('archive',compact('user','blogs'));
    }


	/*
	* Created By : Chandan Singh.
	* Created On : 29 / 10 / 2022
    * blogarchive() function use for return view of archive.blade.php,
    * this function return single archive page with blogs by month and year,
    * $month is the name of month that return in the view.
	*/
    public function blogarchive(Request $request)
    {
        $year = $request->year;
        $month = $request->month ? date("F", mktime(0, 0, 0, $request->month, 10)) : '';

        $blogs = Blog::with('blog_meta');
        $blogs->where('status', '1');
        if(!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $blogs->where('visibility', '!=', 'Pr');
        }
        $blogs->whereYear('publish_on', '=', $request->year);
        if($request->month){
            $blogs->whereMonth('publish_on', '=', $request->month);
        }
        $blogs = $blogs->paginate(config('Reading.nodes_per_page'));

        if($blogs->isEmpty()){
            abort(404);
        }

        return view('archive',compact('blogs','year','month'));
    }


	/*
	* Created By : Chandan Singh.
	* Created On : 29 / 10 / 2022.
	* search() function use for return view of search,
    * this function return single search page with blogs and pages that match by search data,
	*/
    public function search(Request $request)
    {
        $title = $request->s;

        $blogs = Blog::with('blog_meta');
        if(!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $blogs->where('visibility', '!=', 'Pr');
        }
        $blogs->where('status', '=', '1');
        $blogs->where(function($query) use($title) {
            $query->orwhere('title', 'Like', '%'.$title.'%')
                ->orWhere('content', 'Like', '%'.$title.'%')
                ->orWhere('excerpt', 'Like', '%'.$title.'%')
                ->orWhere('slug', 'Like', '%'.$title.'%')
                ->orWhere('comment', 'Like', '%'.$title.'%')
                ->orWhere('publish_on', 'Like', '%'.$title.'%');
        });
        $blogs = $blogs->get();

        $pages = Page::with('page_metas');
        if(!optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $pages->where('visibility', '!=', 'Pr');
        }
        $pages->where('status', '=', '1');
        $pages->where(function($query) use($title) {
            $query->orwhere('title', 'Like', '%'.$title.'%')
                ->orWhere('content', 'Like', '%'.$title.'%')
                ->orWhere('excerpt', 'Like', '%'.$title.'%')
                ->orWhere('slug', 'Like', '%'.$title.'%')
                ->orWhere('comment', 'Like', '%'.$title.'%')
                ->orWhere('publish_on', 'Like', '%'.$title.'%');
        });
        $pages = $pages->get();

        $blogs = $blogs->concat($pages);

        return view('search',compact('blogs','title'));
    }

    /*
    * Created By : Chandan Singh.
    * Created On : 29 / 10 / 2022.
    * blogslist() function use for return view of blog list,
    * this function return list of blogs when route get 'blog' in url ,
    */
    public function blogslist()
    {
        if(optional(Auth::user())->hasRole(config('constants.roles.admin'))) {
            $blogs   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->where(['status' => 1])->latest()->paginate(config('Reading.nodes_per_page'));
        }else {
            $blogs   = Blog::with('blog_meta', 'blog_seo', 'blog_categories', 'blog_tags', 'user')->where(['status' => 1])->where('visibility', '!=', 'Pr')->latest()->paginate(config('Reading.nodes_per_page'));
        }

        return view('blog', compact('blogs'));
    }

    /*
    * Created By : Chandan Singh.
    * Created On : 17 / 12 / 2022.
    * contact() function use for return view of contact us page and save contact details in database,
    * this function return Contact Page when route get 'Page' in url ,
    */
    public function contact(Request $request)
    {
        if (\Request::isMethod('post'))
        {
            $this->validate($request, [
                    'first_name'        => 'required|regex:/^[a-zA-Z]+$/u',
                    'last_name'         => ['regex:/^[a-zA-Z]+$/u', 'nullable'],
                    'email'             => 'required|email',
                    'phone_number'      => 'required|regex:/^[0-9]{10}+$/',
                    'message'           => 'required',
                ],
            );

            $data = [
                'first_name'    => $request->input('first_name'),
                'last_name'     => $request->input('last_name'),
                'email'         => $request->input('email'),
                'phone_number'  => $request->input('phone_number'),
                'message'       => $request->input('message'),
            ];
            $dzEmail = $data['email'];
            $dzEmailFrom = $data['first_name'].' '.$data['last_name'];
            $contact = Contact::create($data);

            if($contact)
            {
                Mail::send('email_templates.contact_us', compact('data'), function ($message) use($dzEmail, $dzEmailFrom) {
                    $message->from($dzEmail, $dzEmailFrom);
                    $message->replyTo($dzEmail, $dzEmailFrom);
                    $message->subject(__('W3CMS|Contact Form: A Person want to contact'));
                    $message->to(config('Site.email'));
                });

                return redirect()->back()->with('success', __('Contact Added successfully'));
            }

            return redirect()->back()->with('error', __('There are some problem in form submition.'));
        }

        return view('contact');
    }
}
