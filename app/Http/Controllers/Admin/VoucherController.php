<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\UserB;
use App\Models\Voucher;
use App\Models\CfServiceMain;
use App\Models\CfServiceType;
use App\Models\CfServiceDetail;
use App\Models\VoucherCondition;
use App\Models\VoucherUsed;

use Maatwebsite\Excel\Facades\Excel\WithHeadings;
use Maatwebsite\Excel\Facades\Excel\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Exports\ExportVoucher;

use Spatie\Permission\Models\Role;
use App\Models\Role as UserRole;
use Auth;
use Jenssegers\Agent\Agent;
use Storage;

class VoucherController extends Controller
{

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = __('Danh sách khuyến mại');
        $resultQuery = Voucher::query();

        if($request->filled('discount_code')) {
            $resultQuery->where('discount_code', 'like', "%{$request->input('discount_code')}%");
        }

        if($request->filled('title')) {
            $resultQuery->where('title', '=', $request->input('title'));
        }


        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $resultQuery->join('cf_services_detail', 'services_detail_id', '=', 'cf_services_detail.id');
        $resultQuery->select('t_discount.*','cf_services_detail.service_id','cf_services_detail.service_type');
        $ServicesArr        = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr    = CfServiceType::pluck('name', 'id')->toArray();

        if($request->input('excel')=="Excel")
        {
            $response = Excel::download(new ExportVoucher($request), 'dskhuyenmai.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            ob_end_clean();
            return $response;
        }



        $vouchers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.voucher.index', compact('vouchers','ServicesArr','ServicesTypeArr','page_title'));
    }
    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = __('Tạo khuyến mại');
        $ServicesArr        = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr    = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr    = CfServiceDetail::get();

        return view('admin.voucher.create', compact('ServicesArr','ServicesTypeArr','ServicesDetailArr','page_title'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function store(Request $request)
    {

        $validation = [
            'services_detail_id'           => 'required',
            'discount_code'      => 'required|regex:/^[a-zA-Z0-9]+$/',
            'discount_type'           => 'required',
            'discount_value'           => 'required',
            'start_date'           => 'required',
            'end_time'           =>  'required',
            'times_of_uses'      => 'required|regex:/^[0-9]+$/',
            'title'             => 'required',
            'description'           => 'required',
            'condition_content'           => 'required',

        ];
        $validationMsg = [
            'services_detail_id.required'      => __('Không để trống.'),
            'discount_code.required'            => __('Không để trống.'),
            'discount_code.regex'            => __('Sai định dạng.'),
            'discount_type.required'            => __('Không để trống.'),
            'discount_value.required'            => __('Không để trống.'),
            'start_date.required'       => __('Không để trống.'),
            'end_time.required'      => __('Không để trống.'),
            'times_of_uses.required'      => __('Không để trống.'),
            'times_of_uses.regex'      => __('Sai định dạng.'),
            'title.required'      => __('Không để trống.'),
            'description.required'      => __('Không để trống.'),
            'condition_content.required'      => __('Không để trống.'),

        ];
        $this->validate($request, $validation, $validationMsg);

        $vcher["services_detail_id"]           = $request->input('services_detail_id');
        $vcher["discount_code"]                = $request->input('discount_code');
        $vcher["discount_type"]                = $request->input('discount_type');
        $vcher["discount_value"]               = $request->input('discount_value');
        $vcher["start_date"]                   = $request->input('start_date');
        $vcher["end_time"]                     = $request->input('end_time');
        $vcher["times_of_uses"]                = $request->input('times_of_uses');
        $vcher["times_of_used"]                = 1;
        $vcher["title"]                        = $request->input('title');
        $vcher["description"]                  = $request->input('description');
        $vcher["status"]                       = $request->input('status');
        $vcher["create_date"]                  = $request->input('start_date');

        $condition_id           = $request->input('condition_id');
        $condition_content      = $request->input('condition_content');
        $quanlity               = $request->input('quanlity');
        $refix  =$vcher["discount_code"];
        if($quanlity>=1)
        {
            for($i=0;$i<$quanlity;$i++)
            {
                $string_s ='';
                $string_s                   =    $this->generateRandomString(4);
                $vcher["discount_code"]     =    $refix.$string_s;
                $check_code     = Voucher::firstWhere('discount_code',  $vcher["discount_code"] );
                if(!isset($check_code["id"]))
                {
                    if($condition_id ==1)// theo city
                    {
                        $vcher_condition["services_detail_id"]      =    $vcher["services_detail_id"];
                        $vcher_condition["user_taget_type"]         =    $condition_id ;
                        $vcher_condition["user_data_id"]            =   0;
                        $vcher_condition["city_name"]               =       $condition_content ;
                        $vcher_condition["number_of_uses"]          =   0;
                    }
                    elseif($condition_id ==2) // theo chỉ định sdt
                    {
                        $check_phone = UserB::firstWhere('phone',  $condition_content);
                        $vcher_condition["services_detail_id"]      =    $vcher["services_detail_id"];
                        $vcher_condition["user_taget_type"]         =    $condition_id ;
                        $vcher_condition["user_data_id"]            =    $check_phone["id"];
                        $vcher_condition["city_name"]               =      "" ;
                        $vcher_condition["number_of_uses"]          =   0;
                    }
                    elseif($condition_id==3) // theo số lần dùng dv
                    {
                        $vcher_condition["services_detail_id"]      =    $vcher["services_detail_id"];
                        $vcher_condition["user_taget_type"]         =    $condition_id ;
                        $vcher_condition["user_data_id"]            =    0;
                        $vcher_condition["city_name"]               =    "" ;
                        $vcher_condition["number_of_uses"]          =    $condition_content;
                    }
                    $voucher_r = Voucher::create($vcher);
                    if( $voucher_r["id"]>0)
                    {
                        $vcher_condition["discount_id"] = $voucher_r["id"];
                        $voucher_c  =  VoucherCondition::create($vcher_condition);
                    }
                }
            }
        }
        if($voucher_r)
        {
            return redirect()->route('admin.voucher.index')->with('success', __('Tạo thành công mã'));
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
        $page_title = __('Cập nhật trạng thái thành công');
        $voucher = Voucher::findorFail($id);
        $vcher["status"]   = 0;
        $voucher->fill($vcher)->save();
        return redirect()->route('admin.voucher.index')->with('success', __('Cập nhật trạng thái thành công'));
    }


    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function listused(Request $request)
    {
        $page_title = __('Danh sách khách hàng dùng khuyến mại');
        $resultQuery = VoucherUsed::query();

        if($request->filled('discount_code')) {
            $resultQuery->where('discount_code', 'like', "%{$request->input('discount_code')}%");
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 't_discount_used.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $resultQuery->join('go_info', 'go_info_id', '=', 'go_info.id');
        $resultQuery->join('user_driver_data', 'user_driver_data.id', '=', 'go_info.driver_id');
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_info.user_id');
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'go_info.service_detail_id');
        $ServicesArr        = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr    = CfServiceType::pluck('name', 'id')->toArray();
        $resultQuery->select('*','user_driver_data.name as driver_name',
        'user_driver_data.phone as driver_phone',
        'user_data.name as user_name09',
        'user_data.phone as user_phone09');
        $vouchers = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.voucher.listused', compact('vouchers','ServicesArr','ServicesTypeArr','page_title'));
    }

}
