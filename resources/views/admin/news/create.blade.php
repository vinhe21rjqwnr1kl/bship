{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin</h4>
            </div>
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="basic-form">
                        <div class="row align-items-center">

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="form-group col-12">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ old('title') }}">
                                        @error('title')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="news_url">Đường dẫn</label>
                                        <input type="text" name="news_url" id="news_url" class="form-control"
                                               value="{{ old('news_url') }}">
                                        @error('news_url')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="find_index">Thứ tự ưu tiên <span class="text-danger">(Số càng lớn độ ưu tiên càng cao)</span></label>
                                        <input type="text" name="find_index" id="find_index" class="form-control"
                                               value="{{ old('find_index') }}">
                                        @error('find_index')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label>Trạng thái</label>
                                        <select name="status" id="status" class="default-select form-control">
                                            <option value="1"> Hiển thị</option>
                                            <option value="0">Không hiển thị</option>
                                        </select>
                                    </div>
                                    <div class="accordion__body p-4 collapse show" id="with-feature-image"
                                         data-bs-parent="#accordion-feature-image">
                                        <div class="featured-img-preview img-parent-box">

                                            <img src="{{ asset('images/noimage.jpg') }}" class="avatar img-for-onchange"
                                                 alt="{{ __('common.image') }}" width="100px" height="100px"
                                                 title="{{ __('common.image') }}">

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
                    <button type="submit" class="btn btn-primary">Tạo</button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-danger">Quay lại</a>
                </div>
            </form>
        </div>
    </div>

@endsection
