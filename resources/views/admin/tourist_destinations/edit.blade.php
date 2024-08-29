{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin</h4>
            </div>
            <form action="{{ route('admin.tourist_destinations.update', $model->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="basic-form">
                        <div class="row align-items-center">

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ $model->title }}">
                                        @error('title')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="index">Thứ tự ưu tiên</label>
                                        <input type="text" name="index" id="index" class="form-control"
                                               value="{{ $model->index }}">
                                        @error('index')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="latitude">Vĩ độ</label>
                                        <input type="text" name="latitude" id="latitude" class="form-control"
                                               value="{{ $model->latitude }}">
                                        @error('latitude')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="longitude">Kinh độ</label>
                                        <input type="text" name="longitude" id="longitude" class="form-control"
                                               value="{{ $model->longitude }}">
                                        @error('longitude')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="limit_radius">Giới hạn bán kính</label>
                                        <input type="text" name="limit_radius" id="limit_radius" class="form-control"
                                               value="{{ $model->limit_radius }}">
                                        @error('limit_radius')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Trạng thái</label>
                                        <select name="status" id="status" class="default-select form-control">
                                            <option {{ $model->status == 1 ? 'selected' : '' }} value="1"> Hiển thị</option>
                                            <option {{ $model->status == 0 ? 'selected' : '' }} value="0">Không hiển thị</option>
                                        </select>
                                    </div>
                                    <div class="accordion__body p-4 collapse show" id="with-feature-image"
                                         data-bs-parent="#accordion-feature-image">
                                        <div class="featured-img-preview img-parent-box">

                                            <img src="{{ $model->url ?? asset('images/noimage.jpg') }}" class="avatar img-for-onchange"
                                                 alt="{{ $model->title ?? __('common.image') }}" width="100px" height="100px"
                                                 title="{{ $model->title ?? __('common.image') }}">

                                            <div class="form-file">
                                                <input type="file" class="ps-2 form-control img-input-onchange"
                                                       name="data[meta][4][value]" accept=".png, .jpg, .jpeg"
                                                       id="BlogMeta4Value">
                                            </div>
                                        </div>
                                        @error('data.meta.1.value')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer pt-0 text-end">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.tourist_destinations.index') }}" class="btn btn-danger">Quay lại</a>
                </div>
            </form>
        </div>
    </div>

@endsection
