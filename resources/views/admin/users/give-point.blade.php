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

                                <form action="{{ route('admin.point.give.store') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Số điện thoại người gửi</label>
                                                <input type="text" name="fromPhone" id="fromPhone" class="form-control"
                                                    value="{{ old('fromPhone') }}">
                                            </div>
                                            <div id="fromPhoneResult">

                                                @error('fromPhone')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Số điện thoại người nhận</label>
                                                <input type="text" name="toPhone" id="toPhone" class="form-control"
                                                    value="{{ old('toPhone') }}">
                                            </div>
                                            <div id="toPhoneResult">

                                                @error('toPhone')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group col-6" style="padding-top:30px;">
                                        <button id="checkUserForm" class="btn btn-primary">Kiểm tra người dùng</button>
                                    </div>

                                    <div class="form-group col-12">

                                        <label>Số điểm</label>
                                        <input type="number" name="point" id="point" class="form-control"
                                               value="{{ old('point') }}">
                                        @error('point')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Lí do</label>
                                        <input type="text" name="reason" id="reason" class="form-control" value="{{ old('reason') }}">
                                        @error('reason')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="card-footer pt-0 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            Xác nhận
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
            $('#checkUserForm').click(function (event) {
                event.preventDefault();

                var fromPhone = $('#fromPhone').val();
                var toPhone = $('#toPhone').val();

                var url = '{{ route("admin.point.check-user.give-point") }}';


                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        fromPhone: fromPhone,
                        toPhone: toPhone
                    },
                    success: function (response) {
                        $('#fromPhoneResult').removeClass();
                        $('#toPhoneResult').removeClass();
                        if (response.success) {
                            $('#fromPhoneResult').html('From User: ' + response.fromUser.name + '<br/>Email: ' + response.fromUser.email + '<br/>Points: ' + response.fromUser.points);
                            $('#toPhoneResult').html('To User: ' + response.toUser.name + '<br/>Email: ' + response.toUser.email + '<br/>Points: ' + response.toUser.points);

                            $('#fromPhoneResult').addClass('text-success');
                            $('#toPhoneResult').addClass('text-success');
                        } else {
                            if (response.fromUser !== null) {
                                if (typeof response.fromUser == 'string') {
                                    $('#fromPhoneResult').html(response.fromUser);
                                    $('#fromPhoneResult').addClass('text-danger');

                                } else {
                                    $('#fromPhoneResult').html('From User: ' + response.fromUser.name + '<br/>Email: ' + response.fromUser.email + '<br/>Points: ' + response.fromUser.points);
                                    $('#fromPhoneResult').addClass('text-success');

                                }
                            }
                            if (response.toUser !== null) {
                                if (typeof response.toUser == 'string') {
                                    $('#toPhoneResult').html(response.toUser);
                                    $('#toPhoneResult').addClass('text-danger');

                                } else {
                                    $('#toPhoneResult').html('To User: ' + response.toUser.name + '<br/>Email: ' + response.toUser.email + '<br/>Points: ' + response.toUser.points);
                                    $('#toPhoneResult').addClass('text-success');

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
