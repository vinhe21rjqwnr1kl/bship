<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{

    public function admin_index(Request $request)
    {
        $page_title = __('Danh sách đơn hàng (đã duyệt)');

//        $statuses = array(
//            array('id' => 1, 'name' => __('Pending')),
//            array('id' => 2, 'name' => __('Confirmed')),
//            array('id' => 3, 'name' => __('Delivered')),
//            array('id' => 4, 'name' => __('Cancelled'))
//        );

        $data['types'] = Transaction::query()->select('transaction_type')->distinct()->get();

        $users = Transaction::query()->where('user_id', '!=', null)->whereHas('user', function ($query) {
            $query->where('status', 'Active');
        });

        if ($users->exists()) {
            $data['users'] = $users->select('user_id')->distinct()->with('user:id,name')->get();
        }

        $vendors = Transaction::query()->where('vendor_id', '!=', null)->whereHas('vendor', function ($query) {
            $query->where('status', 'Active');
        });
        if ($vendors->exists()) {
            $data['vendors'] = $vendors->select('vendor_id')->distinct()->with('vendor:id,name')->get();
        }

        $data['statuses'] = Transaction::query()->select('status')->distinct()->get();


        $resultQuery = Transaction::query()->with([
            'user:id,name',
            'vendor:id,name',
            'currency:id,name',
            'withdrawalMethod:id,method_name',
            'order:id,reference']);

        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $resultQuery->orderBy('transactions.' . $sortBy, $direction);
        $sortWith = $request->get('with') ? $request->get('with') : Null;

        //check tai xe thuoc dai ly
//        $current_user = auth()->user();
//        $driveData["agency_id"] = $current_user->agency_id;
//
//        if ($driveData["agency_id"] > 0) {
//            $resultQuery->where('user_driver_data.agency_id', '=', $driveData["agency_id"]);
//        }

        $transactions = $resultQuery->paginate(config('Reading.nodes_per_page'));

//        return $transactions;

        return view('admin.transaction.index', compact('page_title', 'transactions', 'data'));
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

        $details = Transaction::with(['tripRequest', 'restaurant', 'items.product', 'items.size.size', 'user', 'driver'])->findOrFail($id);

//        return $details;


        return view('admin.orders.details', compact('page_title', 'details', 'statuses'));

    }

    public function admin_update(Request $request)
    {
        return $request->all();
    }


}
