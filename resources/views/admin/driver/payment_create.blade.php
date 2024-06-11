{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin</h4>
            </div>
            <form action="{{ route('driver.admin.payment_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="basic-form">
                        <div class="row align-items-center">

                            <div class="col-sm-12">
                                <div class="row">
                                    <input type="hidden" name="go_id" id="go_id" class="form-control"
                                           value="{{ $go_id }}">
                                    <div class="form-group col-6">
                                        <label>Số Điện thoại tài xế</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               value="{{ $phone }}">
                                        <p class="text-danger">
                                            {{ $info_string }}<br>
                                        </p>
                                        @error('phone')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6" style="padding-top:30px;">
                                        <a href="javascript:check();" class="btn btn-primary">Kiểm tra tài xế</a>

                                    </div>

                                    <div class="form-group col-12">
                                        <label>Loại</label>
                                        <select name="type" class="default-select form-control">
                                            <option value="" >-- Chọn --</option>
                                            <option
                                                {{ request()->input('type') == 'cashin_driver' ? 'selected="selected"':'' }} value="cashin_driver">{{ __("Nạp ví tài xế") }}</option>
                                            <option
                                                {{ request()->input('type') == 'cashout_driver' ? 'selected="selected"':'' }} value="cashout_driver">{{ __("Rút ví tài xế") }}</option>
                                            <option
                                                {{ request()->input('type') == 'refund_driver' ? 'selected="selected"':'' }} value="refund_driver">{{ __("Hoàn ví tài xế") }}</option>
                                        </select>

                                        @error('type')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-12">
                                        <label>Số tiền</label>
                                        <input type="text" name="money" id="money" class="form-control"
                                               value="{{ $money }}">
                                        @error('money')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Lí do</label>
                                        <input type="text" name="reason" id="reason" class="form-control"
                                               value="{{$reason }}">
                                        @error('reason')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer pt-0 text-end">
                        <button type="submit" onClick="this.disabled=true; this.form.submit();" class="btn btn-primary">
                            Tạo
                        </button>
                        <a href="{{ route('driver.admin.payment') }}" class="btn btn-danger">Quay lại</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">

        function check() {
            var phone = document.getElementById("phone").value;
            var go_id = document.getElementById("go_id").value;
            var url = "{{ route('driver.admin.payment_create_info', [':go_id', ':phone']) }}";
            url = url.replace(':phone', phone);
            url = url.replace(':go_id', go_id);
            location.href = url;

        }

    </script>

@endsection
