<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportPointRequest;
use App\Exports\ExportTemplateLogPointRequest;
use App\Http\Controllers\Controller;
use App\Imports\ImportLogPointRequest;
use App\Models\LogAddPointRequest;
use App\Models\LogPoint;
use App\Models\UserB;
use App\Services\ExportService;
use App\Utils\SuperAdminPermissionCheck;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class PointController extends Controller
{
    protected ExportService $exportService;
    public function __construct(ExportService $exportService) {
        $this->exportService = $exportService;
    }

    public function checkUser(Request $request)
    {
        $phone = $request->input('phone');
        $user = UserB::where('phone', $phone)->first();
        if ($user) {
            return response()->json([
                'success' => true,
                'name' => $user->name,
                'email' => $user->email,
                'points' => $user->points
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng',
            ]);
        }
    }

    public function checkUserGivePoint(Request $request)
    {
        $fromPhone = $request->input('fromPhone');
        $toPhone = $request->input('toPhone');

//        $validator = Validator::make([
//            'toPhone' => $toPhone,
//            'fromPhone' => $fromPhone,
//        ], [
//            'toPhone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
//            'fromPhone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
//        ], [
//            'toPhone.required' => 'Nhập số điện thoại người nhận',
//            'toPhone.regex' => 'Nhập số điện thoại người nhận  không hợp lệ',
//            'fromPhone.required' => 'Nhập số điện thoại người gửi',
//            'fromPhone.regex' => 'Nhập số điện thoại người gửi không hợp lệ',
//        ]);

        $response = [
            'success' => false,
            'fromUser' => null,
            'toUser' => null
        ];

//        if ($validator->fails()) {
//            $errors = $validator->errors();
//
//            if ($errors->has('fromPhone')) {
//                $response['fromUser'] = $errors->first('fromPhone');
//            }  else {
//                $response['fromUser'] = null;
//            }
//
//            if ($errors->has('toPhone')) {
//                $response['toUser'] = $errors->first('toPhone');
//            } else {
//                $response['toUser'] = null;
//            }
//
//            return response()->json($response);
//        }

        $fromUser = UserB::where('phone', $fromPhone)->first();
        $toUser = UserB::where('phone', $toPhone)->first();

        if ($fromUser) {
            $response['fromUser'] = [
                'name' => $fromUser->name,
                'email' => $fromUser->email,
                'points' => $fromUser->points,
            ];
        } else {
            $response['fromUser'] = 'Không tìm thấy người dùng';
        }

        if ($toUser) {
            $response['toUser'] = [
                'name' => $toUser->name,
                'email' => $toUser->email,
                'points' => $toUser->points
            ];
        } else {
            $response['toUser'] = 'Không tìm thấy người dùng';
        }

        if ($fromUser && $toUser) {
            $response['success'] = true;
        }

        return response()->json($response);
    }

    public function addPoint(Request $request)
    {
        $page_title = __('Tặng/trừ điểm cho người dùng');
        $type_points = config('blog.type_points');

        return view('admin.users.add-point', compact('page_title', 'type_points'));
    }

    public function storeAddPoint(Request $request)
    {
        $phone = $request->input('phone');
        $point = $request->input('point');
        $reason = $request->input('reason');
        $type = $request->input('type');

        $currentDateTime = Carbon::now();

        try {
            DB::beginTransaction();

            $validator = Validator::make([
                'point' => $point,
                'reason' => $reason,
                'phone' => $phone,
                'type' => $type,
            ], [
                'point' => 'required|integer',
                'type' => 'required',
                'reason' => 'max:100',
                'phone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
            ], [
                'point.required' => 'Nhập số điểm cần giao dịch',
                'point.integer' => 'Trường điểm phải là số nguyên',
                'type.required' => 'Dữ liệu không được trống',
                'reason.max' => 'Văn bản không lớn hơn 100 ký tự',
                'phone.required' => 'Nhập số điện thoại người nhận',
                'phone.regex' => 'Số điện thoại người nhận  không hợp lệ',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = UserB::where('phone', $phone)->first();
            if ($user) {
                $currentUser = auth()->user();
                LogAddPointRequest::query()->create([
                    'from_user_id' => 0,
                    'to_user_id' => $user->id,
                    'reason' => $reason,
                    'point' => $point,
                    'type' => $type,
                    'create_name' => auth()->user()->email,
                    'status' => '0',
                    'create_date' => $currentDateTime,
                    'agency_id' => $currentUser->agency_id,
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Tạo yêu cầu thành công');
            } else {
                return redirect()->back()->with('error', __('Không tìm thấy người dùng, kiểm tra người dùng trước khi giao dịch'));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __($e->getMessage()));
        }
    }

    public function givePoint(Request $request)
    {
        $page_title = __('Giao dịch điểm cho người dùng');

        return view('admin.users.give-point', compact('page_title'));
    }

    public function storeGivePoint(Request $request)
    {
        $toUserPhone = $request->input('toPhone');
        $fromUserPhone = $request->input('fromPhone');
        $point = $request->input('point');
        $reason = $request->input('reason');
        $currentDateTime = Carbon::now();

        try {
            DB::beginTransaction();

            $validator = Validator::make([
                'point' => $point,
                'reason' => $reason,
                'toPhone' => $toUserPhone,
                'fromPhone' => $fromUserPhone,
            ], [
                'point' => 'required|integer',
                'reason' => 'max:100',
                'toPhone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
                'fromPhone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
            ], [
                'point.required' => 'Nhập số điểm cần giao dịch',
                'point.integer' => 'Trường điểm phải là số nguyên',
                'reason.max' => 'Văn bản không lớn hơn 100 ký tự',
                'toPhone.required' => 'Nhập số điện thoại người nhận',
                'toPhone.regex' => 'Số điện thoại người nhận  không hợp lệ',
                'fromPhone.required' => 'Nhập số điện thoại người gửi',
                'fromPhone.regex' => 'Số điện thoại người gửi không hợp lệ',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $toUser = UserB::where('phone', $toUserPhone)->first();
            $fromUser = UserB::where('phone', $fromUserPhone)->first();

            if ($toUser && $fromUser) {

                if ($toUser->id === $fromUser->id) {
                    return redirect()->back()->with('error', __('Không thể chuyển điểm cho cùng một người dùng'));
                }

                if ($fromUser->points < 300) {
                    return redirect()->back()->with('error', __('Người gửi phải có ít nhất 300 điểm để bắt đầu giao dịch'));
                }

                if ($fromUser->points < $point) {
                    return redirect()->back()->with('error', __('Người gửi không có đủ điểm trong tài khoản'));
                }

                $currentUser = auth()->user();
                LogAddPointRequest::query()->create([
                    'to_user_id' => $toUser->id,
                    'from_user_id' => $fromUser->id,
                    'reason' => $reason,
                    'point' => $point,
                    'create_name' => auth()->user()->email,
                    'status' => '0',
                    'create_date' => $currentDateTime,
                    'agency_id' => $currentUser->agency_id,
                ]);

                $fromUser->points -= $point;
                $fromUser->save();

                DB::commit();
                return redirect()->back()->with('success', 'Tạo yêu cầu thành công');
            } else {
                return redirect()->back()->with('error', __('Không tìm thấy người dùng, kiểm tra người dùng trước khi giao dịch'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __($e->getMessage()));
        }
    }

    public function log(Request $request)
    {
        $page_title = __('Nhật ký giao dịch điểm');
        $resultQuery = LogPoint::query()->with('user_data:id,email,phone,name,points');

        if ($request->filled('phone')) {
            $resultQuery->whereHas('user_data', function ($query) use ($request) {
                $query->where('phone', 'like', "%{$request->input('phone')}%");
            });
        }

        //check thuoc dai ly
        $current_user = auth()->user();
        $current_user_agency = $current_user->agency_id;
        if ($current_user_agency > 0) {
            $resultQuery->where('agency_id', '=', $current_user_agency);
        }

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $logPoints = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.users.log-point', compact('logPoints', 'page_title'));
    }

    public function point_list_request(Request $request)
    {
        $page_title = __('Danh sách cần duyệt');
        $type_points = config('blog.type_points');
        $resultQuery = LogAddPointRequest::query()->with(['from_user', 'to_user']);

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

        //check thuoc dai ly
        $current_user = auth()->user();
        $current_user_agency = $current_user->agency_id;
        if ($current_user_agency > 0) {
            $resultQuery->where('agency_id', '=', $current_user_agency);
        }

        $resultQuery->where('status', '=', "0");

        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $LogAddPointRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.users.point_list_approve', compact('LogAddPointRequest', 'type_points', 'page_title'));
    }

    public function point_list(Request $request)
    {
        $page_title = __('Danh sách yêu cầu nạp điểm');
        $type_points = config('blog.type_points');
        $resultQuery = LogAddPointRequest::query()->with(['from_user', 'to_user']);

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

        //check thuoc dai ly
        $current_user = auth()->user();
        $current_user_agency = $current_user->agency_id;
        if ($current_user_agency > 0) {
            $resultQuery->where('agency_id', '=', $current_user_agency);
        }

        $sortBy = $request->get('sort') ? $request->get('sort') : 'id';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $LogAddPointRequest = $resultQuery->paginate(config('Reading.nodes_per_page'));

        if ($request->input('excel') == "Excel") {
            if (!SuperAdminPermissionCheck::isAdmin()) {
                return redirect()->back()->with('error', 'Bạn không có quyền truy cập chức năng này.');
            } else {
                $response = Excel::download(new ExportPointRequest($request), 'ds-yeucau-napdiem.xlsx', \Maatwebsite\Excel\Excel::XLSX);
                if (ob_get_contents()) ob_end_clean();
                return $response;
            }
        }

        return view('admin.users.point_list', compact('LogAddPointRequest', 'type_points', 'page_title'));
    }

    public function handleRemoveRequest($id)
    {
        try {
            DB::beginTransaction();
            $log = LogAddPointRequest::query()->where('id', $id)->first();
            $currentUser = auth()->user()->email;

            if (empty($log)) {
                return redirect()->back()->with('error', __('Mã yêu cầu không tồn tại'));
            }

            $log->status = 2;
            $log->approved_by = $currentUser;
            $log->save();

            $fromUser = UserB::query()->where('id', $log->from_user_id)->first();
            if (!empty($fromUser)) {
                $fromUser->points += $log->point;
                $fromUser->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('success', __('Hủy yêu cầu thành công'));
    }

    public function importLogPointRequest(Request $request) {
        if ($request->isMethod('GET')) {
            $page_title = __('Import nạp điểm');

            $types = collect([
                (object)['code' => 'give_event', 'description' => 'Tặng sự kiện'],
                (object)['code' => 'buy_point', 'description' => 'Khách mua điểm'],
                (object)['code' => 'give_vip', 'description' => 'Tặng khách hàng VIP'],
                (object)['code' => 'give_staff', 'description' => 'Tặng nhân viên'],
                (object)['code' => 'cashout', 'description' => 'Rút hoàn tiền'],
                (object)['code' => 'other', 'description' => 'Khác'],
            ]);

            return view('admin.users.import_log_point_request', compact('page_title', 'types'));
        }
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx,csv',
        ]);
        try {
            DB::beginTransaction();
            $result = Excel::import(new ImportLogPointRequest(), $request->file('excel_file'));
            DB::commit();
            return redirect()->back()->with('success', 'Tạo thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', __($e->getMessage()));
        }
    }

    //    export template import log point request
    public function exportTemplate(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $exporter = new ExportTemplateLogPointRequest();
        return $this->exportService->exportData($exporter, 'template_import_log_point_request');
    }

    public function handleAcceptRequest($id): \Illuminate\Http\RedirectResponse
    {
        $currentUser = auth()->user()->email;
        $result = $this->acceptRequest($id, $currentUser);

        return redirect()->back()->with($result['status'], $result['message']);
    }

    public function handleAcceptMultipleRequest(Request $request): \Illuminate\Http\RedirectResponse
    {
        $currentUser = auth()->user()->email;
        $items = $request->input('choose_item');
        if (empty($items)) {
            return redirect()->back()->with('error', __('Không có yêu cầu nào được chọn'));
        }

        $errors = [];
        $successes = [];

        foreach ($items as $id) {
            $result = $this->acceptRequest($id, $currentUser);
            if ($result['status'] == 'error') {
                $errors[] = "ID $id: " . $result['message'];
            } else {
                $successes[] = $id;
            }
        }

        $errorMessages = !empty($errors) ? __('Các yêu cầu sau không thể chấp nhận:') . ' ' . implode(', ', $errors) : '';
        $successMessage = !empty($successes) ? __('Các yêu cầu sau đã được chấp nhận thành công:') . ' ' . implode(', ', $successes) : '';

        if ($errorMessages && $successMessage) {
            return redirect()->back()->with('success', $successMessage)->with('error', $errorMessages);
        } elseif ($errorMessages) {
            return redirect()->back()->with('error', $errorMessages);
        } else {
            return redirect()->back()->with('success', $successMessage);
        }
    }

    public function acceptRequest($id, $currentUser): array
    {
        try {
            DB::beginTransaction();
            $log = LogAddPointRequest::query()->where('id', $id)->first();

            if (empty($log)) {
                return [
                    'status' => 'error',
                    'message' => __('Mã yêu cầu không tồn tại')
                ];
            }

            $log->status = 1;
            $log->approved_by = $currentUser;
            $log->save();

            $user = UserB::query()->where('id', $log->to_user_id)->first();

            if (!empty($user)) {
                $userCurrentPoint = $user->points;
                $userNewPoint = $user->points + $log->point;
                $user->points += $log->point;
                $user->save();

                LogPoint::create([
                    'user_data_id' => $user->id,
                    'point' => $log->point,
                    'current_point' => $userCurrentPoint,
                    'new_point' => $userNewPoint,
                    'reason' => 'Tặng điểm từ ADMIN. Lời nhắn: ' . ($log->reason ?? 'Không có'),
                    'created_at' => now(),
                ]);

                DB::commit();
                return ['status' => 'success', 'message' => __('Xác nhận yêu cầu thành công')];
            } else {
                DB::rollBack();
                return ['status' => 'error', 'message' => __('Người dùng không tồn tại')];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
