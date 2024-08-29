<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Banner;
use App\Models\UserB;
use App\Models\Driver;


use App\Rules\EditorEmptyCheckRule;
use Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_notify(Request $request)
    {
        $page_title = __('Danh sách thông báo');
        $resultQuery = Notification::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('phone')) {
                $resultQuery->where('phone', 'like', "%{$request->input('phone')}%");
            }
            if ($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('name')}%");
            }
        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $resultQuery->orderBy($sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $noti = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.customer.noti', compact('noti', 'page_title'));
    }

    public function admin_notifydelete($id)
    {
        $CfFee = Notification::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_notifycreate()
    {
        $page_title = __('Tạo thông báo');
        return view('admin.customer.noticreate', compact('page_title'));
    }

    public function admin_notifystore(Request $request)
    {

        $noti["title"] = $request->input('title');
        $noti["content"] = $request->input('content');
        $noti["phone"] = $request->input('receiver_id');
        $noti["receiver_id"] = $request->input('receiver_id');
        $noti["is_show_popup"] = 0;
        $noti["type"] = $request->input('type');
        $noti["sender_id"] = 1;
        $noti["is_read"] = 0;

        $noti["create_time"] = date('Y-m-d H:i:.htaccess', time());;

        $validation = [
            'title' => 'required',
            'content' => 'required',
            'receiver_id' => 'required|regex:/^[0-9]+$/',

        ];
        $validationMsg = [
            'title.required' => __('Vui lòng không để trống.'),
            'content.required' => __('Vui lòng nội dung không để trống.'),
            'receiver_id.required' => __('Người nhận không để trống.'),
            'receiver_id.regex' => __('Sai định dạng.'),

        ];
        $this->validate($request, $validation, $validationMsg);
        if ($noti["type"] == 2) // tài  xế
        {
            $check_phone = Driver::firstWhere('phone', $noti["receiver_id"]);
            if (empty($check_phone)) {
                return redirect()->route('custumer.admin.notifycreate')->with('error', __('Số điện thoại tài xế không tồn tại.'));
            }
            $noti["receiver_id"] = $check_phone["id"];
        }
        if ($noti["type"] == 1) // khách hàngg
        {
            $check_phone = UserB::firstWhere('phone', $noti["receiver_id"]);
            if (empty($check_phone)) {
                return redirect()->route('custumer.admin.notifycreate')->with('error', __('Số điện thoại khách hàng không tồn tại.'));
            }
            $noti["receiver_id"] = $check_phone["id"];
        }
        $blog = Notification::create($noti);
        return redirect()->route('custumer.admin.notify')->with('success', __('Tạo thông báo thành công.'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_banner(Request $request)
    {
        $page_title = __('Danh sách banner');
        $resultQuery = Banner::query();
        $banner_types = Banner::BANNER_TYPE;

        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('phone')) {
                $resultQuery->where('phone', 'like', "%{$request->input('phone')}%");
            }
            if ($request->filled('title')) {
                $resultQuery->where('title', 'like', "%{$request->input('name')}%");
            }
        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $resultQuery->orderBy($sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $banner = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.customer.banner', compact('banner', 'banner_types', 'page_title'));
    }

    public function admin_bannerdelete($id)
    {
        $CfFee = Banner::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    public function admin_bannercreate()
    {
        $page_title = __('Tạo banner');
        $banner_types = Banner::BANNER_TYPE;

        return view('admin.customer.bannercreate', compact('page_title', 'banner_types'));
    }

    public function admin_bannerstore(Request $request)
    {

        $noti["title"] = $request->input('title');
        $noti["direct_url"] = $request->input('direct_url');
        $noti["index"] = $request->input('index');
        $noti["type"] = $request->input('type');
        $noti["status"] = $request->input('status');

        $validation = [
            'index' => 'required|regex:/^[0-9]+$/',
        ];

        $validationMsg = [
            'index.required' => __('Người nhận không để trống.'),
            'index.regex' => __('Sai định dạng.'),
        ];

        $this->validate($request, $validation, $validationMsg);
        $appUrl = config('app.url');

        $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();
        if (!empty($blog_metas)) {
            foreach ($blog_metas as $blog_meta) {
                if (!empty($blog_meta['value'])) {
                    $OriginalName = $blog_meta['value']->getClientOriginalName();
                    $fileName = time() . '_' . $OriginalName;
                    $blog_meta['value']->storeAs('public/banner', $fileName);
                    $blog_meta['value'] = $fileName;
                    if ($blog_meta["title"] == 'image') {
                        $noti["url"] = $appUrl . 'storage/banner/' . $blog_meta["value"];
                    }
                }
            }
        }
        $blog = Banner::create($noti);
        return redirect()->route('custumer.admin.banner')->with('success', __('Tạo thông báo thành công.'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_notifirebase()
    {
        $page_title = __('Thông báo quảng cáo');
        return view('admin.customer.notifirebase', compact('page_title'));
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_notifirebasessend(Request $request)
    {


        $noti["phone"] = $request->input('phone');
        $noti["title"] = $request->input('title');
        $noti["body"] = $request->input('body');

        $firebaseToken = array();
        if ($noti["phone"] == 1) //gui tat ca
        {
            $firebaseToken = UserB::where('device_token', ">", "0")->pluck('device_token', 'id')->toArray();

        } else {
            $pieces = explode(";", $noti["phone"]);
            for ($i = 0; $i < count($pieces); $i++) {
                $check_phone = UserB::firstWhere('phone', $pieces[$i]);
                if ($check_phone) {
                    $device_token = $check_phone->device_token;
                    if ($device_token) {
                        $firebaseToken[] = $device_token;
                    }
                }
            }
        }
        $SERVER_API_KEY = 'AAAAGJ8ASNM:APA91bHkvawvry8anEv1oifDIKZm7vlqKX1Zj16uZPuE02_j7Tb2ePWR8cYoV7a6ZxqpgqbJOah56Q2tIRnwZ765Z0qRxAT6UNtOuC1nbJC-SXQQ1Y_X2igkHBenkhaDzsWl--m7l9UM';
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $noti["title"],
                "body" => $noti["body"],
            ]
        ];
        $dataString = json_encode($data);
        print_r($dataString);
        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);

        print_r($response);
        exit;

        return redirect()->route('custumer.admin.notifirebase')->with('success', __('Tạo thông báo thành công.'));

    }


}
