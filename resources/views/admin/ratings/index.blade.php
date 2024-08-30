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
                        <form action="{{ route('admin.ratings.index') }}" method="get">
                            @csrf
                            <input type="hidden" name="todo" value="Filter">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <input type="search" name="keyword" class="form-control"
                                           placeholder="Email"
                                           value="{{ old('keyword', request()->input('keyword')) }}">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <input type="search" name="name" class="form-control"
                                           placeholder="Tên nhà hàng"
                                           value="{{ old('name', request()->input('name')) }}">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <input type="search" name="comment" class="form-control"
                                           placeholder="Bình luận"
                                           value="{{ old('comment', request()->input('comment')) }}">
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
                                    <a href="{{ route('admin.ratings.index') }}" class="btn btn-danger">Nhập Lại</a>
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
                      
                    </div>
                    <div class="pe-4 ps-4 pt-2 pb-2">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead>
                                <tr>
                                    <th><strong> {{ __('common.s_no') }} </strong></th>
                                    <th><strong> Hình </strong></th>
                                    <th><strong> Email </strong></th>
                                    <th><strong> Tên nhà hàng </strong></th>
                                    <th><strong> Sao </strong></th>
                                    <th><strong> Ngày tạo </strong></th>
                                    <th><strong> Ngày cập nhật</strong></th>
                                    <th><strong> Bình luận</strong></th>
                                    <th><strong> Trạng thái</strong></th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = $ratings->firstItem();
                                @endphp
                                @forelse ($ratings as $item)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td>
                                            <!-- Kiểm tra và giải mã JSON -->
                                            @if ($item->images)
                                            @php
                                                // Giải mã chuỗi JSON thành mảng
                                                $images = json_decode($item->images, true);

                                                // Kiểm tra xem kết quả có phải là mảng không
                                                $isArray = is_array($images);
                                            @endphp

                                            <!-- Icon Box -->
                                            <div class="icon-box" data-bs-toggle="modal" data-bs-target="#modal-{{ $item->id }}">
                                                <i class="fa fa-image btn btn-danger shadow btn-xs sharp"></i> <!-- Ví dụ icon -->
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="modal-{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel-{{ $item->id }}">Hình ảnh</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                                                            <!-- Kiểm tra nếu $images là mảng trước khi lặp qua -->
                                                            @if ($isArray)
                                                                <div class="container">
                                                                    <div class="row">
                                                                        @foreach ($images as $index => $image)
                                                                            <div class="col-6 col-md-4 mb-2">
                                                                                <img src="{{ $image }}" class="img-fluid" alt=""/>
                                                                            </div>

                                                                           

                                                                        
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p>No images available</p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger shadow" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif


                                        </td>
                                        
                                        <td> {{ $item->user->email ?? '-' }} </td>
                                        <td> {{ $item->restaurant->name ?? '-' }} </td>
                                        <td> {{ $item->stars ?? '-' }} </td>
                                        <td> {{ $item->created_at ?? '-' }} </td>
                                        <td> {{ $item->updated_at ?? '-' }} </td>
                                        <td> {{ $item->comment ?? '-' }} </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-success" id="status-badge-{{ $item->id }}"> Hiển thị </span>
                                            @else
                                                <span class="badge badge-warning" id="status-badge-{{ $item->id }}"> Không hiển thị</span>
                                            @endif
                                        </td>
                                        

                                       
                                        <td style="width: 80px; word-wrap: break-word;">
                                            <a href="javascript:void(0);" 
                                            class="btn btn-primary shadow btn-xs sharp me-1 edit-status"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger shadow btn-xs sharp"
                                                    onclick="confirmDelete({{ $item->id }})">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <form id="delete-form-{{ $item->id }}" method="POST"
                                          action="{{ route('admin.ratings.destroy', $item->id) }}" style="display: none;">
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
                        {{ $ratings->appends(Request::input())->links() }}
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

        $(document).ready(function() {
        $('.edit-status').on('click', function() {
            var ratingId = $(this).data('id');

            $.ajax({
                url: '{{ route("update-status") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ratingId,
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#status-badge-' + ratingId).removeClass('badge-warning').addClass('badge-success').text('Hiển thị');
                    } else {
                        $('#status-badge-' + ratingId).removeClass('badge-success').addClass('badge-warning').text('Không hiển thị');
                    }
                },
                error: function() {
                    alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                }
            });
        });
    });
    </script>
@endpush
