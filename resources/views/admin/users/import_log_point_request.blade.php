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
                    <div class="p-4">
                        <div class="featured-img-preview img-parent-box row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('admin.point.import_log_point_request') }}" method="post"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-12">
                                                <div class="form-file rounded">
                                                    <input type="file" class="ps-2 form-control rounded" name="excel_file"
                                                           accept=".xls, .xlsx">
                                                </div>
                                                @error('excel_file')
                                                <p class="text-danger">
                                                    {{ $message }}
                                                </p>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success mt-3">Import</button>
                                                <button type="submit" class="btn btn-primary mt-3"
                                                        formaction="{{ route('admin.point.import_log_point_request_template') }}">
                                                    Mẫu Import
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Bảng mã loại nạp điểm</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead class="">
                                                <tr>
                                                    <th><strong> STT</strong></th>
                                                    <th><strong> Mã </strong></th>
                                                    <th><strong> Mô tả </strong></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                @forelse ($types as $type)
                                                    <tr>
                                                        <td> {{ $i++ }} </td>
                                                        <td> {{ $type->code }} </td>
                                                        <td style="min-width: 150px; word-wrap: break-word;">
                                                            {{ $type->description }}
                                                        </td>
                                                    </tr>

                                                @empty
                                                    <tr>
                                                        <td class="text-center" colspan="10"><p>Không có dữ liệu.</p>
                                                        </td>
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
                </div>
            </div>
        </div>
@endsection
