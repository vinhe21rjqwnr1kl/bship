<?php

namespace App\Exports;

use App\Models\LogAddMoneyRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPaymentRequest implements FromCollection, WithHeadings
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {

        $request = $this->request;
        $resultQuery = LogAddMoneyRequest::query();

        if ($request->phone) {
            $resultQuery->where('log_add_money_request.phone', 'like', "%{$request->phone}%");
        }
        if ($request->name) {
            $resultQuery->where('log_add_money_request.name', 'like', "%{$request->name}%");
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->select('log_add_money_request.id',
            'log_add_money_request.user_name as driver_name',
            'log_add_money_request.user_phone as driver_phone',
            DB::raw('IF(log_add_money_request.money = 0, "0", log_add_money_request.money) as log_money'),
            'log_add_money_request.type',
            'log_add_money_request.reason',
            'log_add_money_request.create_name',
            'log_add_money_request.create_date',
            DB::raw('IF(log_add_money_request.status = 0, "Chưa duyệt", IF(log_add_money_request.status = 1, "Đã duyệt", "Xóa"))')
        );
        $resultQuery->orderBy($sortBy, $direction);

        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('log_add_money_request.agency_id', '=', $driveData["agency_id"]);
        }

        return $resultQuery->get();
    }

    public function headings(): array
    {
        return ["Mã nạp tiền", "Tên TX", "SĐT TX", "Tiền", "Loại", "Thông tin", "Người tạo", "Thời gian", "Trạng Thái"];
    }

}
