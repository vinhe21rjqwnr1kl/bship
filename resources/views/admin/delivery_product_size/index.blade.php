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

        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"></h4>
                        @can('Controllers > UsersController > create')
                            <a href="{{ route('delivery_size.admin.create') }}" class="btn btn-primary">Tạo kích thước
                                sản phẩm vận chuyển</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-lg mb-0">
                                <thead class="">
                                <tr>
                                    <th><strong> STT</strong></th>
                                    <th><strong> Tên </strong></th>
                                    <th><strong> Tỉ lệ </strong></th>
                                    <th><strong> Mô tả </strong></th>
                                    <th><strong> Chiều dài </strong></th>
                                    <th><strong> Chiều rộng </strong></th>
                                    <th><strong> Chiều cao </strong></th>
                                    <th><strong> Cân nặng </strong></th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($sizes as $size)
                                    <tr>
                                        <td> {{ $i++ }} </td>
                                        <td> {{ $size->name }} </td>
                                        <td> {{ $size->ratio }} </td>
                                        <td> {{ $size->description }} </td>
                                        <td> {{ $size->length }} </td>
                                        <td> {{ $size->width }} </td>
                                        <td> {{ $size->height }} </td>
                                        <td> {{ $size->weight }} </td>
                                        <td class="text-center ">
                                            @can('Controllers > UsersController > edit')
                                                <a href="{{ route('delivery_size.admin.edit', $size->id) }}"
                                                   class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('Controllers > UsersController > destroy')
                                                <button type="button" class="btn btn-danger shadow btn-xs sharp me-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal" data-bs-id="{{$size->id}}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7"><p>Không có dữ liệu.</p></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Modal drop trash--}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h4 style="margin: 10px 0 0 0;">Xác nhận xóa dữ liệu?</h4>
                </div>
                <div class="modal-footer">
                    <a href="#" id="deleteLink" class="btn btn-danger shadow btn-s sharp me-1"><i
                            class="fa fa-trash"></i></a>
                    <button type="button" class="btn btn-secondary shadow btn-s sharp me-1" data-bs-dismiss="modal"><i
                            class="fa fa-times-circle"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget
            var id = button.getAttribute('data-bs-id')
            var deleteLink = document.getElementById('deleteLink');
            var deleteLinkHref = "{{ route('delivery_size.admin.destroy', ':id') }}";
            deleteLinkHref = deleteLinkHref.replace(':id', id);
            deleteLink.setAttribute('href', deleteLinkHref);
        })
    </script>
@endsection
