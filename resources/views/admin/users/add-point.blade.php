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
                                    <div class="form-group col-6">
                                        <label>Số Điện thoại khách hàng</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="">
                                        <div id="result" class="text-danger"></div>
                                    </div>
                                    <div class="form-group col-6" style="padding-top:30px;">
                                        <button class="btn btn-primary">Kiểm tra tài xế</button>
                                    </div>
                                </form>

                                <form action="{{ route('admin.point.add.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="userId" name="id">

                                    <div class="form-group col-12">
                                        <label>Số điểm</label>
                                        <input type="number" name="point" id="point" class="form-control">
                                        <p class="text-danger">
                                        </p>
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Lí do</label>
                                        <input type="text" name="reason" id="reason" class="form-control">
                                    </div>

                                    <div class="card-footer pt-0 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            Tạo
                                        </button>
                                        <a href="{{ route('driver.admin.payment') }}" class="btn btn-danger">Quay lại</a>
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

                var phone = $('#phone').val();

                $.ajax({
                    url: '/admin/user/check-user',
                    type: 'GET',
                    data: {phone: phone},
                    success: function (response) {
                        if (response.success) {
                            $('#userId').val(response.id);
                            $('#result').html('Name: ' + response.name + '<br>Email: ' + response.email + '<br>Points: ' + response.points);
                        } else {
                            $('#result').html('User not found.');
                        }
                    }
                });
            });
        });


    </script>
    <script>

    </script>

@endsection
