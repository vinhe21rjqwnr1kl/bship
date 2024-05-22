<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogPoint;
use App\Models\UserB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PointController extends Controller
{
    //

    public function checkUser(Request $request)
    {
        $phone = $request->input('phone');
        $user = UserB::where('phone', $phone)->first();
        if ($user) {
            return response()->json([
                'success' => true,
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'points' => $user->points
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ]);
        }
    }

    public function checkUserGivePoint(Request $request)
    {
        $fromPhone = $request->input('fromPhone');
        $toPhone = $request->input('toPhone');

        $fromUser = UserB::where('phone', $fromPhone)->first();
        $toUser = UserB::where('phone', $toPhone)->first();

        $response = [
            'success' => false,
            'fromUser' => null,
            'toUser' => null
        ];

        if ($fromUser) {
            $response['fromUser'] = [
                'id' => $fromUser->id,
                'name' => $fromUser->name,
                'email' => $fromUser->email,
                'points' => $fromUser->points
            ];
        } else {
            $response['fromUser'] = 'User fromPhone not found.';
        }

        if ($toUser) {
            $response['toUser'] = [
                'id' => $toUser->id,
                'name' => $toUser->name,
                'email' => $toUser->email,
                'points' => $toUser->points
            ];
        } else {
            $response['toUser'] = 'User toPhone not found.';
        }

        if ($fromUser && $toUser) {
            $response['success'] = true;
        }

        return response()->json($response);
    }

    public function addPoint(Request $request)
    {

        return view('admin.users.add-point');
    }

    public function storeAddPoint(Request $request)
    {
        $userId = $request->input('id');
        $point = $request->input('point');
        $reason = $request->input('reason');
        $user = UserB::where('id', $userId)->first();
        $currentDateTime = Carbon::now();

        if ($user) {
            $user->points += $point;
            $user->save();

            LogPoint::create(['user_data_id' => $user->id, 'point' => $point, 'reason' => $reason, 'created_at' => $currentDateTime]);

            return redirect()->back()->with('success', 'Points added successfully.');
        } else {
            return redirect()->back()->with('error', __('User not found'));
        }
    }

    public function givePoint(Request $request)
    {

        return view('admin.users.give-point');
    }

    public function storeGivePoint(Request $request)
    {
        $toUserId = $request->input('toUserId');
        $fromUserId = $request->input('fromUserId');
        $point = $request->input('point');
        $reason = $request->input('reason');

        try {
            $validator = Validator::make([
                'point' => $point,
                'toUserId' => $toUserId,
                'fromUserId' => $fromUserId,
            ], [
                'point' => 'required|integer|min:1|max:500',
                'toUserId' => 'required',
                'fromUserId' => 'required',
            ], [
                'point.required' => 'Trường điểm là bắt buộc.',
                'point.integer' => 'Trường điểm phải là số nguyên.',
                'point.min' => 'Điểm giao dịch phải lớn hơn 0.',
                'point.max' => 'Điểm giao dịch không được lớn hơn 500.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $toUser = UserB::where('id', $toUserId)->first();
            $fromUser = UserB::where('id', $fromUserId)->first();

            if ($toUser->id === $fromUser->id) {
                return redirect()->back()->with('error', __('Cannot transfer points to the same user'));
            }

            if ($fromUser->points < 300) {
                return redirect()->back()->with('error', __('From user must have at least 300 points to initiate a transfer'));
            }

            if ($toUser && $fromUser) {
                if ($fromUser->points < $point) {
                    return redirect()->back()->with('error', __('Not enough points in fromUser account'));
                }

                $fromUser->points -= $point;
                $toUser->points += $point;

                $fromUser->save();
                $toUser->save();

                LogPoint::create([
                    'user_data_id' => $fromUser->id,
                    'point' => -$point,
                    'reason' => 'Chuyển cho người dùng ' . $toUser->phone . '. Lờì nhắn: ' . $reason
                ]);

                LogPoint::create([
                    'user_data_id' => $toUser->id,
                    'point' => $point,
                    'reason' => 'Nhận từ người dùng ' . $fromUser->phone . '. Lờì nhắn: ' . $reason
                ]);

                return redirect()->back()->with('success', 'Points transferred successfully.');
            } else {
                return redirect()->back()->with('error', __('User not found'));
            }


        } catch (\Exception $e) {
            return redirect()->back()->with('error', __($e->getMessage()));
        }
    }

    public function log(){
        $log = LogPoint::all();
        return $log;
//        return view('admin.users.log-point');
    }
}
