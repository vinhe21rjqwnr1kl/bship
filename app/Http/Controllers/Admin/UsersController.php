<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Agency;
use App\Models\UserB;
use Spatie\Permission\Models\Role;
use App\Models\Role as UserRole;
use Auth;
use Jenssegers\Agent\Agent;
use Storage;


class UsersController extends Controller
{

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = __('Danh sách tài khoản');
        $resultQuery = User::query();

        if($request->filled('name')) {
            $resultQuery->where('name', 'like', "%{$request->input('name')}%");
        }

        if($request->filled('email')) {
            $resultQuery->where('email', 'like', "%{$request->input('email')}%");
        }

        if($request->filled('role'))
        {
            $resultQuery->whereHas('roles', function($query) use($request) {
                $query->where('id', '=', $request->input('role'));
            });
        }

        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);

        $users = $resultQuery->with('roles')->paginate(config('Reading.nodes_per_page'));

        $roleArr = UserRole::pluck('name', 'id')->prepend(__('Nhóm'),'');
        return view('admin.users.index', compact('users', 'roleArr','page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = __('Tạo tài khoản');
        $roles = Role::get();
        $agencys = Agency::get();
        return view('admin.users.create', compact('roles','agencys','page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'first_name'        => 'required|regex:/^[a-zA-Z]+$/u',
                'last_name'         => ['regex:/^[a-zA-Z]+$/u', 'nullable'],
                'email'             => 'required|email|unique:users',
                'password'          => 'required|confirmed',
                'password_confirmation'  => 'required',
                'agency_id'  => 'required',
                'roles'  => 'required',
                'user_img'      => 'mimes:jpg,png,jpeg,gif',
            ],
        );



        $fileName = $this->__imageSave($request, 'user_img', 'user-images');
        $full_name = $request->input('first_name').' '.$request->input('last_name');

        $new_user = [
            'name'          => $full_name,
            'first_name'    => $request->input('first_name'),
            'last_name'     => $request->input('last_name'),
            'email'         => $request->input('email'),
            'agency_id'         => $request->input('agency_id'),
            'profile'       => $fileName,
            'password'      => Hash::make($request->input('password')),
        ];

        $user = User::create($new_user);

        if($user)
        {
            $user->syncRoles($request->input('roles'));
            return redirect()->route('admin.users.index')->with('success', __('Added successfully'));
        } else
        {
            return redirect()->back()->with('error', __('There are some problem in form submition.'));
        }

    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = __('Thay đổi thông tin');
        $user = User::findorFail($id);
        $roles = Role::get();
        $userRoles = User::get_roles($id);
        $agencys = Agency::get();

        return view('admin.users.edit', compact('user', 'roles','agencys', 'userRoles','page_title'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'first_name'    => 'required|regex:/^[a-zA-Z]+$/u',
                'last_name'     => ['regex:/^[a-zA-Z]+$/u', 'nullable'],
                'email'         => 'required|email|unique:users,email,'.$id,
                'user_img'      => 'mimes:jpg,png,jpeg,gif',
            ],
        );

        $user = User::findorFail($id);

        $fileName = $this->__imageSave($request, 'user_img', 'user-images', $user->profile);
        $full_name = $request->input('first_name').' '.$request->input('last_name');

        $user->name       = $full_name;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->agency_id        = $request->input('agency_id');


        if(!empty($fileName))
        {
            $user->profile = $fileName;
        }

        if($user->save())
        {
            return redirect()->route('admin.users.index')->with('success', __('Thêm thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải vui lòng quay lại sau.'));
        }

    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findorFail($id);
        if($user->delete())
        {
            return redirect()->back()->with('success', __('Deleted successfully'));
        } else {
            return redirect()->back()->with('error', __('There are some problem.'));
        }
    }

    /**
     * Update Password the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, $user_id='')
    {
        $this->validate($request, [
                'password'          => ['required',
                                    Password::min(8),
                                    'same:confirm_password'],
                'confirm_password'  => 'required',
            ],
        );

        $user = User::findorFail($user_id);
        $user->password = Hash::make($request->input('password'));
        $user->save();

        if($user->save())
        {
            return redirect()->route('admin.users.index')->with('success', __('Password updated successfully'));
        } else {
            return redirect()->back()->with('error', __('There are some problem in form submition.'));
        }

    }

    /**
     * Update roles the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_user_roles(Request $request, $user_id='')
    {
        $user = User::findorFail($user_id);
        $user->syncRoles($request->input('roles'));

        return redirect()->route('admin.users.index')->with('success', __('Roles updated successfully'));
    }

    private function __imageSave($request, $key='', $folder_name='', $old_img='')
    {
        $fileName = "";
        if($request->hasFile($key) && !empty($key) && !empty($folder_name)) {
            $image = $request->file($key);
            $OriginalName = $image->getClientOriginalName();
            $fileName = time().'.'.$OriginalName;
            $request->file($key)->storeAs('public/'.$folder_name.'/', $fileName);
            if(!empty($old_img)) {
                if (Storage::exists('public/'.$folder_name.'/', $old_img)) {
                    Storage::delete('public/'.$folder_name.'/'.$old_img);
                }
            }
        }

        return $fileName;
    }

    public function profile()
    {
        $page_title = __('Thông tin tài khoản');
        $user_id    = Auth::id();
        $sessionArr = DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                        ->where('user_id', $user_id)
                        ->orderBy('last_activity', 'desc')
                        ->get();

        $sessions = collect( $sessionArr )->map(function ($session) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });

        $user = User::findorFail(Auth::id());
        $roles = Role::get();
        $userRoles = User::get_roles(Auth::id());
        return view('admin.profile.profile', compact('user', 'roles', 'userRoles', 'sessions', 'page_title'));
    }

    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function remove_user_image($id)
    {
        $user = User::where('id', '=', $id)->first();
        if(!empty($user->profile) && Storage::exists('public/user-images/'.$user->profile))
        {
            Storage::delete('public/user-images/'.$user->profile);
            $user->profile = Null;
            return $user->save();
        }

    }
      /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexbutl(Request $request)
    {
        $page_title = __('Danh sách tài khoản');
        $resultQuery = UserB::query();

        if($request->filled('name')) {
            $resultQuery->where('name', 'like', "%{$request->input('name')}%");
        }

        if($request->filled('phone'))
        {
            $resultQuery->where('phone', 'like', "%{$request->input('phone')}%");

        }

        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_time';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $users = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.users.indexbutl', compact('users','page_title'));

    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editbutl($id)
    {
        $page_title = __('Thay đổi thông tin');
        $user = UserB::findorFail($id);
        return view('admin.users.butledit', compact('user', 'page_title'));
    }

    public function updatebutl(Request $request, $id)
    {

        $user = UserB::findorFail($id);
        $user->is_active = $request->input('is_active');
        $user->access_token = '';

        if($user->save())
        {
            return redirect()->route('admin.usersbutl.index')->with('success', __('Cập nhật thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải vui lòng quay lại sau.'));
        }

    }


}
