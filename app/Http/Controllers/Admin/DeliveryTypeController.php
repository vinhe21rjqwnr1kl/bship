<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryTypeRequest;
use App\Models\CfServiceDetail;
use App\Models\CfServiceMain;
use App\Models\CfServiceType;
use App\Models\DeliveryType;

class DeliveryTypeController extends Controller
{
    public function admin_index()
    {
        $page_title = __('Danh sách loại vận chuyển');
        $types = DeliveryType::query()
            ->leftJoin('cf_services_detail', 'cf_services_detail.id', '=', 'delivery_type.service_detail_id')
            ->leftJoin('cf_service_main', 'cf_service_main.id', '=', 'cf_services_detail.service_id')
            ->leftJoin('cf_services_type', 'cf_services_type.id', '=', 'cf_services_detail.service_type')
            ->select(
                'delivery_type.id as delivery_type_id',
                'delivery_type.name as delivery_type_name',
                'delivery_type.status as delivery_type_status',
                'delivery_type.ratio as delivery_type_ratio',
                'delivery_type.service_detail_id as delivery_type_service_detail_id',
                'cf_services_detail.id as detail_id',
                'cf_services_type.id as type_id',
                'cf_services_type.name as type_name',
                'cf_service_main.id as main_id',
                'cf_service_main.name as main_name',
            )
            ->get();
        return view('admin.delivery_type.index', compact('page_title', 'types'));
    }

    public function admin_create()
    {
        $page_title = __('Tạo loại vận chuyển');
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();
        return view('admin.delivery_type.create', compact('page_title', 'ServicesDetailArr', 'ServicesTypeArr', 'ServicesArr'));
    }

    public function admin_edit($id)
    {
        $page_title = __('Cập loại vận chuyển');
        $type = DeliveryType::query()->findOrFail($id);
        $ServicesArr = CfServiceMain::pluck('name', 'id')->toArray();
        $ServicesTypeArr = CfServiceType::pluck('name', 'id')->toArray();
        $ServicesDetailArr = CfServiceDetail::get();
        return view('admin.delivery_type.edit', compact('page_title', 'type' , 'ServicesDetailArr', 'ServicesTypeArr', 'ServicesArr'));
    }

    public function admin_store(DeliveryTypeRequest $request)
    {
        $data = $request->only([
            'name', 'ratio', 'status', 'service_detail_id'
        ]);
        $create = DeliveryType::query()->create($data);
        if ($create) {
            return redirect()->route('delivery_type.admin.index')->with('success', __('Tạo thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }
    }

    public function admin_update(DeliveryTypeRequest $request, $id)
    {
        $data = $request->only([
            'name', 'ratio', 'status', 'service_detail_id'
        ]);
        $update = DeliveryType::query()->findOrFail($id)->update($data);

        if ($update) {
            return redirect()->route('delivery_type.admin.index')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }
    }

    public function admin_destroy($id)
    {
        $delete = DeliveryType::query()->findOrFail($id);
        if ($delete->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }
}
