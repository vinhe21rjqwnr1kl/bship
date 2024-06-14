{{--<script>--}}
{{--var raw = "{\n    \"cmd\":\"doReloadConfig\",\n    \"data\":{\n    }\n}";--}}

{{--var requestOptions = {--}}
{{--  method: 'POST',--}}
{{--  body: raw,--}}
{{--  redirect: 'follow'--}}
{{--};--}}


{{--fetch("https://api-khachv2.bship.vn/ButlAppServlet/app/services", requestOptions)--}}
{{--  .then(response => response.text())--}}
{{--  .then(result => console.log(result))--}}
{{--  .catch(error => console.log('error', error));--}}


{{--    var theUrl ="http://61.28.226.78:22072/api/v1/web/reloadConfig";--}}
{{--    var xmlHttp = new XMLHttpRequest();--}}
{{--    xmlHttp.open( "GET", theUrl, false ); // false for synchronous request--}}
{{--    xmlHttp.send( null );--}}
{{--    return xmlHttp.responseText;--}}


{{--</script>--}}


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
                        <h4 class="card-title">Cập nhật Cache</h4>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title"></h4>

                        @if($response['code'] == 1)
                            <div class="container-fluid">
                                <div class="alert alert-success alert-dismissible alert-alt fade show">
                                    <strong>{{ __('common.success') }}</strong> {{ __('Service cache reloaded successfully') }}
                                </div>
                            </div>
                            @else
                            <div class="container-fluid">
                                <div class="alert alert-danger alert-dismissible alert-alt fade show">
                                    <strong>{{ __('common.error') }}</strong> {{ __('Service cache reload failed') }}
                                </div>
                            </div>
                        @endif

                        @if($response2['code'] == 1)
                            <div class="container-fluid">
                                <div class="alert alert-success alert-dismissible alert-alt fade show">
                                    <strong>{{ __('common.success') }}</strong> {{ __('Reload cache configuration successfully') }}
                                </div>
                            </div>
                        @else
                            <div class="container-fluid">
                                <div class="alert alert-danger alert-dismissible alert-alt fade show">
                                    <strong>{{ __('common.error') }}</strong> {{ __('Reload cache configuration failed') }}
                                </div>
                            </div>
                        @endif

                        @can('Controllers > UsersController > create')
                            {{--					<a href="{{ route('price.admin.km') }}" class="btn btn-primary">Quay lại</a>--}}
                        @endcan
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
