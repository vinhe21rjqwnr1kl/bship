<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\CfServiceMain;
use App\Models\CfServiceType;
use App\Models\CfFee;
use App\Models\CfFeeCity;
use App\Models\CfFeeTime;
use App\Models\CfIndexTime;
use App\Models\CfFeeExt;
use App\Models\CfServiceGroup;
use App\Models\CfServiceGroupService;
use App\Models\CfServicesOptionDetail;
use App\Models\Agency;
use App\Models\CfCityServiceDetail;


use App\Models\CfServicesDetailAgency;

use App\Models\CFServicesSub;


use Illuminate\Support\Facades\Http;

use App\Models\CfServiceDetail;


use App\Rules\EditorEmptyCheckRule;
use Storage;

class PriceController extends Controller
{
    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_kmcreate()
    {
        $page_title = __('Tạo giá theo Km');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.kmcreate', compact('ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_kmedit($id)
    {
        $page_title = __('Cập nhật giá theo Km');
        $CfFee = CfFee::findorFail($id);
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.kmedit', compact('CfFee', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }


    public function admin_kmdelete($id)
    {
        $CfFee = CfFee::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_kmupdate(Request $request, $id)
    {
        $fee["duration_block_first"] = $request->input('duration_block_first');
        $fee["fee_block_first"] = $request->input('fee_block_first');

        $fee["duration_block_second"] = $request->input('duration_block_second');
        $fee["fee_block_second"] = $request->input('fee_block_second');
        $fee["duration_block_end"] = $request->input('duration_block_end');
        $fee["fee_block_end"] = $request->input('fee_block_end');

        $fee["duration_block_end_one"] = $request->input('duration_block_end_one');
        $fee["fee_block_end_one"] = $request->input('fee_block_end_one');
        $fee["duration_block_end_two"] = $request->input('duration_block_end_two');
        $fee["fee_block_end_two"] = $request->input('fee_block_end_two');


        $fee["duration_block_end"] = $request->input('duration_block_end');
        $fee["fee_block_end"] = $request->input('fee_block_end');


        $fee["fee_fixed"] = $request->input('fee_fixed');
        $fee["fee_min"] = $request->input('fee_min');
        $fee["fee_type"] = $request->input('fee_type');
        //$fee["service_detail_id"]           = $request->input('service_detail_id');


        $validation = [
            'duration_block_first' => 'required|regex:/^[0-9]+$/',
            'fee_block_first' => 'required|regex:/^[0-9]+$/',
            'duration_block_second' => 'required|regex:/^[0-9]+$/',
            'fee_block_second' => 'required|regex:/^[0-9]+$/',
            'duration_block_end' => 'required|regex:/^[0-9]+$/',
            'fee_block_end' => 'required|regex:/^[0-9]+$/',
            'duration_block_end_one' => 'required|regex:/^[0-9]+$/',
            'fee_block_end_one' => 'required|regex:/^[0-9]+$/',
            'duration_block_end_two' => 'required|regex:/^[0-9]+$/',
            'fee_block_end_two' => 'required|regex:/^[0-9]+$/',
            'fee_fixed' => 'required|regex:/^[0-9]+$/',
            'fee_min' => 'required|regex:/^[0-9]+$/',
            'fee_type' => 'required|regex:/^[0-9]+$/',
        ];

        $validationMsg = [
            'duration_block_first.required' => __('Số km  để trống.'),
            'duration_block_first.regex' => __('Số km không đúng định dạng.'),
            'fee_block_first.required' => __('Số tiền 1 km để trống.'),
            'fee_block_first.regex' => __('Số tiền không đúng định dạng.'),
            'duration_block_second.required' => __('Số km  để trống.'),
            'duration_block_second.regex' => __('Số km không đúng định dạng.'),
            'fee_block_second.required' => __('Số tiền 1km để trống.'),
            'fee_block_second.regex' => __('Số tiền không đúng định dạng.'),
            'duration_block_end.required' => __('Số km để trống.'),
            'duration_block_end.regex' => __('Số km không đúng định dạng.'),

            'duration_block_end_one.required' => __('Số km để trống.'),
            'duration_block_end_one.regex' => __('Số km không đúng định dạng.'),
            'duration_block_end_two.required' => __('Số km để trống.'),
            'duration_block_end_two.regex' => __('Số km không đúng định dạng.'),
            'fee_block_end.required' => __('Số tiền 1km không để trống.'),
            'fee_block_end.regex' => __('Số tiền không đúng định dạng.'),
            'fee_block_end_one.required' => __('Số tiền 1km không để trống.'),
            'fee_block_end_one.regex' => __('Số tiền không đúng định dạng.'),
            'fee_block_end_two.required' => __('Số tiền 1km không để trống.'),
            'fee_block_end_two.regex' => __('Số tiền không đúng định dạng.'),
            'fee_fixed.required' => __('Tiền cố định không để trống.'),
            'fee_fixed.regex' => __('Số tiền không đúng định dạng.'),
            'fee_min.required' => __('Tiền cố định không để trống.'),
            'fee_min.regex' => __('Số tiền không đúng định dạng.'),
            'fee_type.required' => __('Loại không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);
        $CfFee = CfFee::findorFail($id);
        $CfFee_r = $CfFee->fill($fee)->save();

        if ($CfFee_r) {
            return redirect()->route('price.admin.km')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_kmstore(Request $request)
    {
        $fee["duration_block_first"] = $request->input('duration_block_first');
        $fee["fee_block_first"] = $request->input('fee_block_first');

        $fee["duration_block_second"] = $request->input('duration_block_second');
        $fee["fee_block_second"] = $request->input('fee_block_second');
        $fee["duration_block_end"] = $request->input('duration_block_end');
        $fee["fee_block_end"] = $request->input('fee_block_end');

        $fee["duration_block_end_one"] = $request->input('duration_block_end_one');
        $fee["fee_block_end_one"] = $request->input('fee_block_end_one');

        $fee["duration_block_end_two"] = $request->input('duration_block_end_two');
        $fee["fee_block_end_two"] = $request->input('fee_block_end_two');


        $fee["fee_fixed"] = $request->input('fee_fixed');
        $fee["fee_min"] = $request->input('fee_min');
        $fee["fee_type"] = $request->input('fee_type');
        $fee["service_detail_id"] = $request->input('service_detail_id');


        $validation = [
            'duration_block_first' => 'required|regex:/^[0-9]+$/',
            'fee_block_first' => 'required|regex:/^[0-9]+$/',
            'duration_block_second' => 'required|regex:/^[0-9]+$/',
            'fee_block_second' => 'required|regex:/^[0-9]+$/',
            'duration_block_end' => 'required|regex:/^[0-9]+$/',
            'fee_block_end' => 'required|regex:/^[0-9]+$/',
            'duration_block_end_one' => 'required|regex:/^[0-9]+$/',
            'fee_block_end_one' => 'required|regex:/^[0-9]+$/',
            'duration_block_end_two' => 'required|regex:/^[0-9]+$/',
            'fee_block_end_two' => 'required|regex:/^[0-9]+$/',
            'fee_fixed' => 'required|regex:/^[0-9]+$/',
            'fee_min' => 'required|regex:/^[0-9]+$/',
            'fee_type' => 'required|regex:/^[0-9]+$/',
            'service_detail_id' => 'required|regex:/^[0-9]+$/',
        ];

        $validationMsg = [
            'duration_block_first.required' => __('Số km  để trống.'),
            'duration_block_first.regex' => __('Số km không đúng định dạng.'),
            'fee_block_first.required' => __('Số tiền 1 km để trống.'),
            'fee_block_first.regex' => __('Số tiền không đúng định dạng.'),
            'duration_block_second.required' => __('Số km  để trống.'),
            'duration_block_second.regex' => __('Số km không đúng định dạng.'),
            'fee_block_second.required' => __('Số tiền 1km để trống.'),
            'fee_block_second.regex' => __('Số tiền không đúng định dạng.'),
            'duration_block_end.required' => __('Số km để trống.'),
            'duration_block_end.regex' => __('Số km không đúng định dạng.'),
            'duration_block_end_one.required' => __('Số km để trống.'),
            'duration_block_end_one.regex' => __('Số km không đúng định dạng.'),
            'duration_block_end_two.required' => __('Số km để trống.'),
            'duration_block_end_two.regex' => __('Số km không đúng định dạng.'),
            'fee_block_end.required' => __('Số tiền 1km không để trống.'),
            'fee_block_end.regex' => __('Số tiền không đúng định dạng.'),
            'fee_block_end_one.required' => __('Số tiền 1km không để trống.'),
            'fee_block_end_one.regex' => __('Số tiền không đúng định dạng.'),
            'fee_block_end_two.required' => __('Số tiền 1km không để trống.'),
            'fee_block_end_two.regex' => __('Số tiền không đúng định dạng.'),
            'fee_fixed.required' => __('Tiền cố định không để trống.'),
            'fee_fixed.regex' => __('Số tiền không đúng định dạng.'),
            'fee_min.required' => __('Tiền cố định không để trống.'),
            'fee_min.regex' => __('Số tiền không đúng định dạng.'),
            'fee_type.required' => __('Loại không để trống.'),
            'service_detail_id.required' => __('Dịch vụ không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);


        //kiểm tra xem services_detail_id này đã có giá chưa
        $check_service = CfFee::firstWhere('service_detail_id', $fee["service_detail_id"]);
        if (!empty($check_service)) {
            return redirect()->route('price.admin.kmcreate')->with('error', __('Dịch vụ đã có cài đặt giá trước đó.'));
        }
        $user = CfFee::create($fee);

        if ($user) {
            return redirect()->route('price.admin.km')->with('success', __('Thêm thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_km(Request $request)
    {
        $page_title = __('Danh sách tiền theo Km');
        $resultQuery = CfFee::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('service_detail_id', '=', $request->input('service_detail_id'));
            }

        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $resultQuery->orderBy('cf_fee.' . $sortBy, $direction);

        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('cf_services_detail', 'cf_fee.service_detail_id', '=', 'cf_services_detail.id');
        $resultQuery->select('*', 'cf_fee.id as fee_id');
        $Prices = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.km', compact('Prices', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_city(Request $request)
    {
        $page_title = __('Danh sách tiền theo Tỉnh/Thành Phố');
        $resultQuery = CfFeeCity::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('service_detail_id', '=', $request->input('service_detail_id'));
            }

        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('cf_services_detail', 'cf_fee_city_ratio.service_detail_id', '=', 'cf_services_detail.id');
        $resultQuery->select('*', 'cf_fee_city_ratio.id as fee_id');
        $resultQuery->orderBy('cf_fee_city_ratio.' . $sortBy, $direction);

        $Prices = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.city', compact('Prices', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));


    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_citycreate()
    {
        $page_title = __('Tạo giá theo Tỉnh/Thành Phố');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.citycreate', compact('ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_citystore(Request $request)
    {
        $fee["ratio"] = $request->input('ratio');
        $fee["service_detail_id"] = $request->input('service_detail_id');
        $fee["city"] = $request->input('city');
        $fee["city_search_name"] = $request->input('city_search_name');
        $validation = [
            'ratio' => 'required',
            'service_detail_id' => 'required',
            'city' => 'required',
            'city_search_name' => 'required',
        ];

        $validationMsg = [
            'ratio.required' => __('Tỷ lệ không để trống.'),
            'service_detail_id.required' => __('Số km không đúng định dạng.'),
            'city.required' => __('Thành phố không để trống.'),
            'city_search_name.required' => __('Thành phố tìm trong google không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);


        //kiểm tra xem services_detail_id này đã có giá chưa
        // $check_service = CfFeeCity::firstWhere('service_detail_id', $fee["service_detail_id"]);
        // if(! empty($check_service) )
        // {
        // return redirect()->route('price.admin.citycreate')->with('error', __('Dịch vụ đã có cài đặt giá trước đó.'));
        // }
        $user = CfFeeCity::create($fee);

        if ($user) {
            return redirect()->route('price.admin.city')->with('success', __('Thêm thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    public function admin_citydelete($id)
    {
        $CfFee = CfFeeCity::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_cityedit($id)
    {
        $page_title = __('Cập nhật giá theo Tỉnh/Thành Phố');
        $CfFee = CfFeeCity::findorFail($id);
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.cityedit', compact('CfFee', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_cityupdate(Request $request, $id)
    {
        $fee["ratio"] = $request->input('ratio');
        $fee["city"] = $request->input('city');
        $fee["city_search_name"] = $request->input('city_search_name');

        $validation = [
            'ratio' => 'required',
            'service_detail_id' => 'required',
            'city' => 'required',
            'city_search_name' => 'required',
        ];

        $validationMsg = [
            'ratio.required' => __('Tỷ lệ không để trống.'),
            'service_detail_id.required' => __('Số km không đúng định dạng.'),
            'city.required' => __('Thành phố không để trống.'),
            'city_search_name.required' => __('Thành phố tìm trong google không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);
        $CfFee = CfFeeCity::findorFail($id);
        $CfFee_r = $CfFee->fill($fee)->save();
        if ($CfFee_r) {
            return redirect()->route('price.admin.city')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_time(Request $request)
    {
        $page_title = __('Danh sách tiền theo thời gian');
        $resultQuery = CfFeeTime::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('service_detail_id', '=', $request->input('service_detail_id'));
            }

        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('cf_services_detail', 'cf_fee_time.service_detail_id', '=', 'cf_services_detail.id');
        $resultQuery->orderBy('cf_fee_time.' . $sortBy, $direction);

        $resultQuery->select('*', 'cf_fee_time.id as fee_id');
        $Prices = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $CfIndexArr = CfIndexTime::pluck('index', 'id')->toArray();
        $day[0] = 'Tất cả';
        $day[1] = 'T2';
        $day[2] = 'T2';
        $day[3] = 'T3';
        $day[4] = 'T4';
        $day[5] = 'T5';
        $day[6] = 'T6';
        $day[7] = 'T7';
        $day[8] = 'CN';
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.time', compact('Prices', 'ServicesArr', 'ServicesTypeArr', 'CfIndexArr', 'ServicesDetailArr', 'day', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_timecreate()
    {
        $page_title = __('Tạo giá theo thời gian');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();
        $CfIndexTime = CfIndexTime::get();
        return view('admin.price.timecreate', compact('ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'CfIndexTime', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_timestore(Request $request)
    {


        $fee["date_from"] = $request->input('date_from');
        $fee["date_to"] = $request->input('date_to');
        $fee["time_from"] = $request->input('time_from');
        $fee["time_to"] = $request->input('time_to');
        $fee["service_detail_id"] = $request->input('service_detail_id');
        $fee["time_type"] = $request->input('time_type');
        $fee["index_fee_id"] = $request->input('index_fee_id');
        $fee["day_of_week"] = $request->input('day_of_week');
        $fee["priority"] = $request->input('priority');
        $fee["fee_type"] = $request->input('fee_type');
        $fee["fee"] = $request->input('fee');


        $validation = [
            'date_from' => 'required',
            'date_to' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'service_detail_id' => 'required',
            'time_type' => 'required',
            'index_fee_id' => 'required',
            'day_of_week' => 'required',
            'priority' => 'required',
            'fee_type' => 'required',
            'fee' => 'required',
        ];

        $validationMsg = [
            'date_from.required' => __('Không để trống.'),
            'date_to.required' => __('Không để trống.'),
            'time_from.required' => __('Không để trống.'),
            'time_to.required' => __('Không để trống.'),
            'service_detail_id.required' => __('Không để trống.'),
            'time_type.required' => __('Không để trống.'),
            'index_fee_id.required' => __('Không để trống.'),
            'day_of_week.required' => __('Không để trống.'),
            'priority.required' => __('Không để trống.'),
            'fee_type.required' => __('Không để trống.'),
            'fee.required' => __('Không để trống.'),


        ];
        $this->validate($request, $validation, $validationMsg);


        $user = CfFeeTime::create($fee);

        if ($user) {
            return redirect()->route('price.admin.time')->with('success', __('Thêm thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    public function admin_timedelete($id)
    {
        $CfFee = CfFeeTime::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_timeedit($id)
    {
        $page_title = __('Cập nhật giá theo thời gian');
        $CfFee = CfFeeTime::findorFail($id);
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();
        $CfIndexTime = CfIndexTime::get();
        return view('admin.price.timeedit', compact('CfFee', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'CfIndexTime', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_timeupdate(Request $request, $id)
    {
        $fee["date_from"] = $request->input('date_from');
        $fee["date_to"] = $request->input('date_to');
        $fee["time_from"] = $request->input('time_from');
        $fee["time_to"] = $request->input('time_to');
        $fee["time_type"] = $request->input('time_type');
        $fee["index_fee_id"] = $request->input('index_fee_id');
        $fee["day_of_week"] = $request->input('day_of_week');
        $fee["priority"] = $request->input('priority');
        $fee["fee_type"] = $request->input('fee_type');
        $fee["fee"] = $request->input('fee');


        $validation = [
            'date_from' => 'required',
            'date_to' => 'required',
            'time_from' => 'required',
            'time_to' => 'required',
            'time_type' => 'required',
            'index_fee_id' => 'required',
            'day_of_week' => 'required',
            'priority' => 'required',
            'fee_type' => 'required',
            'fee' => 'required',
        ];
        $validationMsg = [
            'date_from.required' => __('Không để trống.'),
            'date_to.required' => __('Không để trống.'),
            'time_from.required' => __('Không để trống.'),
            'time_to.required' => __('Không để trống.'),
            'time_type.required' => __('Không để trống.'),
            'index_fee_id.required' => __('Không để trống.'),
            'day_of_week.required' => __('Không để trống.'),
            'priority.required' => __('Không để trống.'),
            'fee_type.required' => __('Không để trống.'),
            'fee.required' => __('Không để trống.'),


        ];
        $this->validate($request, $validation, $validationMsg);
        $CfFee = CfFeeTime::findorFail($id);
        $CfFee_r = $CfFee->fill($fee)->save();
        if ($CfFee_r) {
            return redirect()->route('price.admin.time')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_cache(Request $request)
    {

        $page_title = __('Cập nhật Cache');
        $body = [
            "cmd" =>"doReloadConfig",
            "data" => ""
        ];

        $urlReloadService = env("URL_API_USER") . "ButlAppServlet/app/services";
        $urlReloadConfig = env("URL_API_SOCKET") . "api/v1/web/reloadConfig";

        $response = Http::post($urlReloadService, $body)->json();
        $response2 = Http::get($urlReloadConfig)->json();

//        dd($response, $response2);

        return view('admin.price.cache', compact('page_title', 'response', 'response2'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_service(Request $request)
    {
        $page_title = __('Danh sách dịch vụ cha');
        $resultQuery = CfServiceMain::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('service_detail_id', '=', $request->input('service_detail_id'));
            }

        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->orderBy('cf_service_main.' . $sortBy, $direction);
        $resultQuery->select('*', 'id as id');
        $Services = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.price.service', compact('Services', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_serviceedit($id)
    {
        $page_title = __('Cập nhật dịch vụ cha');
        $Services = CfServiceMain::findorFail($id);
        return view('admin.price.serviceedit', compact('Services', 'page_title'));
    }

    public function admin_serviceupdate(Request $request, $id)
    {
        $service["name"] = $request->input('name');
        $service["is_show"] = 1;
        $service["is_active"] = $request->input('is_active');
        $service["is_ready"] = $request->input('is_ready');
        $service["is_show_home"] = $request->input('is_show_home');

        $validation = [
            'name' => 'required',
        ];
        $validationMsg = [
            'name.required' => __('Không để trống.'),
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
                    if ($blog_meta["title"] == 'image') {
                        $service["image"] = $appUrl . 'admin/public/storage/driver/' . $blog_meta["value"];
                    }
                }


            }

        }


        $CfServiceMain = CfServiceMain::findorFail($id);
        $CfServiceMain_r = $CfServiceMain->fill($service)->save();
        if ($CfServiceMain_r) {
            return redirect()->route('price.admin.service')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_servicesub(Request $request)
    {
        $page_title = __('Danh sách dịch vụ con');
        $resultQuery = CfServiceType::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('service_detail_id', '=', $request->input('service_detail_id'));
            }

        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $resultQuery->orderBy('cf_services_type.' . $sortBy, $direction);

        $sortWith = $request->get('with') ? $request->get('with') : Null;

        $resultQuery->select('*', 'id as id');
        $Services = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.price.servicesub', compact('Services', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_servicesubedit($id)
    {
        $page_title = __('Cập nhật dịch vụ con');
        $Services = CfServiceType::findorFail($id);
        return view('admin.price.servicesubedit', compact('Services', 'page_title'));
    }

    public function admin_servicesubupdate(Request $request, $id)
    {
        $service["name"] = $request->input('name');
        $service["is_show"] = $request->input('is_show');
        $service["is_active"] = $request->input('is_active');
        $service["policy_content"] = $request->input('policy_content');

        $validation = [
            'name' => 'required',
            'is_show' => 'required',
            'is_active' => 'required',
//            'policy_content' => 'required',
        ];
        $validationMsg = [
            'name.required' => __('Không để trống.'),
            'is_show.required' => __('Không để trống.'),
            'is_active.required' => __('Không để trống.'),
//            'policy_content.required' => __('Không để trống.'),
        ];
        $this->validate($request, $validation, $validationMsg);
        $CfServiceMain = CfServiceType::findorFail($id);
        $CfServiceMain_r = $CfServiceMain->fill($service)->save();
        if ($CfServiceMain_r) {
            return redirect()->route('price.admin.servicesub')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_ext(Request $request)
    {
        $page_title = __('Danh sách tiền theo bảo hiểm/dịch vụ');
        $resultQuery = CfFeeExt::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('service_detail_id', '=', $request->input('service_detail_id'));
            }

        }

        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $resultQuery->orderBy('cf_service_cost.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('cf_services_detail', 'service_detail_id', '=', 'cf_services_detail.id');
        $resultQuery->select('*', 'cf_service_cost.id as fee_id');
        $Prices = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();
        return view('admin.price.ext', compact('Prices', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_extcreate()
    {
        $page_title = __('Tạo giá Bảo Hiểm/Dịch Vụ');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.extcreate', compact('ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_extstore(Request $request)
    {
        $fee["fee_fixed"] = $request->input('fee_fixed');
        $fee["service_detail_id"] = $request->input('service_detail_id');

        $validation = [
            'fee_fixed' => 'required|regex:/^[0-9]+$/',
            'service_detail_id' => 'required',

        ];

        $validationMsg = [
            'fee_fixed.required' => __('Tỷ lệ không để trống.'),
            'fee_fixed.regex' => __('Không đúng định dạng.'),
            'service_detail_id.required' => __('Dịch vụ không đúng định dạng.'),


        ];
        $this->validate($request, $validation, $validationMsg);


        //kiểm tra xem services_detail_id này đã có giá chưa
        $check_service = CfFeeExt::firstWhere('service_detail_id', $fee["service_detail_id"]);
        if (!empty($check_service)) {
            return redirect()->route('price.admin.extcreate')->with('error', __('Dịch vụ đã có cài đặt giá trước đó.'));
        }
        $user = CfFeeExt::create($fee);

        if ($user) {
            return redirect()->route('price.admin.ext')->with('success', __('Tạo thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    public function admin_extdelete($id)
    {
        $CfFee = CfFeeExt::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_extedit($id)
    {
        $page_title = __('Cập nhật giá theo bảo hiểm/dịch vụ');
        $CfFee = CfFeeExt::findorFail($id);
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.extedit', compact('CfFee', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_extupdate(Request $request, $id)
    {

        $fee["fee_fixed"] = $request->input('fee_fixed');

        $validation = [
            'fee_fixed' => 'required|regex:/^[0-9]+$/',


        ];

        $validationMsg = [
            'fee_fixed.required' => __('Tỷ lệ không để trống.'),
            'fee_fixed.regex' => __('Không đúng định dạng.'),
        ];
        $this->validate($request, $validation, $validationMsg);

        $CfFee = CfFeeExt::findorFail($id);
        $CfFee_r = $CfFee->fill($fee)->save();
        if ($CfFee_r) {
            return redirect()->route('price.admin.ext')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_group(Request $request)
    {
        $page_title = __('Danh sách nhóm');
        $resultQuery = CfServiceGroup::query();
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->select('*', 'id as id');
        $Services = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.price.group', compact('Services', 'page_title'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_groupedit($id)
    {
        $page_title = __('Cập nhật nhóm');
        $Services = CfServiceGroup::findorFail($id);
        return view('admin.price.groupedit', compact('Services', 'page_title'));
    }

    public function admin_groupupdate(Request $request, $id)
    {
        $service["name"] = $request->input('name');
        $service["is_active"] = $request->input('is_active');


        $validation = [
            'name' => 'required',

        ];
        $validationMsg = [
            'name.required' => __('Không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);
        $CfServiceMain = CfServiceGroup::findorFail($id);
        $CfServiceMain_r = $CfServiceMain->fill($service)->save();
        if ($CfServiceMain_r) {
            return redirect()->route('price.admin.group')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_gservice(Request $request)
    {
        $page_title = __('Danh sách nhóm - dịch vụ');
        $resultQuery = CfServiceGroupService::query();
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('cf_service_main', 'service_id', '=', 'cf_service_main.id');
        $resultQuery->join('cf_service_group', 'group_id', '=', 'cf_service_group.id');
        $resultQuery->select('cf_services_group_detail.*', 'cf_service_main.name as name1', 'cf_service_group.name as name2');
        $Services = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.price.gservice', compact('Services', 'page_title'));
    }

    public function admin_gservicedelete($id)
    {
        $CfFee = CfServiceGroupService::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_gservicecreate()
    {
        $page_title = __('Tạo giá Bảo Hiểm/Dịch Vụ');
        $ServicesArr = CfServiceMain::get();
        $ServicesGrouplArr = CfServiceGroup::get();

        return view('admin.price.gservicecreate', compact('ServicesArr', 'ServicesGrouplArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_gservicestore(Request $request)
    {
        $fee["group_id"] = $request->input('group_id');
        $fee["service_id"] = $request->input('service_id');
        $fee["status"] = 1;

        $user = CfServiceGroupService::create($fee);

        if ($user) {
            return redirect()->route('price.admin.gservice')->with('success', __('Tạo thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_detailservice(Request $request)
    {
        $page_title = __('Danh sách Dich Vụ Cha => Con');
        $resultQuery = CfServiceDetail::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_id')) {
                $resultQuery->where('service_id', '=', $request->input('service_id'));
            }

        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->orderBy('cf_services_detail.' . $sortBy, $direction);

        $Prices = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailSer = CfServiceMain::get();

        return view('admin.price.detailservice', compact('Prices', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailSer', 'page_title'));

    }

    public function admin_detailservicstatuseedit(Request $request, $id)
    {

        $CfServicedetail = CfServiceDetail::findorFail($id);
        if ($CfServicedetail->whole_km == 1) {
            $dedetai["whole_km"] = 2;
        } else {
            $dedetai["whole_km"] = 1;

        }
        $CfServiceMain_r = $CfServicedetail->fill($dedetai)->save();

        if ($CfServiceMain_r) {
            return redirect()->back()->with('success', __('Chỉnh sửa thành công.'));

            //  return redirect()->route('price.admin.detailservice')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }
    }

    public function admin_sdetailserviceedit(Request $request, $id)
    {

        $CfServicedetail = CfServiceDetail::findorFail($id);
        if ($CfServicedetail->status == 1) {
            $dedetai["status"] = 0;
        } else {
            $dedetai["status"] = 1;

        }
        $CfServiceMain_r = $CfServicedetail->fill($dedetai)->save();

        if ($CfServiceMain_r) {
            return redirect()->back()->with('success', __('Chỉnh sửa thành công.'));

            //  return redirect()->route('price.admin.detailservice')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_option(Request $request)
    {
        $page_title = __('Danh sách dịch vụ riêng');
        $resultQuery = CfServicesOptionDetail::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('cf_services_option_detail.service_type', '=', $request->input('service_detail_id'));
            }

        }

        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('cf_services_sub', 'cf_services_option_detail.service_option', '=', 'cf_services_sub.id');
        $resultQuery->join('cf_services_detail', 'cf_services_option_detail.service_type', '=', 'cf_services_detail.id');
        $resultQuery->select('cf_services_option_detail.*', 'cf_services_detail.service_id as service_id', 'cf_services_sub.name as name', 'cf_services_sub.cost as cost');
        $resultQuery->orderBy('cf_services_option_detail.' . $sortBy, $direction);

        $Prices = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.option', compact('Prices', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));


    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_optioncreate()
    {
        $page_title = __('Tạo dịch vụ riêng');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.optioncreate', compact('ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_optionstore(Request $request)
    {
        $CFServicesSub["cost"] = $request->input('cost');
        $CfServicesOptionDetail["service_type"] = $request->input('service_detail_id');
        $CFServicesSub["name"] = $request->input('name');

        $validation = [
            'cost' => 'required',
            'service_detail_id' => 'required',
            'name' => 'required',
        ];
        $validationMsg = [
            'cost.required' => __('Tỷ lệ không để trống.'),
            'service_detail_id.required' => __('Dịch vu không đúng định dạng.'),
            'name.required' => __('Tên không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);

        $CfServicesOptionDetail["status"] = $request->input('status');
        $CFServicesSub["type"] = 1;
        $user = CFServicesSub::create($CFServicesSub);
        if ($user) {
            $CfServicesOptionDetail["service_option"] = $user->id;
            CfServicesOptionDetail::create($CfServicesOptionDetail);
            return redirect()->route('price.admin.option')->with('success', __('Thêm thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }


    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_optionedit($id)
    {
        $page_title = __('Cập nhật dịch vụ');
        $CfServicesOptionDetail = CfServicesOptionDetail::findorFail($id);
        $CFServicesSub = CFServicesSub::findorFail($CfServicesOptionDetail->service_option);


        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();

        return view('admin.price.optionedit', compact('CfServicesOptionDetail', 'CFServicesSub', 'ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_optionupdate(Request $request, $id)
    {
        $CFServicesSub["cost"] = $request->input('cost');
        $CfServicesOptionDetail["service_type"] = $request->input('service_detail_id');
        $CFServicesSub["name"] = $request->input('name');

        $validation = [
            'cost' => 'required',
            'service_detail_id' => 'required',
            'name' => 'required',
        ];
        $validationMsg = [
            'cost.required' => __('Tỷ lệ không để trống.'),
            'service_detail_id.required' => __('Dịch vu không đúng định dạng.'),
            'name.required' => __('Tên không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);

        $CfServicesOptionDetail["status"] = $request->input('status');
        $CFServicesSub["type"] = 1;

        $OptionDetail = CfServicesOptionDetail::findorFail($id);
        $OptionDetail_r = $OptionDetail->fill($CfServicesOptionDetail)->save();
        if ($OptionDetail_r) {
            $CFServicesSub_d = CFServicesSub::findorFail($OptionDetail->service_option);
            $CFServicesSub_r = $CFServicesSub_d->fill($CFServicesSub)->save();
            return redirect()->route('price.admin.option')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_agencyservice(Request $request)
    {
        $page_title = __('Cài đặt dv cho nhóm');
        $resultQuery = CfServicesDetailAgency::query();


        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('agency_id')) {
                $resultQuery->where('agency_id', '=', $request->input('agency_id'));
            }

        }

        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->select('cf_services_detail_agency.id', 'service_id', 'service_type', 'name');
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'cf_services_detail_agency.service_detail_id');
        $resultQuery->join('agency', 'agency.id', '=', 'cf_services_detail_agency.agency_id');
        $Services = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $AgencyArr = Agency::get();
        return view('admin.price.serviceagency', compact('Services', 'ServicesArr', 'AgencyArr', 'ServicesTypeArr', 'page_title'));
    }

    public function admin_agencyservicedel($id)
    {
        $CfFee = CfServicesDetailAgency::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    public function admin_agencyservicecreate()
    {
        $page_title = __('Cài đặt dv cho nhóm');

        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();
        $Agency = Agency::get();


        return view('admin.price.agencyservicecreate', compact('ServicesDetailArr', 'Agency', 'ServicesArr', 'ServicesTypeArr', 'page_title'));
    }

    public function admin_agencyservicestore(Request $request)
    {
        $CfServicesDetail["agency_id"] = $request->input('agency_id');
        $validation = [
            'agency_id' => 'required',
        ];
        $validationMsg = [
            'agency_id.required' => __('Không để trống.'),
        ];
        $this->validate($request, $validation, $validationMsg);
        $add_user = null;
        if (isset($_POST['checkboxvar'])) {
            $service_detail_id_a = $_POST['checkboxvar'];
            for ($i = 0; $i < count($service_detail_id_a); $i++) {
                $service_detail_id = $service_detail_id_a[$i];
                if ($service_detail_id > 0) {
                    $check = CfServicesDetailAgency::
                    where('agency_id', '=', $CfServicesDetail["agency_id"])
                        ->where('service_detail_id', '=', $service_detail_id)->get()->toArray();

                    if (!isset($check[0]['id'])) {
                        $CfServicesDetail["service_detail_id"] = $service_detail_id;
                        $add_user = CfServicesDetailAgency::create($CfServicesDetail);
                    }
                }
            }
        }
        return redirect()->route('price.admin.agencyservice')->with('success', __('Thêm thành công'));

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function admin_cityservice(Request $request)
    {
        $page_title = __('Danh sách mở theo Tỉnh/Thành Phố');
        $resultQuery = CfCityServiceDetail::query();
        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            if ($request->filled('service_detail_id')) {
                $resultQuery->where('service_detail_id', '=', $request->input('service_detail_id'));
            }

        }
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $sortWith = $request->get('with') ? $request->get('with') : Null;
        $resultQuery->join('agency', 'agency.id', '=', 'cf_city_service_detail.agency_id');
        $resultQuery->select('*', 'cf_city_service_detail.id as fee_id', 'agency.name as agency_name');
        $resultQuery->orderBy('fee_id', $direction);

        $Prices = $resultQuery->paginate(config('Reading.nodes_per_page'));
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceMain::get();

        return view('admin.price.cityservice', compact('Prices', 'ServicesDetailArr', 'ServicesArr', 'page_title'));


    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_cityservicecreate()
    {
        $page_title = __('Tạo chặn theo Tỉnh/Thành Phố');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceMain::orderBy('id', 'ASC')->get();
        $AgencyArr = Agency::get();
        return view('admin.price.cityservicecreate', compact('ServicesArr', 'ServicesTypeArr', 'ServicesDetailArr', 'AgencyArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_cityservicestore(Request $request)
    {
        //  $fee["service_detail_id"]           = $request->input('service_detail_id');
        $fee["city"] = $request->input('city');
        $fee["city_search_name"] = $request->input('city_search_name');
        $fee["agency_id"] = $request->input('agency_id');

        $validation = [
            'city' => 'required',
            'city_search_name' => 'required',
            'agency_id' => 'required',

        ];

        $validationMsg = [
            'city.required' => __('Thành phố không để trống.'),
            'city_search_name.required' => __('Thành phố tìm trong google không để trống.'),
            'agency_id.required' => __('Đại lý không để trống.'),


        ];
        $this->validate($request, $validation, $validationMsg);
        $user = null;
        if (isset($_POST['checkboxvar'])) {
            CfCityServiceDetail::where('agency_id', '=', $fee["agency_id"])->delete();
            $service_detail_id_a = $_POST['checkboxvar'];
            for ($i = 0; $i < count($service_detail_id_a); $i++) {
                $service_detail_id = $service_detail_id_a[$i];
                if ($service_detail_id > 0) {
                    $fee["city"] = $request->input('city');
                    $fee["city_search_name"] = $request->input('city_search_name');
                    $fee["agency_id"] = $request->input('agency_id');
                    $fee["service_detail_id"] = $service_detail_id;
                    $user = CfCityServiceDetail::create($fee);
                }
            }

        }
        if ($user) {
            return redirect()->route('price.admin.cityservice')->with('success', __('Thêm thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }

    public function admin_cityserviceedel($id)
    {
        $CfFee = CfCityServiceDetail::findorFail($id);
        if ($CfFee->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_cityserviceedit($id)
    {
        $page_title = __('Cập nhật chặn DV Tỉnh/Thành Phố');
        $CfFee = CfCityServiceDetail::findorFail($id);
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceMain::orderBy('id', 'ASC')->get();
        $AgencyArr = Agency::get();

        $service_active = CfCityServiceDetail::
        where("agency_id", '=', $CfFee->agency_id)->pluck('city', 'service_detail_id')->toArray();


        return view('admin.price.cityserviceedit', compact('CfFee', 'ServicesArr', 'service_active', 'AgencyArr', 'ServicesTypeArr', 'ServicesDetailArr', 'page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function admin_cityserviceupdate(Request $request, $id)
    {
        $fee["city"] = $request->input('city');
        $fee["city_search_name"] = $request->input('city_search_name');
        $fee["agency_id"] = $request->input('agency_id');
        $validation = [
            'service_detail_id' => 'required',
            'city' => 'required',
            'city_search_name' => 'required',
            'agency_id' => 'required',

        ];

        $validationMsg = [
            'city.required' => __('Thành phố không để trống.'),
            'city_search_name.required' => __('Thành phố tìm trong google không để trống.'),
            'agency_id.required' => __('Đại lý không để trống.'),
        ];
        if (isset($_POST['checkboxvar'])) {
            CfCityServiceDetail::where('agency_id', '=', $fee["agency_id"])->delete();
            $service_detail_id_a = $_POST['checkboxvar'];
            for ($i = 0; $i < count($service_detail_id_a); $i++) {
                $service_detail_id = $service_detail_id_a[$i];
                if ($service_detail_id > 0) {
                    $fee["city"] = $request->input('city');
                    $fee["city_search_name"] = $request->input('city_search_name');
                    $fee["agency_id"] = $request->input('agency_id');
                    $fee["service_detail_id"] = $service_detail_id;
                    $user = CfCityServiceDetail::create($fee);
                }
            }
        } else {
            if ($fee["agency_id"] > 0) {
                CfCityServiceDetail::where('agency_id', '=', $fee["agency_id"])->delete();
                $user = 1;
            }
        }
        if ($user) {
            return redirect()->route('price.admin.cityservice')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }

    }
}
