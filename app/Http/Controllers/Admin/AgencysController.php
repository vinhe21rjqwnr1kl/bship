<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\Agency;
use Spatie\Permission\Models\Role;
use App\Models\Role as UserRole;
use Auth;
use Jenssegers\Agent\Agent;
use Storage;

class AgencysController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = __('Danh sách đại lý');
        $resultQuery = Agency::query();

        if($request->filled('name')) {
            $resultQuery->where('name', 'like', "%{$request->input('name')}%");
        }

        if($request->filled('email')) {
            $resultQuery->where('email', 'like', "%{$request->input('email')}%");
        }

        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $users = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.agency.index', compact('users','page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = __('Tạo đại lý');
        return view('admin.agency.create', compact('page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = [
            'name'           => 'required',
            'phone'      => 'required|regex:/^[0-9]{10}+$/',
            'email'             => 'required|email',
            'address'           => 'required',
            'info'           =>  'required',
        ];

        $validationMsg = [
            'name.required'      => __('Tên đại lý không để trống.'),
            'phone.required'      => __('Số điện thoại đại lý  không để trống.'),
            'phone.regex'      => __('Số điện thoại đại lý phải là số.'),
            'email.required'      => __('Email đại lý  không để trống.'),
            'email.email'      => __('Email đại lý  không đúng định dạng.'),
            'address.required'      => __('Địa chỉ đại lý không để trống.'),
            'info.required'      => __('Thông tin không để trống.'),
        ];
        $this->validate($request, $validation, $validationMsg);

        $agencyData["name"]           = $request->input('name');
        $agencyData["phone"]           = $request->input('phone');
        $agencyData["address"]        = $request->input('address');
        $agencyData["email"]           = $request->input('email');
        $agencyData["info"]      = $request->input('info');
        $agency = Agency::create($agencyData);
        if($agency)
        {
            return redirect()->route('admin.agencys.index')->with('success', __('Tạo thành công đại lý'));
        } else
        {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
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
        $page_title = __('Thông tin đại lý');
        $user = Agency::findorFail($id);
        return view('admin.agency.edit', compact('user','page_title'));
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


        $validation = [
            'name'           => 'required',
            'phone'      => 'required|regex:/^[0-9]{10}+$/',
            'email'             => 'required|email',
            'address'           => 'required',
            'info'           =>  'required',
        ];

        $validationMsg = [
            'name.required'      => __('Tên đại lý không để trống.'),
            'phone.required'      => __('Số điện thoại đại lý  không để trống.'),
            'phone.regex'      => __('Số điện thoại đại lý phải là số.'),
            'email.required'      => __('Email đại lý  không để trống.'),
            'email.email'      => __('Email đại lý  không đúng định dạng.'),
            'address.required'      => __('Địa chỉ đại lý không để trống.'),
            'info.required'      => __('Thông tin không để trống.'),
        ];
        $this->validate($request, $validation, $validationMsg);
        $agency = Agency::findorFail($id);

        $agencyData["name"]           = $request->input('name');
        $agencyData["phone"]           = $request->input('phone');
        $agencyData["address"]        = $request->input('address');
        $agencyData["email"]           = $request->input('email');
        $agencyData["info"]      = $request->input('info');


        if($agency->fill($agencyData)->save())
        {
            return redirect()->route('admin.agencys.index')->with('success', __('Cập nhật thông tin thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang quá tải.'));
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
}
