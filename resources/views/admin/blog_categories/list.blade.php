{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('common.blog_categories') }}</h4>
				<span>{{ __('common.all_blog_categories') }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('blog_category.admin.index') }}">{{ __('common.blog_categories') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_blog_categories') }}</a></li>
			</ol>
		</div>
	</div>


	<div class="row">
		<div class="col-md-4">
			<div class="row">
                <!-- Column starts -->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-block">
                        	@if($blogCategory->id)
                            	<h4 class="card-title">{{ __('common.edit_blog_category') }}</h4>
                            @else
                            	<h4 class="card-title">{{ __('common.add_blog_category') }}</h4>
                        	@endif
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <label for="parent_id">{{ __('common.parent_blog_category') }}</label>
                                        <select name="parent_id" id="parent_id" class="default-select form-control">
                                            <option value="">{{ __('common.no_parent') }}</option>
                                            @forelse($blog_categories as $blog_categorie)
                                                <option value="{{ $blog_categorie['id'] }}" {{ old('parent_id', $blogCategory->parent_id) == $blog_categorie['id'] ? 'selected="selected"' : '' }}>{{ $blog_categorie['title'] }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">{{ __('common.title') }}</label>
                                        <input type="text" name="title" id="BlogTitle" class="form-control" placeholder="{{ __('common.title') }}" value="{{ old('title', $blogCategory->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">{{ __('common.slug') }}</label>
                                        <input type="text" name="slug" class="slug form-control" id="BlogSlug" placeholder="{{ __('common.slug') }}" value="{{ old('slug', $blogCategory->slug) }}" required>
                                        @error('slug')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                    	<label for="description">{{ __('common.description') }}</label>
                                    	<textarea name="description" id="description" class="form-control h-100" rows="5">{{ old('description', $blogCategory->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input type="hidden" name="blog_id" value="{{ $blogCategory->id }}">
                                <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-md-8">
			<div class="row">
				<!-- Column starts -->
				<div class="col-xl-12">
					<div class="card">
						<div class="card-header d-block">
							<h4 class="card-title">{{ __('common.blog_categories') }}</h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-responsive-md mb-0">
									<thead>
										<tr>
											<th> <strong> {{ __('S.N.') }} </strong> </th>
											<th> <strong> {{ __('common.name') }} </strong> </th>
											<th> <strong> {{ __('common.blog_count') }} </strong> </th>
											<th> <strong> {{ __('common.created') }} </strong> </th>
											<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
										</tr>
									</thead>
									<tbody>
										@php
											$i = $blog_categories ? $blog_categories->firstItem() : 0;
										@endphp
										@forelse ($blog_categories as $blog_category)
											<tr>
												<td> {{ $i++ }} </td>
												<td> {{ $blog_category['title'] }} </td>
												<td> <span class="badge bg-primary">{{ $blog_category['blog_count'] }}</span> </td>
												<td> {{ $blog_category['created_at'] }} </td>
												<td class="text-center">
													<a href="{{ route('blog_category.admin.list', $blog_category['id']) }}" class="btn btn-primary shadow btn-xs sharp me-1" title="{{ __('common.edit') }}"><i class="fas fa-pencil-alt"></i></a>
													<a href="{{ route('blog_category.admin.destroy', $blog_category['id']) }}" class="btn btn-danger shadow btn-xs sharp" title="{{ __('common.delete') }}"><i class="fa fa-trash"></i></a>
												</td>
											</tr>
										@empty
											<tr><td class="text-center" colspan="5"><p>{{ __('common.no_blog_categories') }}</p></td></tr>
										@endforelse

									</tbody>
								</table>
							</div>
						</div>
						<div class="card-footer">
							{{ $blog_categories ? $blog_categories->onEachSide(1)->links() : '' }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


@endsection