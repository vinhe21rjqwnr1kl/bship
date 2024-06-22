<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportDriversList;
use App\Exports\ExportPaymentRequest;
use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Utils\SuperAdminPermissionCheck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use App\Models\Agency;
use App\Models\DriverService;
use App\Models\CfServiceMain;
use App\Models\CfServiceType;
use App\Models\LogAddMoneyRequest;
use App\Models\CfDriverPercent;
use App\Models\LogAddMoney;
use App\Models\CfServiceDetail;
use App\Models\Trip;
use App\Rules\EditorEmptyCheckRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\ExportPayment;
use Storage;

class DriverController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request)
    {
        $page_title = __('Danh sách tài xế');
        $resultQuery = Driver::query();
        $users = User::get();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('phone')) {
                $resultQuery->where('phone', 'like', "%{$request->input('phone')}%");
            }
            if ($request->filled('name')) {
                $resultQuery->where('name', 'like', "%{$request->input('name')}%");
            }
            if ($request->filled('is_active')) {

                $isActive = $request->input('is_active');
                if ($isActive === '1') {
                    $resultQuery->where('is_active', '=', '1');
                } else {
                    $resultQuery->where('is_active', '!=', '1');
                }
            }
        }
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }

        $resultQuery->select('user_driver_data.*', 'user_driver_data.name as user_name');
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_time';
        $resultQuery->orderBy('user_driver_data.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $status = config('blog.status');
        $roleArr = Agency::pluck('name', 'id')->toArray();
        $roleArr[0] = "Công ty BUTL";

        if ($request->input('excel') == "Excel") {
            if (!SuperAdminPermissionCheck::isAdmin()) {
                return redirect()->back()->with('error', 'Bạn không có quyền truy cập chức năng này.');
            } else {
                $response = Excel::download(new ExportDriversList($request), 'dstaixe.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                if (ob_get_contents()) ob_end_clean();
                return $response;
            }
        }

//        return $drivers;

        return view('admin.driver.index', compact('drivers', 'users', 'roleArr', 'page_title'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_warn(Request $request)
    {
        $page_title = __('Danh sách tài xế sắp hết tiền');
        $resultQuery = Driver::query();
        $users = User::get();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('phone')) {
                $resultQuery->where('phone', 'like', "%{$request->input('phone')}%");
            }
            if ($request->filled('name')) {
                $resultQuery->where('name', 'like', "%{$request->input('name')}%");
            }
            if ($request->filled('is_active')) {
                if ($request->filled('is_active') == 1) {
                    $resultQuery->where('is_active', '=', 1);
                } else {
                    $resultQuery->where('is_active', '!=', 1);
                }
            }
        }
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }
        $resultQuery->where('money', '<', 200000);
        $resultQuery->where('is_active', '=', 1);

        $resultQuery->select('user_driver_data.*', 'user_driver_data.name as user_name');
        $direction = $request->get('direction') ? $request->get('direction') : 'asc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'money';
        $resultQuery->orderBy('user_driver_data.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $status = config('blog.status');
        $roleArr = Agency::pluck('name', 'id')->toArray();
        $roleArr[0] = "Công ty BUTL";

        return view('admin.driver.warn', compact('drivers', 'users', 'roleArr', 'page_title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('Tạo Tài Xế');

        $users = User::get();
        $screenOption = config('blog.ScreenOption');
        return view('admin.driver.create', compact('users', 'page_title', 'screenOption'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        try {
            DB::beginTransaction();
            $driveData["name"] = $request->input('name');
            $driveData["phone"] = $request->input('phone');
            $driveData["birthday"] = $request->input('birthday');
            $driveData["email"] = $request->input('email');
            $driveData["gplx_level"] = $request->input('gplx_level');
            $driveData["gplx_number"] = $request->input('gplx_number');
            $driveData["cmnd"] = $request->input('cmnd');
            $driveData["exp"] = $request->input('exp');
            $driveData["is_active"] = 1;
            $driveData["day_lock"] = $request->input('day_lock');
            $driveData["car_num"] = $request->input('car_num');
            $driveData["car_info"] = $request->input('car_info');

            $current_user = auth()->user();
            $driveData["agency_id"] = $current_user->agency_id;

            $check_phone = Driver::firstWhere('phone', $driveData["phone"]);
            if (!empty($check_phone)) {
                return redirect()->route('driver.admin.create')->with('error', __('Số điện thoại đã tồn tại.'));
            }
            $validation = [
                'name' => 'required',
                'phone' => 'required|regex:/^[0-9]{10}+$/',
                'email' => 'required|email',
                'gplx_level' => 'required',
                'gplx_number' => 'required|regex:/^[0-9]+$/',
                'exp' => 'required|regex:/^[0-9]+$/',
                'cmnd' => 'required|regex:/^[0-9]+$/',
            ];
            $validationMsg = [
                'name.required' => __('Tên tài xế không để trống.'),
                'phone.required' => __('Số điện thoại tài xế không để trống.'),
                'phone.regex' => __('Số điện thoại tài xế phải là số.'),
                'email.required' => __('Email tài xế không để trống.'),
                'email.email' => __('Email tài xế không đúng định dạng.'),
                'gplx_level.required' => __('Hạng GPLX của tài xế không để trống.'),
                'gplx_number.required' => __('Số GPLX tài xế không để trống.'),
                'gplx_number.regex' => __('Số GPLX tài xế phải là số.'),
                'exp.required' => __('Số năm kinh nghiệm tài xế không để trống.'),
                'exp.regex' => __('Số năm kinh nghiệm tài xế phải là số.'),
                'cmnd.required' => __('Số CMND tài xế không để trống.'),
                'cmnd.regex' => __('Số CMND tài xế phải là số.'),

            ];
            $this->validate($request, $validation, $validationMsg);
            $appUrl = config('app.url');

            $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();
            if (!empty($blog_metas)) {
                foreach ($blog_metas as $blog_meta) {
                    if (!empty($blog_meta['value'])) {
                        $OriginalName = $blog_meta['value']->getClientOriginalName();
                        $fileName = time() . '_' . $OriginalName;
                        $blog_meta['value']->storeAs('public/driver', $fileName);
                        $blog_meta['value'] = $fileName;
                        //Array ( [title] => avatar [value] => 1680872171_6.png ) Array ( [title] => cmnd [value] => 1680872171_7.png ) Array ( [title] => gplx [value] => 1680872171_8.png )
                        if ($blog_meta["title"] == 'avatar') {

                            $driveData["avatar_img"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
//                            $fullUrl = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
//                            $path = str_replace($appUrl, '', $fullUrl);
//                            $driveData["avatar_img"] = $path;
                        }
                        if ($blog_meta["title"] == 'cmnd') {
                            $driveData["cmnd_image"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                        if ($blog_meta["title"] == 'cmnd_s') {
                            $driveData["cmnd_image_s"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                        if ($blog_meta["title"] == 'gplx') {
                            $driveData["gplx_image"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                        if ($blog_meta["title"] == 'gplx_s') {
                            $driveData["gplx_image_s"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                    }
                }
            }

            $blog = Driver::query()->create($driveData);

            $msgResponse = $this->syncGsm($blog);

            DB::commit();

            return redirect()->back()->with('success', __('Tạo tài xế thành công. ') . $msgResponse);


//            $configuration = Configuration::query()->where('name', 'gsm_config')->first();
//            $accessToken = json_decode($configuration->value)->access_token;
//            $xClient = json_decode($configuration->value)->gsm_username;
//
//            $msgResponse = '';
//            $phoneCode = '+84';
//            $fullPhoneNumber = $phoneCode . substr($driveData["phone"], 1);
//
//            $url = 'https://test-api.xanhsm.com/gsm-partner-booking/butl/driver/create';
//
//            $headers = [
//                'Content-Type' => 'application/json',
//                'x-client-id' => $xClient,
//                'Authorization' => 'Bearer ' . $accessToken,
//            ];
//
//            $body = [
//                'phone_number' => $fullPhoneNumber,
//                'region_code' => 'VNM',
//                'phone_number_code' => $phoneCode,
//                'full_name' => $driveData["name"],
//                'language_code' => 'vi',
//                'email' => $driveData["email"],
//                'sap_profile_id' => $blog->id,
//                'city_id' => $blog->agency_id
//            ];
//
//            $response = Http::withHeaders($headers)->post($url, $body);
//
//            dd($headers, $url, $body, $response->json());
//            // Xử lý phản hồi
//            $responseBody = $response->json();
//            if ($responseBody) {
//                if (isset($responseBody['error'])) {
//                    $msgResponse .= 'Lỗi đồng bộ GSM: ' . $responseBody['error'];
//                } elseif (isset($responseBody['data'])) {
//                    $blog->update(['user_gsm_id' => $responseBody['data']['user_id']]);
//                } else {
//                    $msgResponse .= 'Lỗi đồng bộ GSM: ' . $responseBody['message'];
//
//                }
//            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __('An error occurred: ') . $e->getMessage());
        }
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
        $page_title = __('Chỉnh Sửa Tài Xế');
        $driver = Driver::findorFail($id);
        $drivers = Driver::get();
        $screenOption = config('blog.ScreenOption');
        return view('admin.driver.edit', compact('drivers', 'driver', 'page_title', 'screenOption'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function admin_update(Request $request, $id)
    {
        try {
            $driveData["name"] = $request->input('name');
            $driveData["phone"] = $request->input('phone');
            $driveData["birthday"] = $request->input('birthday');
            $driveData["email"] = $request->input('email');
            $driveData["gplx_level"] = $request->input('gplx_level');
            $driveData["gplx_number"] = $request->input('gplx_number');
            $driveData["exp"] = $request->input('exp');
            $driveData["is_active"] = $request->input('is_active');
            $driveData["cmnd"] = $request->input('cmnd');
            $driveData["day_lock"] = $request->input('day_lock');
            $driveData["find_index"] = $request->input('find_index');
            $driveData["car_num"] = $request->input('car_num');
            $driveData["car_info"] = $request->input('car_info');


            if ($driveData["is_active"] == 2) {
                $driveData["access_token"] = '';
                $driveData["active_token"] = '';
            }
            if ($driveData["day_lock"]) {
                $driveData["access_token"] = '';
                $driveData["active_token"] = '';
            }


            $validation = [
                'name' => 'required',
                'phone' => 'required|regex:/^[0-9]{10}+$/',
                'email' => 'required|email',
                'gplx_level' => 'required',
                'gplx_number' => 'required|regex:/^[0-9]+$/',
                'exp' => 'required|regex:/^[0-9]+$/',
                'cmnd' => 'required|regex:/^[0-9]+$/',
            ];

            $validationMsg = [
                'name.required' => __('Tên tài xế không để trống.'),
                'phone.required' => __('Số điện thoại tài xế không để trống.'),
                'phone.regex' => __('Số điện thoại tài xế phải là số.'),
                'email.required' => __('Email tài xế không để trống.'),
                'email.email' => __('Email tài xế không đúng định dạng.'),
                'gplx_level.required' => __('Hạng GPLX của tài xế không để trống.'),
                'gplx_number.required' => __('Số GPLX tài xế không để trống.'),
                'gplx_number.regex' => __('Số GPLX tài xế phải là số.'),
                'exp.required' => __('Số năm kinh nghiệm tài xế không để trống.'),
                'exp.regex' => __('Số năm kinh nghiệm tài xế phải là số.'),
                'cmnd.required' => __('Số CMND tài xế không để trống.'),
                'cmnd.regex' => __('Số CMND tài xế phải là số.'),

            ];
            $this->validate($request, $validation, $validationMsg);
            $appUrl = config('app.url');

            $blog_metas = collect($request->data['BlogMeta'])->sortKeys()->all();
            if (!empty($blog_metas)) {
                foreach ($blog_metas as $blog_meta) {
                    if (!empty($blog_meta['value'])) {
                        $OriginalName = $blog_meta['value']->getClientOriginalName();
                        $fileName = time() . '_' . $OriginalName;
                        $blog_meta['value']->storeAs('public/driver', $fileName);
                        $blog_meta['value'] = $fileName;
                        //Array ( [title] => avatar [value] => 1680872171_6.png ) Array ( [title] => cmnd [value] => 1680872171_7.png ) Array ( [title] => gplx [value] => 1680872171_8.png )
                        if ($blog_meta["title"] == 'avatar') {
                            $driveData["avatar_img"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
//                            dd($appUrl);
//                            dd($driveData["avatar_img"]);

                        }
                        if ($blog_meta["title"] == 'cmnd') {
                            $driveData["cmnd_image"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                        if ($blog_meta["title"] == 'cmnd_s') {
                            $driveData["cmnd_image_s"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                        if ($blog_meta["title"] == 'gplx') {
                            $driveData["gplx_image"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                        if ($blog_meta["title"] == 'gplx_s') {
                            $driveData["gplx_image_s"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                        }
                    }
                }
            }

            $driver = Driver::findorFail($id);
            if ($driveData["find_index"] != $driver->find_index) {
                $driveData["access_token"] = '';
                $driveData["active_token"] = '';
            }

            $driver->fill($driveData)->save();

            $msgResponse = $this->syncGsm($driver);

            return redirect()->back()->with('success', __('Cập nhật tài xế thành công. ') . $msgResponse);


//      Đồng bộ GSM
//        $configuration = Configuration::query()->where('name', 'gsm_config')->first();
//        $accessToken = json_decode($configuration->value)->access_token;
//        $xClient = json_decode($configuration->value)->gsm_username;
//
//        $msgResponse = '';
//        $phoneCode = '+84';
//        $fullPhoneNumber = $phoneCode . substr($driveData["phone"], 1);
//
//        $url = 'https://test-api.xanhsm.com/gsm-partner-booking/butl/driver/create';
//
//        $headers = [
//            'Content-Type' => 'application/json',
//            'x-client-id' => $xClient,
//            'Authorization' => 'Bearer ' . $accessToken,
//        ];
//
//        $body = [
//            'phone_number' => $fullPhoneNumber,
//            'region_code' => 'VNM',
//            'phone_number_code' => $phoneCode,
//            'full_name' => $driveData["name"],
//            'language_code' => 'vi',
//            'email' => $driveData["email"],
//            'sap_profile_id' => $driver->id,
//            'city_id' => $driver->agency_id
//        ];
//        if ($driver->user_gsm_id) {
//            $body['user_id'] = $driver->user_gsm_id;
//        }
//
//        $response = Http::withHeaders($headers)->post($url, $body);
//        // Xử lý phản hồi
//        $responseBody = $response->json();
//        if ($responseBody) {
//            if (isset($responseBody['error'])) {
//                $msgResponse .= 'Lỗi đồng bộ GSM: ' . $responseBody['error'];
//            } else if (isset($responseBody['data'])) {
//                $driver->update(['user_gsm_id' => $responseBody['data']['user_id']]);
//            } else {
//                $msgResponse .= 'Lỗi đồng bộ GSM: ' . $responseBody['message'];
//            }
//        }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('An error occurred: ') . $e->getMessage());
        }
    }

    public function syncDriverGsm($id)
    {
        try {
            $driver = Driver::query()->where('id', $id)->first();
            if (!$driver) {
                return redirect()->back()->with('error', __('Không tìm thấy tài xế'));
            }

            $configuration = Configuration::query()->where('name', 'gsm_config')->first();
            if (!$configuration) {
                return redirect()->back()->with('error', __('Configuration not found'));
            }

            $configValue = json_decode($configuration->value);
            $accessToken = $configValue->access_token;
            $xClient = $configValue->gsm_username;
            $phoneCode = '+84';
            $fullPhoneNumber = $phoneCode . substr($driver->phone, 1);
            $url = env('URL_API_GSM') . 'driver/create';

            $headers = [
                'Content-Type' => 'application/json',
                'x-client-id' => $xClient,
                'Authorization' => 'Bearer ' . $accessToken,
            ];

            $body = [
                'phone_number' => $fullPhoneNumber,
                'region_code' => 'VNM',
                'phone_number_code' => $phoneCode,
                'full_name' => $driver->name,
                'language_code' => 'vi',
                'email' => $driver->email,
                'sap_profile_id' => "BUTL_" . $driver->id,
                'city_id' => $driver->agency_id == 1 ? 59 : 50,
            ];
            if ($driver->user_gsm_id && $driver->user_gsm_id != 1) {
                $body['user_id'] = $driver->user_gsm_id;
            }

            $response = Http::withHeaders($headers)->post($url, $body);

            // Xử lý phản hồi
            $responseBody = $response->json();
            if (isset($responseBody['error'])) {
                return redirect()->back()->with('error', $responseBody['error']);
            } elseif (isset($responseBody['data'])) {
                $userId = $responseBody['data']['user_id'];
                $driver->update(['user_gsm_id' => $userId]);
                return redirect()->back()->with('success', 'Đồng bộ thành công');
            } else {
                return redirect()->back()->with('error', $responseBody['message'] ?? 'Unknown error');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('Lỗi đồng bộ GSM: ') . $e->getMessage() ?? 'Unknown error');
        }
    }

    private function syncGsm($driver)
    {
        $configuration = Configuration::query()->where('name', 'gsm_config')->first();
        if (!$configuration) {
            return __('Configuration not found');
        }

        $configValue = json_decode($configuration->value);
        $accessToken = $configValue->access_token;
        $xClient = $configValue->gsm_username;
        $phoneCode = '+84';
        $fullPhoneNumber = $phoneCode . substr($driver->phone, 1);
        $url = env('URL_API_GSM') . 'driver/create';

        $headers = [
            'Content-Type' => 'application/json',
            'x-client-id' => $xClient,
            'Authorization' => 'Bearer ' . $accessToken,
        ];

        $body = [
            'phone_number' => $fullPhoneNumber,
            'region_code' => 'VNM',
            'phone_number_code' => $phoneCode,
            'full_name' => $driver->name,
            'language_code' => 'vi',
            'email' => $driver->email,
            'sap_profile_id' => 'BUTL_' . $driver->id,
            'city_id' => $driver->agency_id == 1 ? 59 : 50,
        ];
        if ($driver->user_gsm_id && $driver->user_gsm_id != 1) {
            $body['user_id'] = $driver->user_gsm_id;
        }

        $response = Http::withHeaders($headers)->post($url, $body);
        $responseBody = $response->json();

        if (isset($responseBody['error'])) {
            return __('Lỗi đồng bộ GSM: ') . $responseBody['error'];
        } elseif (isset($responseBody['data'])) {
            $userId = $responseBody['data']['user_id'];
            $driver->update(['user_gsm_id' => $userId]);
            return __('Đồng bộ GSM thành công.');
        } else {
            return __('Lỗi đồng bộ GSM: ') . ($responseBody['message'] ?? 'Unknown error');
        }
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_online(Request $request)
    {
        $page_title = __('Danh sách tài xế đang online');
        $resultQuery = Driver::query();
        $users = User::get();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('phone')) {
                $resultQuery->where('phone', 'like', "%{$request->input('phone')}%");
            }
            if ($request->filled('name')) {
                $resultQuery->where('name', 'like', "%{$request->input('name')}%");
            }
            if ($request->filled('is_active')) {
                if ($request->filled('is_active') == 1) {
                    $resultQuery->where('is_active', '=', 1);
                } else {
                    $resultQuery->where('is_active', '!=', 1);
                }
            }
        }

        // check online app
//        $urrl = "http://api-taixe.bship.vn:22072/api/v1/web/get_all_user";  // real

        $url_api_socket = env('URL_API_SOCKET');
        $urrl = $url_api_socket . 'api/v1/web/get_all_user';

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $urrl,
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_SSL_VERIFYHOST => 0, // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $x = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($x, true);
        $list_driver_online = [];

        if (isset($result["data"]) && isset($result["data"]["drivers"])) {
            $adriver = $result["data"]["drivers"];

            $drivers = array_filter($adriver, function ($driver) {
                return isset($driver['type']) && $driver['type'] == 'DRIVER' && $driver['online'];
            });

            foreach ($drivers as $driver) {
                $list_driver_online[] = $driver['userID'];
            }
        }

        $resultQuery->whereIn('id', $list_driver_online);

        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }

        $resultQuery->select('user_driver_data.*', 'user_driver_data.name as user_name');
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_time';
        $resultQuery->orderBy('user_driver_data.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;

        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $status = config('blog.status');
        $roleArr = Agency::pluck('name', 'id')->toArray();
        $roleArr[0] = "Công ty BUTL";

        return view('admin.driver.online', compact('drivers', 'users', 'roleArr', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $page_title = __('Danh sách yêu cầu nạp tiền');

        $resultQuery = LogAddMoneyRequest::query();
        if ($request->filled('phone')) {
            $resultQuery->where('user_phone', 'like', "%{$request->input('phone')}%");
        }
        if ($request->filled('name')) {
            $resultQuery->where('user_name', 'like', "%{$request->input('name')}%");
        }
        if ($request->filled('datefrom')) {
            $resultQuery->where('create_date', '>=', "{$request->input('datefrom')}");
        }
        if ($request->filled('dateto')) {
//            $dateto = Carbon::createFromFormat('Y-m-d', $request->input('dateto'))->endOfDay();
            $resultQuery->where('create_date', '<=', $request->input('dateto'));
        }
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

        if ($request->input('excel') == "Excel") {
            if (!SuperAdminPermissionCheck::isAdmin()) {
                return redirect()->back()->with('error', 'Bạn không có quyền truy cập chức năng này.');
            } else {
                $response = Excel::download(new ExportPaymentRequest($request), 'ds-yeucau-naptien.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                if (ob_get_contents()) ob_end_clean();
                return $response;
            }
        }
        return view('admin.driver.payment_list', compact('LogAddMoneyRequest', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function payment_create($id = 0)
    {
        if ($id > 0) {
            $logAddMoneyRequest = LogAddMoneyRequest::query()->where('go_id', '=', $id)->exists();
            if ($logAddMoneyRequest) {
                return redirect()->route('trip.admin.index', 0)->with('error', __('Yêu cầu hoàn tiền đã tồn tại.'));
            }
        }

        $page_title = __('Tạo yêu cầu nạp tiền');

        $type_payments = array(
            array('id' => 'cashin', 'name' => __('Nạp ví tài xế')),
            array('id' => 'refund', 'name' => __('Hoàn ví cuốc hủy')),
            array('id' => 'donate', 'name' => __('Tặng/thưởng')),
            array('id' => 'cashout', 'name' => __('Rút ví ngưng hợp tác')),
            array('id' => 'other', 'name' => __('Khác'))
        );

        $phone = '';
        $reason = '';
        $money = 0;
        $info_string = '';
        $go_id = $id;
        if ($id > 0) {
            $go_info = Trip::findorFail($id);
            $driver_id = $go_info->driver_id;
            $driver = Driver::findorFail($driver_id);
            $phone = $driver->phone;
            $money = $go_info->driver_cost;
            $reason = 'Nạp tiền cho Cuốc Hủy BUTL_' . $id . ' lúc ' . $go_info->create_date;
            $info_string = $driver->name;
        }
        return view('admin.driver.payment_create', compact('phone', 'money', 'reason', 'go_id', 'info_string', 'type_payments', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_create_info(Request $request, $go_id = 0, $phone = null)
    {
        if ($go_id > 0) {
            $logAddMoneyRequest = LogAddMoneyRequest::query()->where('go_id', '=', $go_id)->exists();
            if ($logAddMoneyRequest) {
                return redirect()->route('trip.admin.index', 0)->with('error', __('Yêu cầu hoàn tiền đã tồn tại.'));
            }
        }

        $page_title = __('Tạo yêu cầu nạp tiền');

        $type_payments = array(
            array('id' => 'cashin', 'name' => __('Nạp ví tài xế')),
            array('id' => 'refund', 'name' => __('Hoàn ví cuốc hủy')),
            array('id' => 'donate', 'name' => __('Tặng/thưởng')),
            array('id' => 'cashout', 'name' => __('Rút ví ngưng hợp tác')),
            array('id' => 'other', 'name' => __('Khác'))
        );

        $driveData["phone"] = $phone;
        if ($phone) {
            $check_phone = Driver::firstWhere('phone', $driveData["phone"]);

        }
        $info_string = '';
        $money = '';
        $reason = '';
        if (empty($check_phone)) {
            $info_string = 'Không có tài xế tồn tại với số điện thoại này';
        } else {
            $driveData["user_name"] = $check_phone->name;
            $driveData["cmnd"] = $check_phone->cmnd;
            $info_string = 'Tên tài xế: ' . $driveData["user_name"] . ' --- CMND: ' . $driveData["cmnd"];
//            dd($check_phone);
            if ($check_phone->is_active == 2) {
                $info_string .= ". Tài khoản ngưng hoạt động không thể tạo yêu cầu";
            }
        }
        $phone = $driveData["phone"];
        return view('admin.driver.payment_create', compact('phone', 'money', 'reason', 'go_id', 'info_string', 'type_payments', 'page_title'));
    }

    public function payment_store(Request $request)
    {
        if ($request->input('go_id') > 0) {
            $logAddMoneyRequest = LogAddMoneyRequest::query()->where('go_id', '=', $request->input('go_id'))->exists();
            if ($logAddMoneyRequest) {
                return redirect()->route('trip.admin.index', 0)->with('error', __('Yêu cầu hoàn tiền đã tồn tại.'));
            }
        }

        $driveData["go_id"] = $request->input('go_id');
        $driveData["phone"] = $request->input('phone');
        $driveData["money"] = $request->input('money');
        $driveData["reason"] = $request->input('reason');
        $driveData["type"] = $request->input('type');
        $validation = [
            'money' => 'required|regex:/^[0-9-]+$/',
            'phone' => 'required|regex:/^[0-9]{10}+$/',
            'reason' => 'required',
            'type' => 'required',

        ];
        $validationMsg = [
            'money.required' => __('Vui lòng nhập số tiền'),
            'phone.required' => __('Số điện thoại tài xế không để trống'),
            'phone.regex' => __('Số điện thoại tài xế phải là số'),
            'reason.required' => __('Lí do nạp tiền không để trống'),
            'type.required' => __('Không để trống'),

        ];
        $this->validate($request, $validation, $validationMsg);
        $check_phone = Driver::firstWhere('phone', $driveData["phone"]);
        if (empty($check_phone)) {
            return redirect()->back()->with('error', __('Số điện thoại tài xế không tồn tại.'));
        } else if ($check_phone->is_active == 2) {
            return redirect()->back()->with('error', __('Trạng thái tài xế không hoạt động, không thể tạo yêu cầu nạp tiền'));
        } else {
            $driveData["user_id"] = $check_phone->id;
            $driveData["user_name"] = $check_phone->name;
            $driveData["user_phone"] = $check_phone->phone;
            $driveData["agency_id"] = $check_phone->agency_id;
            $current_user = auth()->user();
            $driveData["create_name"] = $current_user->email;
            $driveData["status"] = 0;

            // kiểm tra agency có quản lý tài xế không ?
            if ($current_user->agency_id > 0) {
                if ($current_user->agency_id != $check_phone->agency_id) {
                    return redirect()->back()->with('error', __('Bạn không quản lí tài xế không tồn tại.'));
                }
            }
            $blog = LogAddMoneyRequest::create($driveData);
            return redirect()->route('driver.admin.payment', 0)->with('success', __('Thêm yêu cầu nạp tiền thành công.'));
        }

    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_approve(Request $request)
    {
        $page_title = __('Danh sách cần duyệt');

        $resultQuery = LogAddMoneyRequest::query();
        if ($request->filled('phone')) {
            $resultQuery->where('user_phone', 'like', "%{$request->input('phone')}%");
        }
        if ($request->filled('name')) {
            $resultQuery->where('user_name', 'like', "%{$request->input('name')}%");
        }
        // lấy danh sách theo đại lý hoặc lấy ds tất cả nếu là tk của tổng công ty
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }
        $resultQuery->where('status', '=', "0");

        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.driver.payment_list_approve', compact('LogAddMoneyRequest', 'page_title'));
    }

    public function payment_addmoney(Request $request, $id)
    {
        $page_title = __('Danh sách cần duyệt');
        $info_request = LogAddMoneyRequest::firstWhere('id', $id);
        $current_user = auth()->user();
        if ($info_request) {
            if ($info_request->status != 0) {
                return redirect()->route('driver.admin.payment_approve')->with('error', __('Yêu cầu đã duyệt rồi.'));
            }
            $driver_id = $info_request->user_id;
            $driver_phone = $info_request->user_phone;
            $driver_name = $info_request->user_name;
            $driver_agency_id = $info_request->agency_id;
            $driver_money = $info_request->money;
            $driver_reason = $info_request->reason;
            $driver_create_name = $info_request->create_name;

            //check tai xe thuoc dai ly
            if ($current_user->agency_id > 0) {
                if ($current_user->agency_id != $driver_agency_id) {
                    return redirect()->route('driver.admin.payment_list_approve')->with('error', __('Bạn không quản lí tài xế không tồn tại.'));
                }
            }
            // lấy thông tin tài xế
            $driver = Driver::findorFail($driver_id);
            $driveData["money"] = $driver->money + $driver_money; //$driver_money số tiền yêu cầu thêm

            // lưu log
            $LogAddMoney["user_id"] = $driver_id;
            $LogAddMoney["money"] = $driver_money;
            $LogAddMoney["user_name"] = $driver_name;
            $LogAddMoney["user_phone"] = $driver_phone;
            $LogAddMoney["reason"] = $driver_reason;
            $LogAddMoney["create_name"] = $driver_create_name;
            $LogAddMoney["type"] = 1;
            $LogAddMoney["user_type"] = 2;
            $LogAddMoney["current_money"] = $driver->money;
            $LogAddMoney["new_money"] = $driveData["money"];
            $LogAddMoney["agency_id"] = $driver_agency_id;
            $LogAddMoney = LogAddMoney::create($LogAddMoney);
            if ($LogAddMoney) {
                // cập nhật ds yêu cầu status = 1 đã duyệt
                $request = LogAddMoneyRequest::findorFail($id);
                $requestData["status"] = 1;
                $request->fill($requestData)->save();
                // add tiền cho tài xế
                $driver->fill($driveData)->save();
                return redirect()->route('driver.admin.payment_approve')->with('success', __('Duyệt nạp tiền thành công.'));
            }
        }
    }

    public function handle_payment_remove($id, $isUser = false)
    {
        $request = LogAddMoneyRequest::findorFail($id);

        if ($isUser) {
            $userRequest = $request->create_name;
            $currentUser = auth()->user()->email;
            if ($currentUser != $userRequest) {
                return redirect()->route('driver.admin.payment')->with('warning', __('Yêu cầu không hợp lệ.'));
            }
        }

        $requestData["status"] = 2;
        $request->fill($requestData)->save();

        $route = $isUser ? 'driver.admin.payment' : 'driver.admin.payment_approve';
        return redirect()->route($route)->with('success', __('Xoá yêu cầu nạp tiền thành công.'));
    }

    public function payment_remove($id)
    {
        return $this->handle_payment_remove($id);
    }

    public function payment_remove_user($id)
    {
        return $this->handle_payment_remove($id, true);
    }


    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment_log(Request $request)
    {
        $page_title = __('Danh sách lịch sử nạp tiền');

        $resultQuery = LogAddMoney::query();
        if ($request->filled('phone')) {
            $resultQuery->where('user_phone', 'like', "%{$request->input('phone')}%");
        }
        if ($request->filled('name')) {
            $resultQuery->where('user_name', 'like', "%{$request->input('name')}%");
        }
        if ($request->filled('datefrom')) {
            $resultQuery->where('time', '>=', "{$request->input('datefrom')}");
        }
        if ($request->filled('dateto')) {
//            $dateto = Carbon::createFromFormat('Y-m-d', $request->input('dateto'))->endOfDay();
            $resultQuery->where('time', '<=', $request->input('dateto'));
        }
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('user_driver_data.agency_id', '=', $driveData["agency_id"]);
        }
        $resultQuery->leftjoin('user_driver_data', 'user_driver_data.id', '=', 'user_id');
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->select('log_add_money.*', 'user_driver_data.name', 'user_driver_data.phone');

        $resultQuery->orderBy($sortBy, $direction);
        $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

        if ($request->input('excel') == "Excel") {
            $response = Excel::download(new ExportPayment($request), 'lsnaptien.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            ob_end_clean();
            return $response;
        }

        return view('admin.driver.payment_list_log', compact('LogAddMoneyRequest', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function log(Request $request)
    {
        $page_title = __('Tra cứu tài xế');

        $resultQuery = LogAddMoney::query();
        $LogAddMoneyRequest = array();
        if ($request->input('phone')) {


            $driver = Driver::firstWhere('phone', $request->input('phone'));
            if ($driver) {
                $driver_id = $driver->id;
                $resultQuery->where('user_id', '=', $driver_id);

            }

            $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
            $direction = $request->get('direction') ? $request->get('direction') : 'desc';
            $resultQuery->orderBy($sortBy, $direction);
            $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));
            return view('admin.driver.log', compact('LogAddMoneyRequest', 'driver', 'page_title'));

        } else {
            $resultQuery->where('user_id', '=', "666666666");
            $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
            $direction = $request->get('direction') ? $request->get('direction') : 'desc';
            $resultQuery->orderBy($sortBy, $direction);
            $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));
            return view('admin.driver.log', compact('LogAddMoneyRequest', 'page_title'));
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_drservice(Request $request, $driver_id)
    {
        $page_title = __('Quản lý dịch vụ');
        $resultQuery = DriverService::query();
        $resultQuery->where('driver_id', '=', $driver_id);
        $resultQuery->orderBy('service_detail_id', 'desc');

        $result = $resultQuery->get()->toArray();
        $drivers = array();
        for ($i = 0; $i < count($result); $i++) {
            $driver_service = $result[$i];
            if ($driver_service["service_detail_id"] > 0) {
                $service_detail_id = $driver_service["service_detail_id"];
                $drivers[$service_detail_id]["active"] = $driver_service["active"];
                $drivers[$service_detail_id]["allow_service"] = $driver_service["allow_service"];
                $drivers[$service_detail_id]["id"] = $driver_service["id"];

            }

        }
        $resultQuery_percent = CfDriverPercent::query();
        $resultQuery_percent->where('driver_id', '=', $driver_id);
        $resultQuery_percent->orderBy('service_detail_id', 'desc');
        $result_percent = $resultQuery_percent->get()->toArray();
        $drivers_percent = array();
        for ($i = 0; $i < count($result_percent); $i++) {
            $driver_service_percent = $result_percent[$i];
            if ($driver_service_percent["service_detail_id"] > 0) {
                $service_detail_id = $driver_service_percent["service_detail_id"];
                $drivers_percent[$service_detail_id] = $driver_service_percent["percent"];
            }

        }
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $CfServiceDetail =
                CfServiceDetail::where('status', '=', 1)
                    ->where('agency_id', '=', $driveData["agency_id"])
                    ->leftjoin('cf_services_detail_agency', 'cf_services_detail_agency.service_detail_id', '=', 'cf_services_detail.id')
                    ->select('service_id', 'service_type', 'service_detail_id as id')
                    ->get();

        } else {
            $CfServiceDetail = CfServiceDetail::where('status', '=', 1)->get();
        }
        return view('admin.driver.drservice', compact('drivers_percent', 'driver_id', 'drivers', 'CfServiceDetail', 'ServicesArr', 'ServicesTypeArr', 'page_title'));
    }

    public function admin_drserviceedelete($id)
    {

        $check = DriverService::destroy($id);
        if ($check) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }


    public function admin_drserviceallow($id)
    {

        $CfFee = DriverService::findorFail($id);
        if ($CfFee->allow_service == 0) {
            $requestData["allow_service"] = 1;
            $requestData["active"] = 0;
        } else {
            $requestData["allow_service"] = 0;
            $requestData["active"] = 1;
        }
        $check = $CfFee->fill($requestData)->save();
        if ($check) {
            return redirect()->back()->with('success', __('Cập nhật thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    public function admin_drservicestore(Request $request, $driver_id, $service_detail_id)
    {

        $driveData["service_detail_id"] = $service_detail_id;
        $driveData["driver_id"] = $driver_id;
        //kiểm tra xem services_detail_id này đã có giá chưa
        $check_service = DriverService::Where('service_detail_id', $driveData["service_detail_id"])->Where('driver_id', $driveData["driver_id"])->first();;
        if (!empty($check_service)) {
            return redirect()->route('driver.admin.drservice', $driver_id)->with('error', __('Đã tồn tại.'));
        }
        // kiểm tra agency có quản lý tài xế không ?
        $current_user = auth()->user();
        if ($current_user->agency_id > 0) {
            $check_phone = Driver::firstWhere('id', $driveData["driver_id"]);
            if ($current_user->agency_id != $check_phone->agency_id) {
                return redirect()->route('driver.admin.drservice', $driver_id)->with('error', __('Bạn không quản lí tài xế không tồn tại.'));
            }
        }
        $blog = DriverService::create($driveData);
        return redirect()->route('driver.admin.drservice', $driver_id)->with('success', __('Tạo thành công.'));

    }

    public function admin_percent(Request $request, $driver_id, $service_detail_id, $percent)
    {

        $driveData["service_detail_id"] = $service_detail_id;
        $driveData["driver_id"] = $driver_id;
        $driveData["percent"] = $percent;
        // kiểm tra agency có quản lý tài xế không ?
        $current_user = auth()->user();
        if ($current_user->agency_id > 0) {
            $check_phone = Driver::firstWhere('id', $driveData["driver_id"]);
            if ($current_user->agency_id != $check_phone->agency_id) {
                return redirect()->route('driver.admin.drservice', $driver_id)->with('error', __('Bạn không quản lí tài xế không tồn tại.'));
            }
        }
        if ($driveData["percent"] > 0) {
            $check_service = CfDriverPercent::Where('service_detail_id', $driveData["service_detail_id"])->Where('driver_id', $driveData["driver_id"])->first();;
            if (!empty($check_service)) {
                $id = $check_service->id;
                $CfFee = CfDriverPercent::findorFail($id);
                $requestData["percent"] = $percent;
                $check = $CfFee->fill($requestData)->save();
            } else {
                $blog = CfDriverPercent::create($driveData);
            }

        } else {
            CfDriverPercent::Where('service_detail_id', $driveData["service_detail_id"])->Where('driver_id', $driveData["driver_id"])->delete();
        }
        return redirect()->route('driver.admin.drservice', $driver_id)->with('success', __('Cập nhật thành công.'));

    }

    public function admin_onlinemap(Request $request)
    {

        $page_title = __('Tài xế Online ');

//        $urrl = "http://dev-taixe.bship.vn:22072/api/v1/web/get_all_user";
//        $urrl = "http://api-taixe.bship.vn:22072/api/v1/web/get_all_user";

        $url_api_socket = env('URL_API_SOCKET');
        $urrl = $url_api_socket . 'api/v1/web/get_all_user';

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $urrl,
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_SSL_VERIFYHOST => 0, // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10
        );
        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $x = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($x, true);

        if ($result) {
            $adriver = $result["data"]['drivers'];

            // vi tri dai li

            $current_user = auth()->user();
            $agency_id = $current_user->agency_id;
            if ($agency_id == 1) {

                $latitude_quan = 20.9991232;
                $longitude_quan = 105.8097722;
            } else {
                $latitude_quan = 10.781287;
                $longitude_quan = 106.703685;
            }
            $string = '';
            $tringtx = '';

            for ($i = 0; $i < count($adriver); $i++) {
                if ($adriver[$i]['online'] === true) {
                    $name = $adriver[$i]['name'];
                    $phone = $adriver[$i]['phone'];
                    $latitude = $adriver[$i]['latitude'];
                    $longitude = $adriver[$i]['longitude'];
                    $n = $i + 1;
                    $string .= "['" . $name . "( " . $phone . " )', " . $latitude . "," . $longitude . "," . $phone . "],";
                }
            }
            $sdt_tx = 1;
            if ($request->sdt) {
                $sdt_tx = $request->sdt;
            }

            // $string = "['SG Nguyễn Dũng Toàn(0765855557)','10.9094068','106.6485102'],['HN Phan Xuân Nguyên(0982978668)', '21.013671086889','105.85253962909']";
            return view('admin.driver.onlinemap', compact('string', 'latitude_quan', 'longitude_quan', 'sdt_tx', 'page_title'));
        }

    }
//
}
