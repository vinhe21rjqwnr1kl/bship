{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6 p-0">
            <div class="welcome-text">
                <h4>{{ __('common.configurations') }}</h4>
                <span>{{ Str::ucfirst($prefix) }} {{ __('common.configurations') }}</span>
            </div>
        </div>
        <div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.configurations.admin_index') }}">{{ __('common.configurations') }}</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ Str::ucfirst($prefix) }}</a></li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('common.settings') }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('admin.configurations.admin_settings') }}" method="post">
                       	 	@csrf
                            <div class="form-group row">
                            	<div class="col-sm-12 form-group">	                                					
									<div class="form-check">
										<input type="checkbox" class="form-check-input" name="storage_link" id="storage_link">
										<label class="form-check-label" for="storage_link">{{ __('common.storage_link_description') }}</label>
									</div>
																																		
									<div class="form-check">
										<input type="checkbox" class="form-check-input" name="clear_cache" id="clear_cache">
										<label class="form-check-label" for="clear_cache">{{ __('common.clear_cache') }}</label>
									</div>
                          	  	</div>
                            </div>
                            <div class="form-group row ">
                            	<div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection