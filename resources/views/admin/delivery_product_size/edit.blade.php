{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('delivery_size.admin.update', $size->id) }}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="basic-form">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Tên</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               autocomplete="name" value="{{ $size->name }}">
                                        @error('name')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tỉ lệ</label>
                                        <input type="text" name="ratio" id="ratio" class="form-control"
                                               value="{{ $size->ratio }}">
                                        @error('ratio')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Mô tả</label>
                                        <input type="text" name="description" id="description" class="form-control"
                                               value="{{ $size->description }}">
                                        @error('description')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Chiều dài </label>
                                        <input type="text" name="length" id="length" class="form-control"
                                               autocomplete="length" value="{{ $size->length }}">
                                        @error('length')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Chiều rộng </label>
                                        <input type="text" name="width" id="width" class="form-control"
                                               autocomplete="width" value="{{ $size->width }}">
                                        @error('width')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Chiều cao </label>
                                        <input type="text" name="height" id="height" class="form-control"
                                               autocomplete="height" value="{{ $size->height }}">
                                        @error('height')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Cân nặng </label>
                                        <input type="text" name="weight" id="weight" class="form-control"
                                               autocomplete="weight" value="{{ $size->weight }}">
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
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="{{ route('delivery_size.admin.index') }}" class="btn btn-danger">Quay lại</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
