<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryProductSizeRequest;
use App\Http\Requests\UpdateDeliveryProductSizeRequest;
use App\Models\DeliveryProductSize;
use Illuminate\Http\Request;

class DeliveryProductSizeController extends Controller
{
    public function admin_index(Request $request)
    {
        $page_title = __('Danh sách kích thước sản phẩm vận chuyển');
        $sizes = DeliveryProductSize::all();
        return view('admin.delivery_product_size.index', compact('sizes', 'page_title'));
    }

    public function admin_create()
    {
        $page_title = __('Tạo kích thước sản phẩm vận chuyển');
        return view('admin.delivery_product_size.create', compact('page_title'));
    }

    public function admin_edit($id)
    {
        $page_title = __('Cập nhật kích thước sản phẩm vận chuyển');
        $size = DeliveryProductSize::query()->findOrFail($id);
        return view('admin.delivery_product_size.edit', compact('size', 'page_title'));
    }

    public function admin_store(DeliveryProductSizeRequest $request)
    {
        $data = $request->only([
            'name', 'ratio', 'description', 'length', 'width', 'height', 'weight'
        ]);
        $create = DeliveryProductSize::query()->create($data);
        if ($create) {
            return redirect()->route('delivery_size.admin.index')->with('success', __('Tạo thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }
    }

    public function admin_update(DeliveryProductSizeRequest $request, $id)
    {
        $data = $request->only([
            'name', 'ratio', 'description', 'length', 'width', 'height', 'weight'
        ]);
        $update = DeliveryProductSize::query()->findOrFail($id)->update($data);

        if ($update) {
            return redirect()->route('delivery_size.admin.index')->with('success', __('Chỉnh sửa thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống quá tải , vui lòng quay lại sau.'));
        }
    }

    public function admin_destroy($id)
    {
        $delete = DeliveryProductSize::query()->findOrFail($id);
        if ($delete->delete()) {
            return redirect()->back()->with('success', __('Xoá thành công'));
        } else {
            return redirect()->back()->with('error', __('Hệ thống đang bận và quá tải.'));
        }
    }
}
