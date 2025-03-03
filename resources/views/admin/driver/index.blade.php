{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">


        @php
            $collapsed = 'collapsed';
            $show = '';
        @endphp

        @if(!empty(request()->title) || !empty(request()->category) || !empty(request()->user) || !empty(request()->status) || !empty(request()->from) || !empty(request()->to) || !empty(request()->tag) || !empty(request()->visibility) || !empty(request()->publish_on))
            @php
                $collapsed = '';
                $show = 'show';
            @endphp
        @endif

        <!-- row -->
        <!-- Row starts -->
        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                    <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse"
                         data-bs-target="#rounded-search-sec">
                        <span class="accordion-header-icon"></span>
                        <h4 class="accordion-header-text m-0">Tìm kiếm</h4>
                        <span class="accordion-header-indicator"></span>
                    </div>
                    <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec"
                         data-bs-parent="#search-sec-outer">
                        <form action="{{ route('driver.admin.index') }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="phone" class="form-control" placeholder="Số điện thoại"
                                           value="{{ old('phone', request()->input('phone')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="name" class="form-control" placeholder="Họ và tên"
                                           value="{{ old('name', request()->input('name')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <select name="is_active" class="default-select form-control">
                                        <option value="">Trạng thái</option>
                                        <option value="1">Hoạt động</option>
                                        <option value="2">Ngừng Hoạt động</option>
                                    </select>
                                </div>
                                <div class="mb-6 col-md-6">
                                    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-1">
                                    @can('Controllers > DriverController > handleExcelDrivers')
                                        <input type="submit" name="excel" value="Excel" class="btn btn-primary me-1"
                                               formaction="{{ route('driver.admin.excel_drivers') }}">
                                    @endcan
                                    <a href="{{ route('driver.admin.index') }}" class="btn btn-danger">Nhập Lại</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead class="">
                                <tr>
                                    <th><strong> STT</strong></th>
                                    <th><strong> Họ và Tên </strong></th>
                                    <th><strong> SĐT </strong></th>
                                    <th><strong> Tiền </strong></th>
                                    <th><strong> Đại lý </strong></th>
                                    <th><strong> OTP </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                    <th><strong> Thao tác </strong></th>
{{--                                    <th><strong> Sync GSM </strong></th>--}}
{{--                                    <th><strong> Trạng thái GSM </strong></th>--}}
                                    <th><strong> Dịch vụ </strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $drivers->firstItem();
                                @endphp
                                @forelse ($drivers as $page)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $page->user_name }} </td>
                                        <td> {{ $page->phone }} </td>
                                        <td> {{ number_format($page->money) }} </td>
                                        <td> {{ $roleArr[$page->agency_id] }}</td>
                                        <td> {{ $page->otp }}</td>
                                        <td>
                                            @if ($page->is_active == '1')
                                                <span class="badge badge-success">Hoạt động</span>
                                            @elseif($page->is_active == '2')
                                                <span class="badge badge-danger">Ngừng hoạt động</span>
                                            @endif
                                        </td>
                                        <td> {{ $page->create_time }} </td>
                                        <td class="text-center">
                                            <a href="{{ route('driver.admin.edit', $page->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                        </td>
{{--                                        <td class="text-center">--}}
{{--                                            <form action="{{ route('driver.admin.sync-driver-gsm', $page->id) }}"--}}
{{--                                                  method="POST" style="display: inline;">--}}
{{--                                                @csrf--}}
{{--                                                <button type="submit"--}}
{{--                                                        class="btn btn-primary shadow btn-xs sharp me-1">--}}
{{--                                                    <i class="fas fa-sync"></i>--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            @if ($page->user_gsm_id && $page->user_gsm_id != 1)--}}
{{--                                                <span class="badge badge-success">Đã đồng bộ</span>--}}
{{--                                            @else--}}
{{--                                                <span class="badge badge-danger">Chưa đồng bộ</span>--}}
{{--                                            @endif--}}
{{--                                        </td>--}}
                                        <td class="text-center">
                                            <a href="{{ route('driver.admin.drservice', $page->id) }}"
                                               class="badge badge-primary">Đăng ký</a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="9"><p>Không có dữ liệu.</p></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $drivers->onEachSide(2)->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
