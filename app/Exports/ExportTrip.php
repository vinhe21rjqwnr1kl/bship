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

        if ($request->phone) {
            $resultQuery->where('user_data.phone', 'like', "%{$request->phone}%");
        }
        if ($request->name) {
            $resultQuery->where('user_data.name', 'like', "%{$request->name}%");
        }
        if ($request->datefrom) {
            $resultQuery->where('go_info.create_date', '>=', "{$request->datefrom}");
        }
        if ($request->dateto) {
            $resultQuery->where('go_info.create_date', '<', "{$request->dateto}");
        }
        if ($request->progress) {
            $resultQuery->where('go_info.progress', 'like', "%{$request->progress}%");
        }

        if ($service_id > 0) {
            $resultQuery->where('go_info.service_id', '=', $service_id);

        } else {
            $resultQuery->whereNotIn('go_info.service_id', [6, 8, 11, 12]);
        }

        $resultQuery->join('user_driver_data', 'user_driver_data.id', '=', 'go_info.driver_id');
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_info.user_id');
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'go_info.service_detail_id');
        $resultQuery->join('cf_service_main', 'cf_service_main.id', '=', 'go_info.service_id');
        $resultQuery->join('cf_services_type', 'cf_services_detail.service_type', '=', 'cf_services_type.id');
        $resultQuery->join('cf_go_process', 'cf_go_process.id', '=', 'go_info.progress');


        $resultQuery->select('go_info.id',
            'cf_service_main.name', 'cf_services_type.name as name10', 'cf_go_process.name as name12',
            'go_info.pickup_address', 'go_info.drop_address',
            DB::raw( 'go_info.distance/1000'),
            'go_info.cost',
            DB::raw('(driver_cost - service_cost) as total_dl'),
            DB::raw('(butl_cost + service_cost ) as total_tx'),
            'go_info.service_cost',
            'go_info.discount_from_code',
            DB::raw('if(go_info.payment_status="PAID", "Online", "Tiền mặt")'),
            'go_info.create_date as go_create_date',
            'user_driver_data.name as driver_name',
            'user_driver_data.phone as driver_phone',
            'user_data.name as user_name09',
            'user_data.phone as user_phone09',
            DB::raw('if(go_info.go_request_id=1000, "Admin", "User")')
        );

        $resultQuery->orderBy('go_info.' . 'create_date', 'desc');
        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }
        return $resultQuery->get();
    }

    public function headings(): array
    {
        return ["Mã Chuyến", "Loại", "Dịch vụ", "Trạng thái ", "Đi Từ", "Đến", "Kilomet", "Tổng tiền", "Tiền Đại lý",
            "Tiền Tài xế", "Tiền Bảo Hiểm", "Tiền Khuyến mãi", "Hình thức thanh toán", "Ngày tạo", "Tên Tx", "SĐT Tài xế",
            "Tên khách hàng", "SĐT khách hàng", "Tạo bởi"];
    }
}
