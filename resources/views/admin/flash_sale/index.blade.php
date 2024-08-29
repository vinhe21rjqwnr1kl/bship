{{-- Extends layout --}}
@extends('admin.layout.default')
{{-- Content --}}
@section('content')
    <div class="container-fluid">
        @php
            $collapsed = 'collapsed';
            $show = '';
        @endphp

        @if(!empty(request()->keyword) || !empty(request()->status))
            @php
                $collapsed = '';
                $show = 'show';
            @endphp
        @endif

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
                        <form action="{{ route('admin.flash_sale.index') }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="title" class="form-control"
                                           placeholder="Tiêu đề"
                                           value="{{ old('title', request()->input('title')) }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <select name="status" class="default-select form-control">
                                        <option value="">Trạng thái</option>
                                        <option {{ request()->input('status') === '1' ? "selected" : "" }} value="1">
                                            Hiển thị
                                        </option>
                                        <option {{ request()->input('status') === '0' ? "selected" : "" }} value="0">
                                            Không hiển thị
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-6 col-md-6">
                                    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-1">
                                    <a href="{{ route('admin.flash_sale.index') }}" class="btn btn-danger">Nhập Lại</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"></h4>
                        @can('Controllers > FlashSaleController > create')
                            <a href="{{ route('admin.flash_sale.create') }}" class="btn btn-xs btn-primary">Tạo flash sale</a>
                        @endcan
                    </div>
                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead>
                                <tr>
                                    <th><strong> {{ __('common.s_no') }} </strong></th>
                                    <th><strong> Hình </strong></th>
                                    <th><strong> Tiêu đề </strong></th>
                                    <th><strong> Loại </strong></th>
                                    <th><strong> Trạng thái </strong></th>
                                    <th><strong> Bắt đầu </strong></th>
                                    <th><strong> Kết thúc </strong></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $falseSale->firstItem();
                                @endphp
                                @forelse ($falseSale as $item)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td><img src="{{ $item->banner }}" width="70" height="50"
                                                 alt="{{$item->title}}"/></td>
                                        <td> {{ $item->title ?? '-' }} </td>
                                        <td> {{ $item->type ?? '-' }} </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-success"> Hiển thị </span>
                                            @else
                                                <span class="badge badge-warning"> Không hiển thị</span>
                                            @endif
                                        </td>
                                        <td> {{ $item->start_date ?? '-' }} </td>
                                        <td> {{ $item->end_date ?? '-' }} </td>
                                        <td style="width: 80px; word-wrap: break-word;">
                                            <a href="{{ route('admin.flash_sale.edit', $item->id) }}"
                                               class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            <button type="button" class="btn btn-danger shadow btn-xs sharp"
                                                    onclick="confirmDelete({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <form id="delete-form-{{ $item->id }}" method="POST"
                                          action="{{ route('admin.flash_sale.destroy', $item->id) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
                        {{ $falseSale->appends(Request::input())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('inline-scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Bạn sẽ không thể hoàn tác hành động này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4CCD7F',
                cancelButtonColor: '#FF4C41',
                confirmButtonText: 'Xác nhận!',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
