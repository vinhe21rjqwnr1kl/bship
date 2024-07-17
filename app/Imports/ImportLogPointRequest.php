<?php

namespace App\Imports;

use App\Models\LogAddPointRequest;
use App\Models\UserB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Events\AfterImport;


class ImportLogPointRequest implements ToModel, WithHeadingRow, WithValidation, WithEvents
{
    protected $unfoundNumbers = [];
    public function model(array $row) {
        $phone = $row['phone_user'];
        $point = $row['point_user'];
        $type = $row['type'] ??  'give_vip';
        $reason = $row['reason'];
        $currentDateTime = date('Y-m-d H:i:s');

        // Find the user by phone number
        $user = UserB::where('phone', $phone)->first();

        if(!$user) {
            $this->unfoundNumbers[] = $phone;
            return null;
        }

        $currentUser = auth()->user();

        return new LogAddPointRequest([
            'to_user_id' => $user->id,
            'reason' => $reason,
            'point' => $point,
            'type' => $type,
            'create_name' => $currentUser->email,
            'status' => '0',
            'create_date' => $currentDateTime,
            'agency_id' => $currentUser->agency_id,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.point_user' => 'required|integer',
            '*.reason' => 'max:100',
            '*.phone_user' => ['required', 'regex:/^(03|05|07|08|09)\d{8}$|^(02)\d{9}$/'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'point_user.required' => 'Nhập số điểm cần giao dịch',
            'point_user.integer' => 'Trường điểm phải là số nguyên',
            'reason.max' => 'Văn bản không lớn hơn 100 ký tự',
            'phone_user.required' => 'Nhập số điện thoại người nhận',
            'phone_user.regex' => 'Số điện thoại người nhận không hợp lệ',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterImport::class => function (AfterImport $event) {
                if (!empty($this->unfoundNumbers)) {
                    throw ValidationException::withMessages([
                        'phone_user' => 'Không tìm thấy người dùng với số điện thoại: ' . implode(', ', $this->unfoundNumbers)
                    ]);
                }
            },
        ];
    }
}
