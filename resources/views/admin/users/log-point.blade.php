{{-- Extends layout --}}
@extends('admin.layout.default')
{{-- Content --}}
@section('content')
    <div class="container-fluid">
        @php
            $collapsed = 'collapsed';
            $show = '';
        @endphp

        @if(!empty(request()->name) || !empty(request()->email) || !empty(request()->role))
            @php
                $collapsed = '';
                $show = 'show';
            @endphp
        @endif

        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                    <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
                        <span class="accordion-header-icon"></span>
                        <h4 class="accordion-header-text m-0">Tìm Kiếm</h4>
                        <span class="accordion-header-indicator"></span>
                    </div>
                    <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                        {{ Form::model(request()->all(), array('route' => array('admin.point.log'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('phone', null, array('class' => 'form-control', 'placeholder' => __('SĐT'))) }}
                            </div>

                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="{{ __('Tìm') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.point.log') }}" class="btn btn-danger">Quay lại</a>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card">

                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead>
                                <tr>
                                    <th> <strong> {{ __('common.s_no') }} </strong> </th>
                                    <th> <strong> SĐT </strong> </th>
                                    <th> <strong> Điểm giao dịch </strong> </th>
{{--                                    <th> <strong> Điểm sở hữu </strong> </th>--}}
                                    <th> <strong> Lý do </strong> </th>
                                    <th> <strong> Ngày tạo </strong> </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $logPoints->firstItem();
                                @endphp
                                @forelse ($logPoints as $log)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $log->user_data->phone }} </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $log->point }}</span>
                                        </td>
{{--                                        <td>--}}
{{--                                            <span class="badge badge-primary">{{ $log->user_data->points }}</span>--}}
{{--                                        </td>--}}
                                        <td style="max-width: 500px;"> {{ $log->reason }} </td>
                                        <td> {{ $log->created_at }} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('Nhật ký trống') }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $logPoints->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
