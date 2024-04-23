{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('delivery_type.admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="basic-form">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Tên</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               autocomplete="name" value="{{ old('name') }}">
                                        @error('name')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tỉ lệ</label>
                                        <input type="text" name="ratio" id="ratio" class="form-control"
                                               value="{{ old('ratio') }}">
                                        @error('ratio')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Trạng thái</label>
                                        <select name="status" id="status" class="default-select form-control">
                                            <option value="1"> Hoạt động</option>
                                            <option value="0" selected="selected"> Ngừng hoạt động</option>
                                        </select>
                                        @error('status')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Dịch vụ</label>
                                        <select name="service_detail_id" id="service_detail_id" class="default-select form-control">
                                            <option value="0">-- Chọn dịch vụ --</option>
                                            @forelse($ServicesDetailArr as $services)
                                                <option value="{{ $services->id }}">{{ $ServicesArr[$services->service_id] }} -- {{ $ServicesTypeArr[$services->service_type] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @error('service_detail_id')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Tạo</button>
                        <a href="{{ route('delivery_type.admin.index') }}" class="btn btn-danger">Quay lại</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
