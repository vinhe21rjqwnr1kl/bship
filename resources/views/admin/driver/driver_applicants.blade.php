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
                        <form action="{{ route('driver.admin.applicants') }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="phone_number" class="form-control" placeholder="Số điện thoại"
                                           value="{{ old('phone_number', request()->input('phone_number')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="full_name" class="form-control" placeholder="Họ và tên"
                                           value="{{ old('full_name', request()->input('full_name')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="email" class="form-control" placeholder="Email"
                                           value="{{ old('email', request()->input('email')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <select name="identification" class="default-select form-control">
                                        <option value="">Trạng thái chia sẻ thông tin</option>
                                        <option {{ old('identification', request()->input('identification')) == 1 ? 'selected' : '' }} value="1">Có</option>
                                        <option {{ old('identification', request()->input('identification')) === 0 ?'selected' : '' }} value="0">Không</option>
                                    </select>
                                </div>
                                <div class="mb-6 col-md-6">
                                    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-1">
{{--                                    @can('Controllers > DriverController > handleExcelDrivers')--}}
{{--                                        <input type="submit" name="excel" value="Excel" class="btn btn-primary me-1"--}}
{{--                                               formaction="{{ route('driver.admin.excel_drivers') }}">--}}
{{--                                    @endcan--}}
                                    <a href="{{ route('driver.admin.applicants') }}" class="btn btn-danger">Nhập Lại</a>
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
                                    <th><strong> Tên </strong></th>
                                    <th><strong> SĐT </strong></th>
                                    <th><strong> Email </strong></th>
                                    <th><strong> Ngày sinh </strong></th>
                                    <th><strong> Địa chỉ sống </strong></th>
                                    <th><strong> TP sống </strong></th>
                                    <th><strong> Tình trạng </strong></th>
                                    <th><strong> Đã có </strong></th>
                                    <th><strong> Đồng ý chia sẻ thông tin </strong></th>
                                    <th><strong> Thời gian </strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $driver_applicants->firstItem();
                                @endphp
                                @forelse ($driver_applicants as $page)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $page->full_name }} </td>
                                        <td> {{ $page->phone_number }} </td>
                                        <td> {{ $page->email }} </td>
                                        <td> {{ $page->date_of_birth }}</td>
                                        <td> {{ $page->current_address }}</td>
                                        <td> {{ $page->current_city }}</td>
                                        <td> {{ $page->current_status }}</td>
                                        <td> {{ $page->identification }}</td>
                                        <td>
                                            @if ($page->agree_to_share_info == '1')
                                                <span class="badge badge-success">Có</span>
                                            @elseif($page->agree_to_share_info == '0')
                                                <span class="badge badge-danger">Không</span>
                                            @endif
                                        </td>
                                        <td> {{ $page->created_at }} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="11"><p>Không có dữ liệu.</p></td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $driver_applicants->onEachSide(2)->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
