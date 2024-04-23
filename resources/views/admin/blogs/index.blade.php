{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">
	<div class="row page-titles mx-0 mb-3">
		<div class="col-sm-6 p-0">
			<div class="welcome-text">
				<h4>{{ __('common.blogs') }}</h4>
				<span>{{ __('common.all_blogs') }}</span>
			</div>
		</div>
		<div class="col-sm-6 p-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('blog.admin.index') }}">{{ __('common.blogs') }}</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('common.all_blogs') }}</a></li>
			</ol>
		</div>
	</div>

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

	<!-- row -->
	<!-- Row starts -->
	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
				<div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
					<span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">{{ __('common.search_blogs') }}</h4>
                    <span class="accordion-header-indicator"></span>
				</div>
				<div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
					<form action="{{ route('blog.admin.index') }}" method="get">
					@csrf
						<input type="hidden" name="todo" value="Filter">
						<div class="row">
							<div class="mb-3 col-md-3">
								<input type="search" name="title" class="form-control" placeholder="{{ __('common.title') }}" value="{{ old('title', request()->input('title')) }}">
							</div>
							<div class="mb-3 col-md-3">
								<select name="user" class="default-select form-control">
									<option value="">{{ __('common.select_author') }}</option>
									@if(!empty($users))
										@forelse($users as $user)
											<option value="{{ $user->id }}" {{ old('user', request()->input('user')) == $user->id ? 'selected="selected"' : '' }}>{{ $user->name }}</option>
										@empty
										@endforelse
									@endif
								</select>
							</div>
							<div class="mb-3 col-md-3">
								<select name="category" class="default-select form-control">
									<option value="">{{ __('common.select_category') }}</option>
									@if(!empty($blog_categories))
										@forelse($blog_categories as $blog_category)
											<option value="{{ $blog_category->id }}" {{ old('category', request()->input('category')) == $blog_category->id ? 'selected="selected"' : '' }}>{{ $blog_category->title }}</option>
										@empty
										@endforelse
									@endif
								</select>
							</div>
							<div class="mb-3 col-md-3">
								<select name="tag" class="default-select form-control">
									<option value="">{{ __('common.select_tags') }}</option>
									@if(!empty($blog_tags))
										@forelse($blog_tags as $blog_tag)
											<option value="{{ $blog_tag->id }}" {{ old('tag', request()->input('tag')) == $blog_tag->id ? 'selected="selected"' : '' }}>{{ $blog_tag->title }}</option>
										@empty
										@endforelse
									@endif
								</select>
							</div>
							<div class="mb-3 col-md-3">
								<select name="visibility" class="default-select form-control">
									<option value="">{{ __('common.select_visibility') }}</option>
									<option value="Pu" {{ old('visibility', request()->input('visibility')) == 'Pu' ? 'selected="selected"' : '' }}>{{ __('common.public') }}</option>
									<option value="PP" {{ old('visibility', request()->input('visibility')) == 'PP' ? 'selected="selected"' : '' }}>{{ __('common.password_protected') }}</option>
									<option value="Pr" {{ old('visibility', request()->input('visibility')) == 'Pr' ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
								</select>
							</div>
							<div class="mb-3 col-md-3">
								<select name="status" class="default-select form-control">
									<option value="">{{ __('common.select_status') }}</option>
									<option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected="selected"' : '' }}>{{ __('common.published') }}</option>
									<option value="2" {{ old('status', request()->input('status')) == 2 ? 'selected="selected"' : '' }}>{{ __('common.draft') }}</option>
									<option value="3" {{ old('status', request()->input('status')) == 3 ? 'selected="selected"' : '' }}>{{ __('common.trash') }}</option>
									<option value="4" {{ old('status', request()->input('status')) == 4 ? 'selected="selected"' : '' }}>{{ __('common.private') }}</option>
									<option value="5" {{ old('status', request()->input('status')) == 5 ? 'selected="selected"' : '' }}>{{ __('common.pending') }}</option>
								</select>
							</div>
							<div class="mb-3 col-md-3">
								<input type="search" name="from" class="form-control datetimepicker" placeholder="{{ __('common.from_created') }}" value="{{ old('from', request()->input('from')) }}">
							</div>
							<div class="mb-3 col-md-3">
								<input type="search" name="to" class="form-control datetimepicker" placeholder="{{ __('common.to_created') }}" value="{{ old('to', request()->input('to')) }}">
							</div>
							<div class="mb-3 col-md-4">
								<input type="search" name="publish_on" class="form-control datetimepicker" placeholder="{{ __('common.publish_on') }}" value="{{ old('publish_on', request()->input('publish_on')) }}">
							</div>
							<div class="mb-3 col-md-8 text-end">
								<input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> 
								<a href="{{ route('blog.admin.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Column starts -->
		<div class="col-xl-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">{{ __('common.blogs') }}</h4>
					<div>
						@can('Controllers > BlogsController > admin_create')
							<a href="{{ route('blog.admin.create') }}" class="btn btn-primary">{{ __('common.add_blog') }}</a>
						@endcan
						@can('Controllers > BlogCategoriesController > admin_index')
							<a href="{{ route('blog_category.admin.index') }}" class="btn btn-primary">{{ __('common.all_blog_categories') }}</a>
						@endcan
						<a href="{{ route('blog.admin.trash_list') }}" class="btn btn-primary">{{ __('common.trashed_blogs') }}</a>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-responsive-lg mb-0">
							<thead class="">
								<tr>
									<th> <strong> {{ __('common.s_no') }} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('title', __('common.title')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('name.users', __('common.author')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('status', __('common.status')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('visibility', __('common.visibility')) !!} </strong> </th>
									<th> <strong> {!! DzHelper::dzSortable('created_at', __('common.created')) !!} </strong> </th>
									@canany(['Controllers > BlogsController > admin_edit', 'Controllers > BlogsController > admin_destroy'])
										<th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                    @endcanany
								</tr>
							</thead>
							<tbody>
								@php
									$i = $blogs->firstItem();
								@endphp
								@forelse ($blogs as $page)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ Str::limit($page->title, 30, ' ...') }} </td>
										<td> {{ $page->user_name }} </td>
										<td> {{ $status[$page->status] }} </td>
										<td> 
											@if ($page->visibility == 'Pr')
												<span class="badge badge-danger">{{ __('common.private') }}</span>
											@elseif($page->visibility == 'PP')
												<span class="badge badge-warning">{{ __('common.password_protected') }}</span>
											@else
												<span class="badge badge-success">{{ __('common.public') }}</span>
											@endif
										</td>
										<td> {{ $page->created_at }} </td>
										<td class="text-center">
											@can('Controllers > BlogsController > admin_edit')
												<a href="{{ route('blog.admin.edit', $page->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
											@endcan
											@can('Controllers > BlogsController > admin_destroy')
												<a href="{{ route('blog.admin.admin_trash_status', $page->id) }}" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
											@endcan
										</td>
									</tr>
								@empty
									<tr><td class="text-center" colspan="7"><p>{{ __('common.blogs_not_found.') }}</p></td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer">
                    {{ $blogs->onEachSide(2)->appends(Request::input())->links() }}
				</div>
			</div>
		</div>
	</div>

</div>


@endsection