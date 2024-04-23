@extends('admin.layout.fullwidth')

@section('content')

    
<div class="col-xl-12 mt-3">
    <div class="card">
        <div class="card-body p-0">
            <div class="row m-0">
                <div class="col-xl-6 col-md-6 sign text-center">
                    <div>
                        <div class="text-center my-5">
                            <img class="logo-abbr max-width-180" src="{{ DzHelper::siteLogo() }}" alt="{{ __('common.logo') }}">
                        </div>
                        <img src="{{ asset('images/log.png') }}" class="education-img w-100">
                    </div>  
                </div>
                <div class="col-md-6 authincation-content">
                    <div class="">
                        <div class="row no-gutters">
                            <div class="auth-form">
                                
                                <h4 class="">Đăng nhập</h4>
                                <span class="fs-14 d-block mb-4"> Chào mừng bạn quay chở lại với công cụ quản lý của BUTL</span>
                                <form method="POST" action="{{ route('admin.login') }}">
                                    @csrf

                                    <div class="form-group ">
                                        <label for="login_email" class="mb-1"><strong>{{ __('common.email') }}</strong></label>
                                        <input id="login_email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                                                   value="{{ old('email') }}" required>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="login_password" class="mb-1"><strong>Mật khẩu</strong></label>
                                        <input id="login_password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                           <div class="custom-control custom-checkbox ms-1">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">
                                                   Ghi nhớ đăng nhập
                                                </label>

                                            </div>
                                        </div>
                                        <!--div class="form-group">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">
                                                    {{ __('passwords.forgot_pass') }}
                                                </a>
                                            @endif
                                        </di-->
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                                    </div>
                                </form>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection