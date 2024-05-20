<?php

namespace App\Exports;

use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDriversList implements FromCollection, WithHeadings
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
        $resultQuery = Driver::query();

        if ($request->phone) {
            $resultQuery->where('user_driver_data.phone', 'like', "%{$request->phone}%");
        }
        if ($request->name) {
            $resultQuery->where('user_driver_data.name', 'like', "%{$request->name}%");
        }
        if ($request->is_active) {
            if ($request->is_active == 1) {
                $resultQuery->where('is_active', '=', 1);
            } else {
                $resultQuery->where('is_active', '!=', 1);
            }
        }
        $resultQuery->leftJoin('agency', 'user_driver_data.agency_id', '=', 'agency.id');
        $resultQuery->select('user_driver_data.id',
            'user_driver_data.name as driver_name',
            'user_driver_data.phone as driver_phone',
            DB::raw('IF(user_driver_data.money = 0, "0", user_driver_data.money) as driver_money'),
            DB::raw('COALESCE(agency.name, "Công ty BUTL") as agency_name'),
            DB::raw('IF(user_driver_data.is_active = 1, "Hoạt động", "Ngừng hoạt động") as active'),
            'user_driver_data.create_time'
        );
        $resultQuery->orderBy('user_driver_data.' . 'create_time', 'desc');

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
        return ["STT", "Tên", "SĐT", "Tiền", "Đại lý", "Trạng thái", "Thời gian"];
    }
}
