<?php

namespace App\Exports;

use App\Models\Voucher;
use App\Models\VoucherUsed;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;


class ExportVoucherUsed implements FromCollection, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
        // $this->service_id   = $service_id;
    }

    public function collection()
    {

        $request = $this->request;
        // $service_id = $this->service_id  ;


        $resultQuery = VoucherUsed::query();

            if ($request->filled('discount_code')) {
                $resultQuery->where('discount_code', 'like', "%{$request->input('discount_code')}%");
            }

            if ($request->filled('title')) {
                $resultQuery->where('title', '=', $request->input('title'));
            }

        $sortBy = $request->get('sort') ? $request->get('sort') : 't_discount_used.create_date';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);

        $resultQuery->join('go_info', 'go_info_id', '=', 'go_info.id');
        $resultQuery->join('user_driver_data', 'user_driver_data.id', '=', 'go_info.driver_id');
        $resultQuery->join('user_data', 'user_data.id', '=', 'go_info.user_id');
        $resultQuery->join('cf_services_detail', 'cf_services_detail.id', '=', 'go_info.service_detail_id');

//        $resultQuery->leftJoin('cf_services_detail', 't_discount.services_detail_id', '=', 'cf_services_detail.id')
        $resultQuery->join('cf_service_main', 'cf_services_detail.service_id', '=', 'cf_service_main.id');
        $resultQuery->join('cf_services_type', 'cf_services_detail.service_type', '=', 'cf_services_type.id');

        //  $resultQuery->join('cf_services_detail', 'services_detail_id', '=', 'cf_services_detail.id');
        //  $resultQuery->select('t_discount.*','cf_services_detail.service_id','cf_services_detail.service_type');
        //        $resultQuery->leftjoin('t_discount_used', 't_discount.discount_code', '=', 't_discount_used.discount_code');
        $resultQuery->select('t_discount_used.discount_code',
            'cf_services_type.name as service_type_name',
            'cf_service_main.name as service_name',
            't_discount_used.create_date',
            'cf_service_main.name as service_name',
            'user_data.name as user_name',
            'user_data.phone as user_phone',
            'user_driver_data.name as driver_name',
            'user_driver_data.phone as driver_phone',
            );
        //        DB::raw('if(t_discount_used.status=1, "Đã dùng", "Chưa dùng")'));
        return $resultQuery->get();
    }

    public function headings(): array
    {
//        return ["Mã khuyến mãi",  "Tiêu đề", "Giá trị", "Trạng thái",  "Ngày bắt đầu", "Ngày kết thúc", "Ngày tạo", "Trạng thái sử dụng" ];
        return ["Mã khuyến mãi", "Loại", "Dịch vụ", "Ngày dùng", "Tên khách hàng", "SĐT khách hàng", "Tên tài xế", "SĐT tài xế"];

    }
}



