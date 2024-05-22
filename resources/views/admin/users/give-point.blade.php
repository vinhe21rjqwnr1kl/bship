{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin</h4>
            </div>

            <div class="card-body">
                <div class="basic-form">
                    <div class="row align-items-center">

                        <div class="col-sm-12">
                            <div class="row">

                                <form id="checkUserForm">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Số Điện thoại người gửi</label>
                                                <input type="text" name="fromPhone" id="fromPhone" class="form-control"
                                                       value="">
                                            </div>
                                            <div id="fromPhoneResult" class="text-danger"></div>
                                            @error('fromUserId')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Số Điện thoại người nhận</label>
                                                <input type="text" name="toPhone" id="toPhone" class="form-control"
                                                       value="">
                                            </div>
                                            <div id="toPhoneResult" class="text-danger"></div>
                                            @error('toUserId')
                                            <p class="text-danger">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="form-group col-6" style="padding-top:30px;">
                                        <button class="btn btn-primary">Kiểm tra tài xế</button>
                                    </div>
                                </form>

                                <form action="{{ route('admin.point.give.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="fromUserId" name="fromUserId">

                                    <input type="hidden" id="toUserId" name="toUserId">

                                    <div class="form-group col-12">

                                        <label>Số điểm</label>
                                        <input type="number" name="point" id="point" class="form-control" value="{{ old('point') }}">
                                                                                @error('point')
                                                                                <p class="text-danger">
                                                                                    {{ $message }}
                                                                                </p>
                                                                                @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Lí do</label>
                                        <input type="text" name="reason" id="reason" class="form-control">
                                    </div>

                                    <div class="card-footer pt-0 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            Tạo
                                        </button>
                                        <a href="{{ route('driver.admin.payment') }}" class="btn btn-danger">Quay
                                            lại</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        'use strict';

        $(document).ready(function () {
            $('#checkUserForm').submit(function (event) {
                event.preventDefault();

                var fromPhone = $('#fromPhone').val();
                var toPhone = $('#toPhone').val();

                $.ajax({
                    url: '/admin/user/check-user-give-point',
                    type: 'GET',
                    data: {
                        fromPhone: fromPhone,
                        toPhone: toPhone
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#fromUserId').val(response.fromUser.id);
                            $('#toUserId').val(response.toUser.id);

                            $('#fromPhoneResult').html('From User: ' + response.fromUser.name + '<br/>Email: ' + response.fromUser.email + '<br/>Points: ' + response.fromUser.points);
                            $('#toPhoneResult').html('To User: ' + response.toUser.name + '<br/>Email: ' + response.toUser.email + '<br/>Points: ' + response.toUser.points);
                        } else {
                            if (response.fromUser !== null) {
                                if (typeof response.fromUser == 'string') {
                                    $('#fromPhoneResult').html(response.fromUser);
                                } else {
                                    $('#fromPhoneResult').html('From User: ' + response.fromUser.name + '<br/>Email: ' + response.fromUser.email + '<br/>Points: ' + response.fromUser.points);
                                }
                            }
                            if (response.toUser !== null) {
                                if (typeof response.toUser == 'string') {
                                    $('#toPhoneResult').html(response.toUser);
                                } else {
                                    $('#toPhoneResult').html('To User: ' + response.toUser.name + '<br/>Email: ' + response.toUser.email + '<br/>Points: ' + response.toUser.points);
                                }
                            }
                        }
                    }
                });
            });
        });


    </script>
    <script>

    </script>

@endsection
