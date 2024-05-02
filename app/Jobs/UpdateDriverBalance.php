<?php

namespace App\Jobs;

use App\Models\Driver;
use App\Models\LogAddMoney;
use App\Models\LogAddMoneyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateDriverBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $goInfo;

    /**
     * Create a new job instance.
     *
     * @param $goInfo
     */
    public function __construct($goInfo)
    {
        $this->goInfo = $goInfo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Xử lý hoàn tiền cho tài xế
        $serviceDetailIdsAcceptedToRefund = [26];
        $go_info = $this->goInfo;
        if (in_array($go_info->service_detail_id, $serviceDetailIdsAcceptedToRefund)) {
            $driver_id = $go_info->driver_id;
            $driver = Driver::findorFail($driver_id);
            $phone = $driver->phone;
            $money = $go_info->driver_cost;
            $reason = 'Nạp tiền cho Cuốc Hủy BUTL_' . $go_info->id . ' lúc ' . $go_info->create_date;

            $driveData["phone"] = $phone;
            $driveData["money"] = $money;
            $driveData["reason"] = $reason;
            $driveData["user_id"] = $driver->id;
            $driveData["user_name"] = $driver->name;
            $driveData["user_phone"] = $driver->phone;
            $driveData["agency_id"] = $driver->agency_id;
            $current_user = auth()->user();
            $driveData["create_name"] = $current_user->email ?? 'bot@test.com';
            $driveData["status"] = 0;

            $blog = LogAddMoneyRequest::create($driveData);

            $this->addMoney($blog->id, $driver);
        }

    }

    /**
     * @param $id
     * @return void
     */
    private function addMoney($id, $driver): void
    {
        $info_request = LogAddMoneyRequest::firstWhere('id', $id);
        $current_user = auth()->user();
        if ($info_request && $info_request->status == 0) {
            $driver_id = $info_request->user_id;
            $driver_phone = $info_request->user_phone;
            $driver_name = $info_request->user_name;
            $driver_agency_id = $info_request->agency_id;
            $driver_money = $info_request->money;
            $driver_reason = $info_request->reason;
            $driver_create_name = $info_request->create_name;

            //check tai xe thuoc dai ly
//            if ($current_user->agency_id > 0) {
//                if ($current_user->agency_id != $driver_agency_id) {
//                    return redirect()->route('driver.admin.payment_list_approve')->with('error', __('Bạn không quản lí tài xế không tồn tại.'));
//                }
//            }

            $driveData["money"] = $driver->money + $driver_money; //$driver_money số tiền yêu cầu thêm

            // lưu log
            $LogAddMoney["user_id"] = $driver_id;
            $LogAddMoney["money"] = $driver_money;
            $LogAddMoney["user_name"] = $driver_name;
            $LogAddMoney["user_phone"] = $driver_phone;
            $LogAddMoney["reason"] = $driver_reason;
            $LogAddMoney["create_name"] = $driver_create_name;
            $LogAddMoney["type"] = 1;
            $LogAddMoney["user_type"] = 2;
            $LogAddMoney["current_money"] = $driver->money;
            $LogAddMoney["new_money"] = $driveData["money"];
            $LogAddMoney["agency_id"] = $driver_agency_id;
            $LogAddMoney = LogAddMoney::create($LogAddMoney);
            if ($LogAddMoney) {
                // cập nhật ds yêu cầu status = 1 đã duyệt
                $request = LogAddMoneyRequest::findorFail($id);
                $requestData["status"] = 1;
                $request->fill($requestData)->save();
                // add tiền cho tài xế
                $driver->fill($driveData)->save();
            }
        }
    }
}
