<?php

namespace App\Exports;

use App\Models\LogAddPointRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportPointRequest implements FromCollection, WithHeadings
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
        $resultQuery = LogAddPointRequest::query()
            ->with(['from_user', 'to_user'])
            ->join('user_data as from_user', 'log_add_point_request.from_user_id', '=', 'from_user.id', 'left')
            ->join('user_data as to_user', 'log_add_point_request.to_user_id', '=', 'to_user.id', 'left');

        if ($request->filled('from_user_data')) {
            $resultQuery->whereHas('from_user', function ($query) use ($request) {
                $query->where('name', $request->from_user_data)
                    ->orWhere('phone', $request->from_user_data);
            });
        }
        if ($request->filled('to_user_data')) {
            $resultQuery->whereHas('to_user', function ($query) use ($request) {
                $query->where('name', $request->to_user_data)
                    ->orWhere('phone', $request->to_user_data);
            });
        }

        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }

        $resultQuery->select(
            DB::raw('COALESCE(from_user.name, "ADMIN") as from_user_name'),
            DB::raw('COALESCE(from_user.phone, "ADMIN") as from_user_phone'),
            'to_user.name as to_user_name',
            'to_user.phone as to_user_phone',
            'log_add_point_request.point',
            'log_add_point_request.reason',
            'log_add_point_request.create_name',
            'log_add_point_request.create_date',
            DB::raw('IF(log_add_point_request.status = 0, "Chưa duyệt", IF(log_add_point_request.status = 1, "Đã duyệt", "Xóa"))')
        );

        $sortBy = $request->get('sort') ? $request->get('sort') : 'log_add_point_request.id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);

        return $resultQuery->get();
    }

    public function headings(): array
    {
        return ["Tên người gửi", "SĐT người gửi", "Tên người nhận", "SĐT người nhận", "Điểm", "Lý do", "Người tạo", "Thời gian", "Trạng Thái"];
    }

}
