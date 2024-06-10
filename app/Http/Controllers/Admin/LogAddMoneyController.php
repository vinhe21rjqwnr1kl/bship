<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\LogAddMoneyCashin;
use App\Models\LogAddMoneyCashout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogAddMoneyController extends Controller
{
    public function cashoutIndex(Request $request)
    {
        $page_title = __('Danh sách yêu cầu rút tiền');

        $resultQuery = LogAddMoneyCashout::query();
//      check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        $resultQuery->with(['user_data', 'user_driver_data'])
            ->where(function ($query) use ($request, $driveData) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->whereHas('user_data', function ($userDataQuery) use ($request) {
                        $userDataQuery->where('user_type', 1); // Check if user_type is 1 (customer)
                        if ($request->filled('phone')) {
                            $userDataQuery->where('phone', 'like', "%{$request->input('phone')}%");
                        }
                        if ($request->filled('name')) {
                            $userDataQuery->where(function ($nameQuery) use ($request) {
                                $nameQuery->where('name', 'like', "%{$request->input('name')}%")
                                    ->orWhere('email', 'like', "%{$request->input('name')}%");
                            });
                        }
                    });
                })->orWhere(function ($subQuery) use ($request, $driveData) {
                    $subQuery->whereHas('user_driver_data', function ($userDriverDataQuery) use ($request, $driveData) {
                        $userDriverDataQuery->where('user_type', 2); // Check if user_type is 2 (driver)
                        if ($driveData["agency_id"] > 0) {
                            $userDriverDataQuery->where('agency_id', '=', $driveData["agency_id"]);
                        }
                        if ($request->filled('phone')) {
                            $userDriverDataQuery->where('phone', 'like', "%{$request->input('phone')}%");
                        }
                        if ($request->filled('name')) {
                            $userDriverDataQuery->where(function ($nameQuery) use ($request) {
                                $nameQuery->where('name', 'like', "%{$request->input('name')}%")
                                    ->orWhere('email', 'like', "%{$request->input('name')}%");
                            });
                        }
                    });
                });
            });

        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.log_add_money.cashout', compact('LogAddMoneyRequest', 'page_title'));
    }

    public function cashinIndex(Request $request)
    {
        $page_title = __('Danh sách yêu cầu nạp tiền');

        $resultQuery = LogAddMoneyCashin::query();
//      check tai xe thuoc dai ly
        $current_user = auth()->user();
        $driveData["agency_id"] = $current_user->agency_id;

        $resultQuery->with(['user_data', 'user_driver_data'])
            ->where(function ($query) use ($request,$driveData) {
                $query->where(function ($subQuery) use ($request) {
                    $subQuery->whereHas('user_data', function ($userDataQuery) use ($request) {
                        $userDataQuery->where('user_type', 1); // Check if user_type is 1 (customer)
                        if ($request->filled('phone')) {
                            $userDataQuery->where('phone', 'like', "%{$request->input('phone')}%");
                        }
                        if ($request->filled('name')) {
                            $userDataQuery->where(function ($nameQuery) use ($request) {
                                $nameQuery->where('name', 'like', "%{$request->input('name')}%")
                                    ->orWhere('email', 'like', "%{$request->input('name')}%");
                            });
                        }
                    });
                })->orWhere(function ($subQuery) use ($request,$driveData) {
                    $subQuery->whereHas('user_driver_data', function ($userDriverDataQuery) use ($request,$driveData) {
                        $userDriverDataQuery->where('user_type', 2); // Check if user_type is 2 (driver)
                        if ($driveData["agency_id"] > 0) {
                            $userDriverDataQuery->where('agency_id', '=', $driveData["agency_id"]);
                        }
                        if ($request->filled('phone')) {
                            $userDriverDataQuery->where('phone', 'like', "%{$request->input('phone')}%");
                        }
                        if ($request->filled('name')) {
                            $userDriverDataQuery->where(function ($nameQuery) use ($request) {
                                $nameQuery->where('name', 'like', "%{$request->input('name')}%")
                                    ->orWhere('email', 'like', "%{$request->input('name')}%");
                            });
                        }
                    });
                });
            });

        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $LogAddMoneyRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.log_add_money.cashin', compact('LogAddMoneyRequest', 'page_title'));
    }

    public function cashoutAccept(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $log = LogAddMoneyCashout::query()->where('id', '=', $id)->first();
            if (!$log) {
                return redirect()->back()->with('error', __('Yêu cầu không tồn tại'));
            }

            $driver = Driver::query()->where('id', '=', $log->user_id)->first();
            if (!$driver) {
                return redirect()->back()->with('error', __('Người dùng không tồn tại'));
            }

            $log->status = 2;
            $driver->money -= $log->amount;

            $log->save();
            $driver->save();

            DB::commit();
            return redirect()->back()->with('success', 'Thành công');

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', __('Quá trình xảy ra lỗi'));
        }
    }

    public function cashinAccept(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $log = LogAddMoneyCashin::query()->where('id', '=', $id)->first();
            if (!$log) {
                return redirect()->back()->with('error', __('Yêu cầu không tồn tại'));
            }

            $driver = Driver::query()->where('id', '=', $log->user_id)->first();
            if (!$driver) {
                return redirect()->back()->with('error', __('Người dùng không tồn tại'));
            }

            $log->status = 2;
            $driver->money += $log->amount;

            $log->save();
            $driver->save();

            DB::commit();
            return redirect()->back()->with('success', 'Thành công');

        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', __('Quá trình xảy ra lỗi'));
        }
    }

    public function cashoutReject(Request $request, $id)
    {
        try {
            $log = LogAddMoneyCashout::query()->where('id', '=', $id)->first();
            if (!$log) {
                return redirect()->back()->with('error', __('Yêu cầu không tồn tại'));
            }
            $log->status = 0;
            $log->save();
            return redirect()->back()->with('success', 'Từ chối yêu cầu thành công');

        } catch (\Exception $ex) {
            return redirect()->back()->with('error', __('Quá trình xảy ra lỗi'));
        }
    }

    public function cashinReject(Request $request, $id)
    {
        try {
            $log = LogAddMoneyCashin::query()->where('id', '=', $id)->first();
            if (!$log) {
                return redirect()->back()->with('error', __('Yêu cầu không tồn tại'));
            }
            $log->status = 0;
            $log->save();
            return redirect()->back()->with('success', 'Từ chối yêu cầu thành công');

        } catch (\Exception $ex) {
            return redirect()->back()->with('error', __('Quá trình xảy ra lỗi'));
        }
    }


}
