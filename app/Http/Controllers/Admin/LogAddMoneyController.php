<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAddMoneyCashout;
use Illuminate\Http\Request;

class LogAddMoneyController extends Controller
{
    public function index_cashout(Request $request) {
        $page_title = __('Danh sách yêu cầu nạp tiền');

        $resultQuery = LogAddMoneyCashout::query()->with(['user_data']);

        $resultQuery->whereHas('user_data', function ($query) use ($request) {
            if ($request->filled('phone')) {
                $query->where('phone', 'like', "%{$request->input('phone')}%");
            }
            if ($request->filled('name')) {
                $query->where('name', 'like', "%{$request->input('name')}%")
                    ->orWhere('email', 'like', "%{$request->input('name')}%");
            }
        });

        //check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;
        if ($driveData["agency_id"] > 0) {
            $resultQuery->where('agency_id', '=', $driveData["agency_id"]);
        }
        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

//        return response()->json($LogAddMoneyRequest);
        return view('admin.log_add_money.cashout', compact('LogAddMoneyRequest', 'page_title'));
    }

    public function index_cashin(Request $request) {

    }
}
