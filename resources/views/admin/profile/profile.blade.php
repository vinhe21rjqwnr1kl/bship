{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    @if (session('status') == "two-factor-authentication-disabled")
        <div class="alert alert-danger" role="alert">
            {{ __('common.2fa_disabled_text') }}
        </div>
    @endif
    
    @if (session('status') == "two-factor-authentication-enabled")
        <div class="alert alert-success" role="alert">
            {{ __('common.2fa_enabled_text') }}
        </div>
    @endif



    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Thông tin</h4>
        </div>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="basic-form">
                    <div class="row align-items-center ">
                        <div class="col-sm-4 text-center">

                            <div class="custom-img-upload img-parent-box mb-2">
                                    
                                <img src="{{ HelpDesk::user_img($user->profile) }}" class="img-for-onchange" id="RemoveProfile_{{ $user->id }}" alt="{{ __('common.user_profile') }}">
                                
                                <div class="upload-btn">

                                    @if ($user->profile)
                                        <a href="javascript:void(0);" rdx-link="{{ route('admin.user.remove_user_image', $user->id) }}" class="rdxUpdateAjax btn btn-primary btn-xs me-1" rdx-delete-box="RemoveProfile_{{ $user->id }}">{{ __('common.remove') }}</a>
                                    @endif

                                    <input type="file" class="form-file-input form-control ps-2 img-input-onchange" name="user_img" id="user_img" accept=".png, .jpg, .jpeg" hidden>
                                    <label class="upload-label btn btn-xs btn-primary m-0" for="user_img">{{ __('common.upload') }}</label>
                                </div>
                                @error('user_img')
                                    <p class="text-danger">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Họ</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" autocomplete="first_name" value="{{ old('first_name', $user->first_name) }}">
                                    @error('first_name')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>Tên</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                                    @error('last_name')
                                        <p class="text-danger">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label>{{ __('common.email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    @error('email')
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
                <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Quay lại</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Mật khẩu</h4>
        </div>
        <form action="{{ route('admin.users.update-password', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="basic-form">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{ __('common.password') }}</label>
                            <div class="input-group">
                                <input type="password" name="password" id="dz-password" class="form-control valid" autocomplete="new-password">
                                <span class="input-group-text show-pass border-left-end"> 
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group  col-md-6">
                            <label>{{ __('common.confirm_password') }}</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" id="dz-con-password" class="form-control">
                                <span class="input-group-text show-con-pass"> 
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            @error('confirm_password')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-danger">Quay lại</a>
            </div>
        </form>
    </div>

    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('common.two_factor_authentication') }}</h4>
        </div>
        <div class="card-body">
            <form method="post" action="{{ url('/user/two-factor-authentication') }}">
                @csrf
                    @if (auth()->user()->two_factor_secret)
                        @method('DELETE')
                        <div class="row">
                            <div class="col-md-6">
                                <h3>{{ __('common.recovery_code') }}</h3>
                                <ul class="list-group mb-2">
                                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                                    <li class="list-group-item">{{ $code }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-6 text-center">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}                                
                            </div>
                        </div>
                        <button class="btn btn-danger"> {{ __('common.disable') }} </button>
                    @else
                        <button class="btn btn-success"> {{ __('common.enable ') }}</button>
                    @endif
            </form>
            @if (auth()->user()->two_factor_secret)
                <form method="post" action="{{ url('/user/two-factor-recovery-codes') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <button type="submit" class="btn btn-primary">{{ __('common.regenerate_recovery_codes') }}</button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection