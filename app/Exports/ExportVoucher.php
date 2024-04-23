<?php
    namespace App\Exports;
    use App\Models\Voucher;
    use Maatwebsite\Excel\Concerns\FromQuery;
    use Maatwebsite\Excel\Concerns\Exportable;
    use Maatwebsite\Excel\Concerns\FromCollection;
    use Maatwebsite\Excel\Concerns\WithHeadings;
    use Illuminate\Support\Facades\DB;



    class ExportVoucher implements FromCollection, WithHeadings
{
    use Exportable;
    protected $request;

    public function __construct($request)
    {
        $this->request      = $request;
       // $this->service_id   = $service_id;
    }
    public function collection()
    {

        $request = $this->request  ; 
       // $service_id = $this->service_id  ;  


        $resultQuery            = Voucher::query();

        if($request->filled('discount_code')) {
            $resultQuery->where('discount_code', 'like', "%{$request->input('discount_code')}%");
        }

        if($request->filled('title')) {
            $resultQuery->where('title', '=', $request->input('title'));
        }


        $sortBy = $request->get('sort') ? $request->get('sort') : 'create_date';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
      //  $resultQuery->join('cf_services_detail', 'services_detail_id', '=', 'cf_services_detail.id');
      //  $resultQuery->select('t_discount.*','cf_services_detail.service_id','cf_services_detail.service_type');

        $resultQuery->leftjoin('t_discount_used', 't_discount.discount_code', '=', 't_discount_used.discount_code');

        $resultQuery->select('t_discount.discount_code',
        't_discount.title','t_discount.discount_value','t_discount.status','t_discount.start_date',
        't_discount.end_time','t_discount.create_date',
        DB::raw('if(t_discount_used.status=1, "Đã dùng", "Chưa dùng")'));

        return $resultQuery->get();
    }
    public function headings(): array
    {
        return ["Mã khuyến mãi",  "Tiêu đề", "Giá trị", "Trạng thái",  "Ngày bắt đầu", "Ngày kết thúc", "Ngày tạo", "Trạng thái sử dụng" ];
    }
}
?>


