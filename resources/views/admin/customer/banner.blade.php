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



    <!-- row -->
    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"></h4>
                    @can('Controllers > UsersController > create')
                        <a href="{{ route('custumer.admin.bannercreate') }}" class="btn btn-primary">Tạo Banner</a>
                    @endcan
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> {{ __('common.s_no') }} </strong> </th>
                                    <th> <strong> Hình </strong> </th>
                                    <th> <strong> Thứ tự </strong> </th>
                                    <th> <strong> Trạng thái</strong> </th>

                                    <th class="text-center"> <strong> Thao tác </strong> </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $banner->firstItem();
                                @endphp
                                @forelse ($banner as $banners)
                                <tr>
                                    <td> {{ $i++ }} </td>
                                    <td> <img src="{{ $banners->url }}" width="70" height="50"></td>
{{--                                    <td> <img src="https://daily.bship.vn/public/uploads/20240423/d8fa4e87353f13660a17587c10e856ff.jpg" width="70" height="50"></td>--}}
                                    <td> {{ $banners->index }} </td>
                                    <td>
                                        @if ($banners->status == 1)
                                            <span class="badge badge-success"> Hiển thị </span>
                                        @else
                                            <span class="badge badge-warning"> Không hiển thị</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
												<a href="{{ route('custumer.admin.bannerdelete', $banners->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                   	 </td>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('common.no_users') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $banner->appends(Request::input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
