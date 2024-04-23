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
                    <h4 class="card-title">{{ __('common.reading_configuration') }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form action="{{ route('admin.configurations.admin_reading') }}" method="post" id="reading-filters" enctype="multipart/form-data">
                       	 	@csrf		
                       	 	<div class="form-group row">
                   	 			<label class="col-sm-3 col-form-label">{{ __('common.nodes_per_page') }}</label>
                    			<div class="col-sm-6 form-group">	                      	
									<input type="text" name="Reading[nodes_per_page]"  class="form-control" value="{{ config('Reading.nodes_per_page') }}">
	                            </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('common.date_time_format') }}</label>
                            	<div class="col-sm-6 form-group">
									<input type="text" name="Reading[date_time_format]" class="form-control" value="{{ config('Reading.date_time_format') }}">
									<small class="d-block">{{ __('common.Formates') }} :-<br>
										{{ __('F j, Y, g:i a (November 23, 2022, 5:45 am)') }}, <br>
										{{ __('Y-m-d , H:i (2022-11-23, 05:45)') }}, <br>
										{{ __('m/d/Y (11/23/2022)') }}, <br>
										{{ __('d/m/Y(23/11/2022)') }}
									</small>
	                            </div>
                            </div>
                            <div class="form-group row">
                            	<label class="col-sm-3 col-form-label">{{ __('common.show_on_front') }}</label>
                            	<div class="col-sm-6 form-group">	                                					
									<div class="form-check">
										<input type="radio" class="form-check-input ReadingPostBtn" name="Reading[show_on_front]" id="show_on_front_post" value="Post" {{ (config('Reading.show_on_front') == 'Post') ? 'checked' : '' }}>
										<label class="form-check-label" for="show_on_front_post">{{ __('common.post') }}</label>
									</div>
																																		
									<div class="form-check">
										<input type="radio" class="form-check-input ReadingPostBtn" name="Reading[show_on_front]" id="show_on_front_page" value="Page" {{ (config('Reading.show_on_front') == 'Page') ? 'checked' : '' }}>
										<label class="form-check-label" for="show_on_front_page">{{ __('common.page') }}</label>
									</div>
									<div id="page-filters" class="reading-filters {{ (config('Reading.show_on_front') == 'Post') ? 'd-none' : '' }}">
										<select name="Reading[home_page]" class="form-control default-select">
											@forelse($pages as $page)
												<option {{ (config('Reading.home_page') == $page->slug) ? 'selected' : '' }} value="{{ $page->slug }}">{{ $page->title }}</option>
											@empty
											@endforelse
										</select>
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