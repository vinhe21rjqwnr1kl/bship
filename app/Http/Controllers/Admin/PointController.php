<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogPoint;
use App\Models\UserB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PointController extends Controller
{
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
                'points' => $fromUser->points
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
        $page_title = __('Tặng điểm cho người dùng');
        return view('admin.users.add-point', compact('page_title'));
    }

    public function storeAddPoint(Request $request)
    {
        $phone = $request->input('phone');
        $point = $request->input('point');
        $reason = $request->input('reason');
        $currentDateTime = Carbon::now();

        try {
            DB::beginTransaction();

            $validator = Validator::make([
                'point' => $point,
                'reason' => $reason,
                'phone' => $phone,
            ], [
                'point' => 'required|integer|min:1|max:500',
                'reason' => 'max:100',
                'phone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
            ], [
                'point.required' => 'Nhập số điểm cần giao dịch',
                'point.integer' => 'Trường điểm phải là số nguyên',
                'point.min' => 'Điểm giao dịch phải lớn hơn 0',
                'point.max' => 'Điểm giao dịch không lớn hơn 500',
                'reason.max' => 'Văn bản không lớn hơn 100 ký tự',
                'phone.required' => 'Nhập số điện thoại người nhận',
                'phone.regex' => 'Số điện thoại người nhận  không hợp lệ',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = UserB::where('phone', $phone)->first();

            if ($user) {
                $user->points += $point;
                $user->save();

                $admin = Auth::user()->email;

                LogPoint::create([
                    'user_data_id' => $user->id,
                    'point' => $point,
                    'reason' => 'Tặng điểm từ ADMIN: <strong>'. $admin .'</strong>.<br/>Lờì nhắn: ' . ($reason ?? 'Không có'),
                    'created_at' => $currentDateTime,
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Thêm điểm thành công');
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
                'point' => 'required|integer|min:1|max:500',
                'reason' => 'max:100',
                'toPhone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
                'fromPhone' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
            ], [
                'point.required' => 'Nhập số điểm cần giao dịch',
                'point.integer' => 'Trường điểm phải là số nguyên',
                'point.min' => 'Điểm giao dịch phải lớn hơn 0',
                'point.max' => 'Điểm giao dịch không lớn hơn 500',
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

                $fromUser->points -= $point;
                $toUser->points += $point;

                $fromUser->save();
                $toUser->save();

                $admin = Auth::user()->email;


                LogPoint::create([
                    'user_data_id' => $fromUser->id,
                    'point' => -$point,
                    'reason' => 'Chuyển cho người dùng ' . $toUser->phone . '.<br/>
                                    ADMIN giao dịch: <strong>' . $admin . '</strong>.<br/>
                                    Lờì nhắn: ' . ($reason ?? 'Không có'),
                    'created_at' => $currentDateTime
                ]);

                LogPoint::create([
                    'user_data_id' => $toUser->id,
                    'point' => $point,
                    'reason' => 'Nhận từ người dùng ' . $fromUser->phone . '.<br/>
                                    ADMIN giao dịch: <strong>' . $admin . '</strong>.<br/>
                                    Lờì nhắn: ' . ($reason ?? 'Không có'),
                    'created_at' => $currentDateTime
                ]);

                DB::commit();
                return redirect()->back()->with('success', 'Giao dịch điểm thành công');
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

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);
        $logPoints = $resultQuery->paginate(config('Reading.nodes_per_page'));

        return view('admin.users.log-point', compact('logPoints', 'page_title'));
    }
}
