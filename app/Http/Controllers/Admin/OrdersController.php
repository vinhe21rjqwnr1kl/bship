<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function admin_index(Request $request, $status = null)
    {
        $page_title = __('Danh sách đơn hàng');

        $statuses = array(
            array('id' => 1, 'name' => __('Pending')),
            array('id' => 2, 'name' => __('Confirmed')),
            array('id' => 3, 'name' => __('Delivered')),
            array('id' => 4, 'name' => __('Cancelled'))
        );


        $resultQuery = FoodOrder::with(['tripRequest', 'restaurant', 'items', 'user', 'driver']);

        if ($request->isMethod('get') && $request->input('todo') == 'Filter') {
            $tags = json_decode($request->input("tags"), true);
            if (!empty($tags)) {
                $resultQuery->where(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('delivery_address', 'like', "%{$tag}%");
                    }
                });
            }
            if ($request->filled('id')) {
                $resultQuery->where('id', '=', $request->input('id'));
            }
            if ($request->filled('restaurant_data')) {
                $resultQuery->whereHas('restaurant', function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->input('restaurant_data')}%")
                        ->orWhere('phone', 'like', $request->input('restaurant_data'));
                });
            }
            if ($request->filled('user_data')) {
                $resultQuery->whereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->input('user_data')}%")
                        ->orWhere('phone', 'like', $request->input('user_data'));
                });
            }
            if ($request->filled('driver_data')) {
                $resultQuery->whereHas('driver', function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->input('driver_data')}%")
                        ->orWhere('phone', 'like', $request->input('driver_data'));
                });
            }
            if ($request->filled('datefrom')) {
                $resultQuery->where('created_at', '>=', "{$request->input('datefrom')}");
            }
            if ($request->filled('dateto')) {
                $dateto = Carbon::createFromFormat('Y-m-d', $request->input('dateto'))->endOfDay();
                $resultQuery->where('created_at', '<=', $dateto);
            }
            if ($request->filled('status_data')) {
                $resultQuery->where('status', 'like', "%{$request->input('status_data')}%");
            }
        }
        if ($status > 0) {
            $resultQuery->where('status', '=', $status);

        }

        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $resultQuery->orderBy('food_orders.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;

        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        if ($driveData["agency_id"] > 0) {
            $resultQuery->whereHas('driver', function ($query) use ($driveData) {
                $query->where('driver.agency_id', '=', $driveData["agency_id"]);

            });
        }
        $foodOrders = $resultQuery->paginate(config('Reading.nodes_per_page'));

//        return $foodOrders;

        return view('admin.orders.index', compact('page_title', 'foodOrders', 'statuses'));
    }

    public function admin_details($id)
    {
        $page_title = __('Chi tiết đơn hàng');

        $statuses = array(
            array('id' => 1, 'name' => __('Pending')),
            array('id' => 2, 'name' => __('Confirmed')),
            array('id' => 3, 'name' => __('Delivered')),
            array('id' => 4, 'name' => __('Cancelled'))
        );

        $details = FoodOrder::with(['tripRequest', 'restaurant', 'items.product', 'items.size.size', 'user', 'driver'])->findOrFail($id);

//        return $details;


        return view('admin.orders.details', compact('page_title', 'details', 'statuses'));

    }

    public function admin_update(Request $request, $id)
    {
        $order = FoodOrder::where('id', $id)->first();
        $data['message'] = __('The :x has been successfully saved.', ['x' => __('Order')]);
        if (!empty($order)) {
            $order->status = $request->input('status');
            $order->save();
            return redirect()->back()->with('success', __('Cập nhật thành công.'));

        } else {
            return redirect()->back()->with('error', __('Cập nhật thất bại.'));
        }
    }

}
