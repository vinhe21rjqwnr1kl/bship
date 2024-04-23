{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('delivery_size.admin.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <div class="form-group col-md-6">
                                        <label>Mô tả</label>
                                        <input type="text" name="description" id="description" class="form-control"
                                               value="{{ old('description') }}">
                                        @error('description')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Chiều dài </label>
                                        <input type="text" name="length" id="length" class="form-control"
                                               autocomplete="length" value="{{ old('length') }}">
                                        @error('length')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Chiều rộng </label>
                                        <input type="text" name="width" id="width" class="form-control"
                                               autocomplete="width" value="{{ old('width') }}">
                                        @error('width')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Chiều cao </label>
                                        <input type="text" name="height" id="height" class="form-control"
                                               autocomplete="height" value="{{ old('height') }}">
                                        @error('height')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Cân nặng </label>
                                        <input type="text" name="weight" id="weight" class="form-control"
                                               autocomplete="weight" value="{{ old('weight') }}">
                                        @error('weight')
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
                        <a href="{{ route('delivery_size.admin.index') }}" class="btn btn-danger">Quay lại</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
