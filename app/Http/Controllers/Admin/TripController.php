<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\TripRequest;
use App\Models\CfServiceMain;
use App\Models\CfServiceType;
use App\Models\CfGoProcess;
use App\Models\CfServiceDetail;
use App\Models\UserB;
use App\Models\Driver;
use App\Models\LogAddMoney;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel\WithHeadings;
use Maatwebsite\Excel\Facades\Excel\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\ExportTrip;
use App\Rules\EditorEmptyCheckRule;
use Storage;
use Telegram\Bot\Laravel\Facades\Telegram;


class TripController extends Controller

{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_index(Request $request, $service_id)
    {
        $page_title = __('Danh sách chuyến');
        $resultQuery = Trip::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('goid')) {
                $pieces = explode("_", $request->input('goid'));
                if (isset($pieces[1]))
                    $resultQuery->Where('go_info.id', 'like', "%{$pieces[1]}%");
                else
                    $resultQuery->Where('go_info.id', 'like', "%{$request->input('goid')}%");
            }
            if ($request->filled('phone')) {
                $resultQuery->where('user_data.phone', 'like', "%{$request->input('phone')}%");
                $resultQuery->orWhere('user_driver_data.phone', 'like', "%{$request->input('phone')}%");
            }

            if ($request->filled('name')) {
                $resultQuery->where('user_data.name', 'like', "%{$request->input('name')}%");
                $resultQuery->orWhere('user_driver_data.name', 'like', "%{$request->input('name')}%");
            }
            if ($request->filled('datefrom')) {
                $resultQuery->where('go_info.create_date', '>=', "{$request->input('datefrom')}");
            }
            if ($request->filled('dateto')) {
                $resultQuery->where('go_info.create_date', '<', "{$request->input('dateto')}");
            }
            if ($request->filled('progress')) {
                $resultQuery->where('progress', 'like', "%{$request->input('progress')}%");
            }
        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('go_info.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('user_driver_data', 'user_driver_data.id', '=', 'go_info.driver_id');
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_info.user_id');
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'go_info.service_detail_id');

        if ($service_id == 3) {
            $resultQuery
                ->join('food_orders', 'food_orders.id', '=', 'go_info.food_order_id')
                ->join('restaurants', 'restaurants.id', '=', 'food_orders.restaurant_id')
                ->select('*', 'go_info.id as go_id', 'user_driver_data.name as driver_name',
                    'user_driver_data.phone as driver_phone',
                    'user_data.name as user_name09',
                    'user_data.phone as user_phone09',
                    'restaurants.name as restaurant_name',
                    'restaurants.address as restaurant_address',
                )
                ->addSelect(DB::raw('(SELECT GROUP_CONCAT(food_products.name) FROM food_order_items
                    JOIN food_products ON food_order_items.food_product_id = food_products.id
                    WHERE food_order_items.food_order_id = food_orders.id) AS food_product_name'))
                ->whereNotNull('go_info.food_order_id');
        } else {
            $resultQuery->select('*', 'go_info.id as go_id', 'user_driver_data.name as driver_name',
                'user_driver_data.phone as driver_phone',
                'user_data.name as user_name09',
                'user_data.phone as user_phone09');
        }

        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }

        if ($service_id > 0) {
            $resultQuery->where('go_info.service_id', '=', $service_id);

        } else {
            $resultQuery->whereNotIn('go_info.service_id', [6, 8, 11, 12]);
        }

        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $CfGoProcessArr = CfGoProcess::pluck('name', 'id')->toArray();

        if ($request->input('excel') == "Excel") {
            $response = Excel::download(new ExportTrip($request, $service_id), 'chuyendi.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            ob_end_clean();
            return $response;
        }
        // $status = config('blog.status');
        // $roleArr = Agency::pluck('name', 'id')->toArray();
        // $roleArr[0]= "Công ty BUTL";
        return view('admin.trip.index', compact('service_id', 'drivers', 'ServicesArr', 'ServicesTypeArr', 'CfGoProcessArr', 'page_title'));
    }


    /**
     * @param $service_id
     * @param $go_id
     * @return JsonResponse|void
     */
    public function admin_detail($service_id, $go_id)
    {
        $resultQuery = Trip::query();

        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }

        if ($service_id == 3) {
            $resultQuery
                ->join('food_orders', 'food_orders.id', '=', 'go_info.food_order_id')
                ->join('restaurants', 'restaurants.id', '=', 'food_orders.restaurant_id')
                ->select('go_info.id as go_id',
                    'food_orders.id as food_orders_id',
                    'restaurants.name as restaurant_name',
                    'restaurants.address as restaurant_address',
                )->whereNotNull('go_info.food_order_id');

            $resultQuery->where('go_info.service_id', '=', $service_id)
                ->where('go_info.id', $go_id);

            $data = $resultQuery->first();
            $forders_id = $data->food_orders_id;

            $orderItems = DB::table('food_order_items')
                ->join('food_products', 'food_order_items.food_product_id', '=', 'food_products.id')
                ->leftJoin('food_product_sizes', 'food_order_items.food_product_size_id', '=', 'food_product_sizes.id')
                ->leftJoin('sizes', 'sizes.id', '=', 'food_product_sizes.size_id')
                ->where('food_order_items.food_order_id', '=', $forders_id)
                ->select('food_order_items.*', 'food_products.*', 'food_product_sizes.*', 'sizes.name as size_name')
                ->get();

            foreach ($orderItems as $orderItem) {
                $orderItem->size_name ??= "";
            }

            return response()->json([
                'data' => $data,
                'order_items' => $orderItems,
            ]);
        }

        if ($service_id == 4) {
            $resultQuery
                ->join('go_request', 'go_request.id', '=', 'go_info.go_request_id')
                ->join('delivery_go_info', 'delivery_go_info.go_id', '=', 'go_info.id')
                ->select('*', 'go_info.id as go_id',
                    'go_request.id as go_request_id',
                    'delivery_go_info.id as delivery_go_info_id',
                );

            $resultQuery
                ->where('go_info.id', $go_id)
                ->where('go_info.service_id', '=', $service_id);

            $data = $resultQuery->first();

            return response()->json([
                'data' => $data,
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_cancel(Request $request)
    {

        $page_title = __('Danh sách chuyến huỷ');
        $resultQuery = Trip::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('phone')) {
                $resultQuery->where('user_data.phone', 'like', "%{$request->input('phone')}%");
                $resultQuery->orWhere('user_driver_data.phone', 'like', "%{$request->input('phone')}%");

            }
            if ($request->filled('name')) {
                $resultQuery->where('.user_data.name', 'like', "%{$request->input('name')}%");
                $resultQuery->orWhere('user_driver_data.name', 'like', "%{$request->input('name')}%");

            }
            if ($request->filled('datefrom')) {
                $resultQuery->where('go_info.create_date', '>=', "{$request->input('datefrom')}");
            }
            if ($request->filled('dateto')) {
                $resultQuery->where('go_info.create_date', '<', "{$request->input('dateto')}");
            }
            if ($request->filled('progress')) {
                $resultQuery->where('progress', '=', "%{$request->input('progress')}%");
            }
        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('go_info.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('user_driver_data', 'user_driver_data.id', '=', 'go_info.driver_id');
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_info.user_id');
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'go_info.service_detail_id');
        $resultQuery->select('*', 'go_info.id as go_id', 'user_driver_data.name as driver_name',
            'user_driver_data.phone as driver_phone',
            'user_data.name as user_name09',
            'user_data.phone as user_phone09');
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }
        $resultQuery->where('progress', '=', 4);


        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));


        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $CfGoProcessArr = CfGoProcess::pluck('name', 'id')->toArray();

        // $status = config('blog.status');
        // $roleArr = Agency::pluck('name', 'id')->toArray();
        // $roleArr[0]= "Công ty BUTL";
        return view('admin.trip.cancel', compact('drivers', 'ServicesArr', 'ServicesTypeArr', 'CfGoProcessArr', 'page_title'));

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_fail(Request $request)
    {
        $page_title = __('Danh sách chuyến thất bại');
        $resultQuery = TripRequest::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('phone')) {
                $resultQuery->where('user_data.phone', 'like', "%{$request->input('phone')}%");


            }
            if ($request->filled('name')) {
                $resultQuery->where('user_data.name', 'like', "%{$request->input('name')}%");

            }
            if ($request->filled('datefrom')) {
                $resultQuery->where('go_request.create_date', '>=', "{$request->input('datefrom')}");
            }
            if ($request->filled('dateto')) {
                $resultQuery->where('go_request.create_date', '<', "{$request->input('dateto')}");
            }
            if ($request->filled('status')) {
                $resultQuery->where('go_request.status', '=', "{$request->input('status')}");
            }
        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $resultQuery->orderBy('go_request.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_request.user_id');
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'go_request.service_detail_id');


        $resultQuery->select('*', 'go_request.status as statusmain',
            'user_data.name as user_name09',
            'user_data.phone as user_phone09');


        $drivers = $resultQuery->paginate(config('Reading.nodes_per_page'));


        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $CfGoProcessArr = CfGoProcess::pluck('name', 'id')->toArray();

        // $status = config('blog.status');
        // $roleArr = Agency::pluck('name', 'id')->toArray();
        // $roleArr[0]= "Công ty BUTL";
        return view('admin.trip.fail', compact('drivers', 'ServicesArr', 'ServicesTypeArr', 'CfGoProcessArr', 'page_title'));

    }

    public function status($id)
    {

        $current_user = auth()->user();
        $id_user = $current_user->id;
        $Trip = Trip::findorFail($id);
        if ($Trip->progress == 3) {
            $requestData["progress"] = 4;
            $requestData["feedback"] = $id_user;
        } else {
            $requestData["progress"] = 3;
            $requestData["feedback"] = $id_user;
        }
        $check = $Trip->fill($requestData)->save();
        if ($check) {
            return redirect()->back()->with('success', __('Cập nhật thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_create()
    {
        $page_title = __('Tạo chuyến đi');

        $screenOption = config('blog.ScreenOption');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.trip.create', compact('ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title', 'screenOption'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function admin_store(Request $request)
    {
        $driveData["service_detail_id"] = $request->input('service_detail_id');
        $driveData["sdt_kh"] = $request->input('sdt_kh');
        $driveData["sdt_tx"] = $request->input('sdt_tx');
        $driveData["from"] = $request->input('from');
        $driveData["to"] = $request->input('to');
        $driveData["money_total"] = $request->input('money_total');
        $driveData["money_tx"] = $request->input('money_tx');
        $driveData["money_butl"] = $request->input('money_butl');
        $driveData["money_km"] = $request->input('money_km');;
        $driveData["money_dv"] = $request->input('money_dv');

        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        $check_phone_tx = Driver::firstWhere('phone', $driveData["sdt_tx"]);
        if (empty($check_phone_tx)) {
            return redirect()->route('trip.admin.create')->with('error', __('Số điện thoại tài xế không tồn tại.'));
        }
        $trip["driver_id"] = $check_phone_tx->id;
        $agency_id_tx = $check_phone_tx->agency_id;
        $current_user = auth()->user();
        $agency_id_login = $current_user->agency_id;
        if ($agency_id_login > 0) {
            if ($agency_id_login != $agency_id_tx) {
                return redirect()->route('trip.admin.create')->with('error', __('Tài xế không phải bạn quản lý.'));

            }
        }


        $check_phone_kh = UserB::firstWhere('phone', $driveData["sdt_kh"]);
        if (empty($check_phone_kh)) {
            return redirect()->route('trip.admin.create')->with('error', __('Số điện thoại khách hàng không tồn tại.'));
        }
        $trip["user_id"] = $check_phone_kh->id;


        $check_phone_dv = CfServiceDetail::firstWhere('id', $driveData["service_detail_id"]);
        if (empty($check_phone_dv)) {
            return redirect()->route('trip.admin.create')->with('error', __('Dich vụ không đã tồn tại.'));
        }
        $trip["service_id"] = $check_phone_dv->service_id;


        $validation = [
            'service_detail_id' => 'required',
            'from' => 'required',
            'sdt_kh' => 'required|regex:/^[0-9]{10}+$/',
            'sdt_tx' => 'required|regex:/^[0-9]{10}+$/',
            'money_total' => 'required|regex:/^[0-9]+$/',
            'money_tx' => 'required|regex:/^[0-9]+$/',
            'money_butl' => 'required|regex:/^[0-9]+$/',
            'money_km' => 'required|regex:/^[0-9]+$/',
            'money_dv' => 'required|regex:/^[0-9]+$/',
        ];
        $validationMsg = [
            'service_detail_id.required' => __('DV không để trống.'),
            'sdt_kh.required' => __('Số điện thoại khách hàng không để trống.'),
            'sdt_kh.regex' => __('Số điện thoại khách hàng phải là số.'),
            'sdt_tx.required' => __('Số điện thoại tài xế không để trống.'),
            'sdt_tx.regex' => __('Số điện thoại tài xế phải là số.'),
            'from.required' => __('Địa chỉ đi không để trống.'),

            'money_total.required' => __('Tổng tiền không để trống.'),
            'money_total.regex' => __('Tổng tiền phải là số.'),

            'money_tx.required' => __('Tiền tài xế không để trống.'),
            'money_tx.regex' => __('Tiền tài xế phải là số.'),

            'money_butl.required' => __('Tiền BUTL không để trống.'),
            'money_butl.regex' => __('Tiền BUTL phải là số.'),

            'money_km.required' => __('Tiền khuyến mãi không để trống.'),
            'money_km.regex' => __('Tiền khuyến mãi phải là số.'),

            'money_dv.required' => __('Tiền dịch vụ không để trống.'),
            'money_dv.regex' => __('Tiền dịch vụ phải là số.'),


        ];
        $this->validate($request, $validation, $validationMsg);

        $trip["service_detail_id"] = $driveData["service_detail_id"];
        // $trip["service_id"] = $driveData["service_detail_id"] ;
        $trip["pickup_address"] = $driveData["from"];
        $trip["pickup_place_id"] = "";
        $trip["pickup_date"] = date('Y-m-d', time());;
        $trip["pickup_time"] = date('Y-m-d H:i:.htaccess', time());;
        $trip["drop_address"] = $driveData["to"];
        $trip["drop_place_id"] = "";
        $trip["drop_time"] = date('Y-m-d H:i:.htaccess', time());;
        $trip["drop_date"] = date('Y-m-d', time());;
        $trip["progress"] = 3;

        $trip["cost"] = $driveData["money_total"];
        $trip["driver_cost"] = $driveData["money_butl"] + $driveData["money_dv"];
        $trip["butl_cost"] = $driveData["money_tx"] - $driveData["money_dv"];

        $trip["create_date"] = date('Y-m-d H:i:.htaccess', time());;
        $trip["go_request_id"] = 1000;
        $trip["discount_from_code"] = $driveData["money_km"];
        $trip["service_cost"] = $driveData["money_dv"];
        $trip["is_show_app"] = 0;
        $trip = Trip::create($trip);
        if ($trip) {
            // lấy thông tin tài xế
            $driver = Driver::findorFail($trip["driver_id"]);
            $driver_money = -($trip["service_cost"] + $driveData["money_butl"] - $driveData["money_km"]);
            $drive_new["money"] = $driver->money + $driver_money; //$driver_money số tiền yêu cầu thêm

            // lưu log
            $LogAddMoney["user_id"] = $trip["driver_id"];
            $LogAddMoney["money"] = $driver_money;
            $LogAddMoney["user_name"] = $driver->name;
            $LogAddMoney["user_phone"] = $driver->phone;
            $LogAddMoney["reason"] = "Nhận chuyến từ butl";
            $LogAddMoney["create_name"] = $driver->name;
            $LogAddMoney["type"] = 1;
            $LogAddMoney["user_type"] = 2;
            $LogAddMoney["current_money"] = $driver->money;
            $LogAddMoney["new_money"] = $drive_new["money"];
            $LogAddMoney["agency_id"] = $driver->agency_id;
            $LogAddMoney = LogAddMoney::create($LogAddMoney);
            if ($LogAddMoney) {
                // add tiền cho tài xế
                $driver->fill($drive_new)->save();
                return redirect()->route('trip.admin.index', 0)->with('success', __('Tạo chuyến đi thành công.'));
            }
        }
        return redirect()->back()->with('error', __('Thêm chuyến thất bại.'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function admin_bot()
    {
        // $activity = Telegram::getUpdates();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = time() - 120;
        $date_s = date("Y-m-d H:i:.htaccess", $date);
        $resultQuery = Trip::query();
        $resultQuery->where('go_info.update_time', '>=', $date_s);
        $direction = 'desc';
        $sortBy = 'update_time';
        $resultQuery->orderBy('go_info.' . $sortBy, $direction);
        $resultQuery->join('user_driver_data', 'user_driver_data.id', '=', 'go_info.driver_id');
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_info.user_id');
        $resultQuery->select('go_info.id',
            'go_info.service_detail_id',
            'go_info.progress', 'go_info.pickup_address', 'go_info.drop_address',
            'go_info.cost', 'go_info.driver_cost', 'go_info.butl_cost', 'go_info.discount_from_code', 'go_info.service_cost',
            'go_info.service_id', 'user_driver_data.name as driver_name',
            'user_driver_data.phone as driver_phone',
            'user_driver_data.agency_id as driver_agency_id',
            'user_data.name as user_name09',
            'user_data.phone as user_phone09');

        $drivers = $resultQuery->get()->toArray();
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $CfGoProcessArr = CfGoProcess::pluck('name', 'id')->toArray();

        // $text ='';
        if ($drivers) {
            for ($i = 0; $i < count($drivers); $i++) {
                $drivers_a = $drivers[$i];

                /// huy chuyen gui cho cskh
                if ($drivers_a['progress'] == 4) {
                    $text = "Mã chuyến đi: " . $drivers_a['id'] . "\n"
                        . "Trạng thái: " . $CfGoProcessArr[$drivers_a['progress']] . "\n"
                        . "Dịch vụ: " . $ServicesArr[$drivers_a['service_id']] . "\n"
                        . "Khách: " . $drivers_a['user_phone09'] . " - " . $drivers_a['user_name09'] . "\n"
                        . "Tài xế: " . $drivers_a['driver_phone'] . " - " . $drivers_a['driver_name'] . "\n"
                        . "Tổng Tiền : " . $drivers_a['cost'] . " -- ĐL: " . $drivers_a['driver_cost'] - $drivers_a['service_cost']
                        . " -- TX: " . $drivers_a['butl_cost'] + $drivers_a['service_cost'] . " -- Bảo Hiểm: " . $drivers_a['service_cost']
                        . " -- KM: " . $drivers_a['discount_from_code'] . "\n"
                        . "Từ: " . $drivers_a['pickup_address'] . "\n"
                        . "Đến: " . $drivers_a['drop_address'] . "\n"
                        . "\n------------------------------------------\n";
                    Telegram::sendMessage([
                        'chat_id' => '-993063333',
                        'parse_mode' => 'HTML',
                        'text' => $text
                    ]);

                }
                // dai ly HN//huy chuyến
                if ($drivers_a['driver_agency_id'] == 1 && $drivers_a['progress'] == 4) {
                    $text = "Mã chuyến đi: " . $drivers_a['id'] . "\n"
                        . "Trạng thái: " . $CfGoProcessArr[$drivers_a['progress']] . "\n"
                        . "Dịch vụ: " . $ServicesArr[$drivers_a['service_id']] . "\n"
                        . "Khách: " . $drivers_a['user_phone09'] . " - " . $drivers_a['user_name09'] . "\n"
                        . "Tài xế: " . $drivers_a['driver_phone'] . " - " . $drivers_a['driver_name'] . "\n"
                        . "Tổng Tiền : " . $drivers_a['cost'] . " -- ĐL: " . $drivers_a['driver_cost'] - $drivers_a['service_cost']
                        . " -- TX: " . $drivers_a['butl_cost'] + $drivers_a['service_cost'] . " -- Bảo Hiểm: " . $drivers_a['service_cost']
                        . " -- KM: " . $drivers_a['discount_from_code'] . "\n"
                        . "Từ: " . $drivers_a['pickup_address'] . "\n"
                        . "Đến: " . $drivers_a['drop_address'] . "\n"
                        . "\n------------------------------------------\n";
                    Telegram::sendMessage([
                        'chat_id' => '-850028487
                        ',
                        'parse_mode' => 'HTML',
                        'text' => $text
                    ]);

                }
                // tay nguyen // chuyến thành công
                if ($drivers_a['driver_agency_id'] == 3 && $drivers_a['progress'] == 3) {
                    $text = "Mã chuyến đi: " . $drivers_a['id'] . "\n"
                        . "Trạng thái: " . $CfGoProcessArr[$drivers_a['progress']] . "\n"
                        . "Dịch vụ: " . $ServicesArr[$drivers_a['service_id']] . "\n"
                        . "Khách: " . $drivers_a['user_phone09'] . " - " . $drivers_a['user_name09'] . "\n"
                        . "Tài xế: " . $drivers_a['driver_phone'] . " - " . $drivers_a['driver_name'] . "\n"
                        . "Tổng Tiền : " . $drivers_a['cost'] . " -- ĐL: " . $drivers_a['driver_cost'] - $drivers_a['service_cost']
                        . " -- TX: " . $drivers_a['butl_cost'] + $drivers_a['service_cost'] . " -- Bảo Hiểm: " . $drivers_a['service_cost']
                        . " -- KM: " . $drivers_a['discount_from_code'] . "\n"
                        . "Từ: " . $drivers_a['pickup_address'] . "\n"
                        . "Đến: " . $drivers_a['drop_address'] . "\n"
                        . "\n------------------------------------------\n";
                    Telegram::sendMessage([
                        'chat_id' => '-856501867
                        ',
                        'parse_mode' => 'HTML',
                        'text' => $text
                    ]);

                }
                // hcm - tat ca
                $text = "Mã chuyến đi: " . $drivers_a['id'] . "\n"
                    . "Trạng thái: " . $CfGoProcessArr[$drivers_a['progress']] . "\n"
                    . "Dịch vụ: " . $ServicesArr[$drivers_a['service_id']] . "\n"
                    . "Khách: " . $drivers_a['user_phone09'] . " - " . $drivers_a['user_name09'] . "\n"
                    . "Tài xế: " . $drivers_a['driver_phone'] . " - " . $drivers_a['driver_name'] . "\n"
                    . "Tổng Tiền : " . $drivers_a['cost'] . " -- ĐL: " . $drivers_a['driver_cost'] - $drivers_a['service_cost']
                    . " -- TX: " . $drivers_a['butl_cost'] + $drivers_a['service_cost'] . " -- Bảo Hiểm: " . $drivers_a['service_cost']
                    . " -- KM: " . $drivers_a['discount_from_code'] . "\n"
                    . "Từ: " . $drivers_a['pickup_address'] . "\n"
                    . "Đến: " . $drivers_a['drop_address'] . "\n"
                    . "\n------------------------------------------\n";
                Telegram::sendMessage([
                    'chat_id' => '-821112850',
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);
            }
        }

        $date = time() - 120;
        $date_s = date("Y-m-d H:i:.htaccess", $date);
        $resultQuery = TripRequest::query();
        $resultQuery->where('go_request.create_date', '>=', $date_s);
        $resultQuery->where('go_request.status', '!=', 2);

        $direction = 'desc';
        $sortBy = 'create_date';
        $resultQuery->orderBy('go_request.' . $sortBy, $direction);
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_request.user_id');
        $resultQuery->select('go_request.id as idd',
            'go_request.status as status_go',
            'go_request.service_detail_id',
            'go_request.progress', 'go_request.pickup_address', 'go_request.drop_address',
            'go_request.cost', 'go_request.driver_cost', 'go_request.butl_cost',
            'go_request.discount_from_code', 'go_request.service_cost',
            'go_request.service_id',
            'user_data.name as user_name09',
            'user_data.phone as user_phone09');
        $drivers = $resultQuery->get()->toArray();
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        // $text ='';
        if ($drivers) {
            for ($i = 0; $i < count($drivers); $i++) {
                $drivers_a = $drivers[$i];

                /// huy chuyen gui cho cskh

                $stg_status = 'Mới';
                if ($drivers_a["status_go"] == 0)
                    $stg_status = 'Đang tìm...';
                if ($drivers_a["status_go"] == 1)
                    $stg_status = 'Không tài xế';

                $text = "Mã chuyến đi: " . $drivers_a['idd'] . "\n"
                    . "Trạng thái: " . $stg_status . "\n"
                    . "Dịch vụ: " . $ServicesArr[$drivers_a['service_id']] . "\n"
                    . "Khách: " . $drivers_a['user_phone09'] . " - " . $drivers_a['user_name09'] . "\n"
                    . "Tổng Tiền : " . $drivers_a['cost'] . " -- ĐL: " . $drivers_a['driver_cost']
                    . " -- TX: " . $drivers_a['cost'] - $drivers_a['driver_cost'] - $drivers_a['service_cost'] . " -- Bảo Hiểm: " . $drivers_a['service_cost']
                    . " -- KM: " . $drivers_a['discount_from_code'] . "\n"
                    . "Từ: " . $drivers_a['pickup_address'] . "\n"
                    . "Đến: " . $drivers_a['drop_address'] . "\n"
                    . "\n------------------------------------------\n";
                Telegram::sendMessage([
                    'chat_id' => '-993063333',
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);
                Telegram::sendMessage([
                    'chat_id' => '-850028487
                        ',
                    'parse_mode' => 'HTML',
                    'text' => $text
                ]);

            }
        }

    }
}
