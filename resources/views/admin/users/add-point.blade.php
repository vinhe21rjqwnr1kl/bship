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

                                <form action="{{ route('admin.point.add.store') }}" method="post">
                                    @csrf
                                    <div class="form-group col-6">
                                        <label>Số Điện thoại người dùng</label>
                                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                                    </div>
                                    <div id="result" class="text-danger">
                                        @error('phone')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6" style="padding-top:30px;">
                                        <button id="checkUserForm" class="btn btn-primary">Kiểm tra người dùng</button>
                                    </div>

{{--                                    <input type="hidden" id="userId" name="id">--}}

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
            $('#checkUserForm').click(function (event) {
                event.preventDefault();

                var phone = $('#phone').val();

                var url = '{{ route("admin.point.check-user") }}';

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {phone: phone},
                    success: function (response) {
                        $('#result').removeClass();
                        if (response.success) {
                            $('#result').html('Name: ' + response.name + '<br>Email: ' + response.email + '<br>Points: ' + response.points);
                            $('#result').addClass('text-success');

                        } else {
                            $('#result').html(response.message);
                            $('#result').addClass('text-danger');

                        }
                    }
                });
            });
        });


    </script>
    <script>

    </script>

@endsection
