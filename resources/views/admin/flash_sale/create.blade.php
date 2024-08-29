{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin</h4>
            </div>
            <form action="{{ route('admin.flash_sale.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="basic-form">
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ old('title') }}">
                                        @error('title')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Loại</label>
                                        <select name="type" id="type" class="default-select form-control">
                                            @foreach($flashTypes as $key => $item)
                                                <option value="{{$key}}">{{$item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Trạng thái</label>
                                        <select name="status" id="status" class="default-select form-control">
                                            <option value="1"> Hiển thị</option>
                                            <option value="0">Không hiển thị</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="start_date">Bắt đầu</label>
                                        <input type="datetime-local" name="start_date" id="start_date"
                                               class="form-control"
                                               value="{{ old('start_date') }}">
                                        @error('start_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="end_date">Kết thúc</label>
                                        <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                                               value="{{ old('end_date') }}">
                                        @error('end_date')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="col-6 accordion__body p-4 collapse show" id="with-feature-image"
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
                    <a href="{{ route('admin.flash_sale.index') }}" class="btn btn-danger">Quay lại</a>
                </div>
            </form>
        </div>
    </div>

@endsection
