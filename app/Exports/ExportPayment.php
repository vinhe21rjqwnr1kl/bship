<?php
    namespace App\Exports;
    use App\Models\LogAddMoney;
    use Maatwebsite\Excel\Concerns\FromQuery;
    use Maatwebsite\Excel\Concerns\Exportable;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Illuminate\Support\Facades\DB;



    class ExportPayment implements FromCollection, WithHeadings
{
    use Exportable;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function collection()
    {

        $request = $this->request  ;


        $resultQuery            = LogAddMoney::query();

        if($request->phone) {
            $resultQuery->where('user_driver_data.phone', 'like', "%{$request->phone}%");
        }
        if($request->name) {
            $resultQuery->where('user_driver_data.name', 'like', "%{$request->name}%");
        }
        if($request->datefrom) {
            $resultQuery->where('time', '>=',$request->datefrom);
        }
        if($request->dateto) {
            $resultQuery->where('time', '<', $request->dateto);
        }
        $resultQuery->leftjoin('user_driver_data', 'user_driver_data.id', '=', 'user_id');
        $resultQuery->select('log_add_money.id',
        'user_driver_data.name as driver_name',
        'user_driver_data.phone as driver_phone',
        'log_add_money.money',
        'log_add_money.current_money',
        'log_add_money.new_money',
        'log_add_money.reason',
        'log_add_money.time'
        );
        //check tai xe thuoc dai ly
        $current_user 	= auth()->user();
        $driveData["agency_id"]   = $current_user->agency_id;

        if($driveData["agency_id"] > 0)
        {
            $resultQuery->where('user_driver_data.agency_id', '=', $driveData["agency_id"] );
        }
        return $resultQuery->get();
    }
    public function headings(): array
    {
        return ["Mã nạp tiền", "Tên TX", "SĐT TX", "Tiền", "Tiền hiện tại",  "Tiền sau khi thay đổi ",  "Lí do ",  "Thời gian "];
    }
}



