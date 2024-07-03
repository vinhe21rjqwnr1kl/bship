<?php
namespace App\Exports;

use App\Models\Trip;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;


class ExportTrip implements FromCollection, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request, $service_id)
    {
        $this->request = $request;
        $this->service_id = $service_id;
    }

    public function collection()
    {

        $request = $this->request;
        $service_id = $this->service_id;
        $resultQuery = Trip::query();


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
        if ($request->filled('gsm_id')) {
            $resultQuery->where('go_info.order_id_gsm', 'like', "%{$request->input('gsm_id')}%");
        }
        if ($request->filled('datefrom')) {
            $resultQuery->where('go_info.create_date', '>=', "{$request->input('datefrom')}");
        }
        if ($request->filled('dateto')) {
            $resultQuery->where('go_info.create_date', '<', "{$request->input('dateto')}");
        }
        if ($request->filled('progress') && $request->input('progress') != 0) {
            $resultQuery->where('go_info.progress', 'like', "%{$request->input('progress')}%");
        }
        if ($request->filled('service_type') && $request->input('service_type') != 0) {
            $resultQuery->where('cf_services_detail.service_type', '=', $request->input('service_type'));
        }

        $tags = json_decode($request->input("tags"), true);
        if (!empty($tags)) {
            $resultQuery->where(function ($query) use ($tags) {
                foreach ($tags as $tag) {
                    $parts = explode(',', $tag);
                    $city = trim($parts[0]);
                    $district = isset($parts[1]) ? trim($parts[1]) : null;
                    $ward = isset($parts[2]) ? trim($parts[2]) : null;

                    // Kiểm tra nếu quận và phường được chỉ định
                    if ($district && $ward) {
                        $output = "$ward, $district, $city";
                        $query->orWhere('go_info.pickup_address', 'like', "%{$output}%");
                    } elseif ($district) {
                        // Nếu chỉ có quận được chỉ định
                        $query->orWhere('go_info.pickup_address', 'like', "%{$district}, {$city}%");
                    } else {
                        // Nếu chỉ có thành phố được chỉ định
                        $query->orWhere('go_info.pickup_address', 'like', "%{$city}%");
                    }
                }
            });
        }


        $resultQuery->join('user_driver_data', 'user_driver_data.id', '=', 'go_info.driver_id');
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_info.user_id');
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'go_info.service_detail_id');
        $resultQuery->join('cf_service_main', 'cf_service_main.id', '=', 'go_info.service_id');
        $resultQuery->join('cf_services_type', 'cf_services_detail.service_type', '=', 'cf_services_type.id');
        $resultQuery->join('cf_go_process', 'cf_go_process.id', '=', 'go_info.progress');
        $resultQuery->leftJoin('t_discount_used', 't_discount_used.go_info_id', '=', 'go_info.id');
        $resultQuery->leftJoin('log_add_money_request', 'go_info.id', '=', 'log_add_money_request.go_id');



        $resultQuery->select('go_info.id',
            'cf_service_main.name', 'cf_services_type.name as name10', 'cf_go_process.name as name12',
            'go_info.pickup_address', 'go_info.drop_address',
            DB::raw( 'go_info.distance/1000'),
            'go_info.cost',
            DB::raw('(driver_cost - service_cost) as total_dl'),
            DB::raw('(butl_cost + service_cost ) as total_tx'),
            'go_info.service_cost',
            't_discount_used.discount_code',
            'go_info.discount_from_code',
            DB::raw('if(go_info.payment_status="PAID", "Online", "Tiền mặt")'),
            'go_info.create_date as go_create_date',
            'user_driver_data.name as driver_name',
            'user_driver_data.phone as driver_phone',
            'user_data.name as user_name09',
            'user_data.phone as user_phone09',
            'go_info.order_id_gsm',
            DB::raw('if(go_info.go_request_id=1000, "Admin", "User")'),
            'go_info.created_by',
        );

        $resultQuery->orderBy('go_info.' . 'create_date', 'asc');
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('user_driver_data.agency_id', '=', $driveData["agency_id"]);
        }

        return $resultQuery->get();
    }

    public function headings(): array
    {
        return ["Mã Chuyến", "Loại", "Dịch vụ", "Trạng thái ", "Đi Từ", "Đến", "Kilomet", "Tổng tiền", "Tiền Đại lý",
            "Tiền Tài xế", "Tiền Bảo Hiểm", "Mã giảm giá", "Tiền Khuyến mãi", "Hình thức thanh toán", "Ngày tạo", "Tên Tx", "SĐT Tài xế",
            "Tên khách hàng", "SĐT khách hàng","Mã GSM", "Tạo bởi", "Người tạo"];
    }
}
