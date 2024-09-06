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
                        <form action="{{ route('admin.food_priority.index') }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="product_name" class="form-control"
                                           placeholder="Tên sản phẩm"
                                           value="{{ old('product_name', request()->input('product_name')) }}">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <input type="search" name="restaurant_name" class="form-control"
                                           placeholder="Tên nhà hàng"
                                           value="{{ old('restaurant_name', request()->input('restaurant_name')) }}">
                                </div>

                               


                             
                                <div class="mb-6 col-md-6">
                                    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary me-1">
                                    <a href="{{ route('admin.food_priority.index') }}" class="btn btn-danger">Nhập Lại</a>
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
                        @can('Controllers > NewsController > create')
                            <a href="{{ route('admin.food_priority.create') }}" class="btn btn-xs btn-primary">Tạo nhà hàng ưu tiên</a>
                        @endcan
                    </div>
                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead>
                                <tr>
                                    <th><strong> {{ __('common.s_no') }} </strong></th>
                                    <th><strong> Tên Sản Phẩm </strong></th>
                                    <th><strong> Tên nhà hàng </strong></th>
                                    <th><strong> Type </strong></th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $food_priority->firstItem();
                                @endphp
                                @forelse ($food_priority as $item)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                       
                                        
                                        <td> {{ $item->food_product->name ?? '-' }} </td>
                                        <td> {{ $item->restaurant->name ?? '-' }} </td>
                                        <td> {{ $item->type == 'Ads' ? $item->type : '-' }} </td>
                                          
                                        <td style="width: 80px; word-wrap: break-word;">
                                           
                                            <button type="button" class="btn btn-danger shadow btn-xs sharp"
                                                    onclick="confirmDelete({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <form id="delete-form-{{ $item->id }}" method="POST"
                                          action="{{ route('admin.food_priority.destroy', $item->id) }}" style="display: none;">
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
                        {{ $food_priority->appends(Request::input())->links() }}
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
