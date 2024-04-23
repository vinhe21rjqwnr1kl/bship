{{-- Extends layout --}}
@extends('admin.layout.default')
{{-- Content --}}
@section('content')
<div class="container-fluid">
    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->name) || !empty(request()->email) || !empty(request()->role))
        @php
            $collapsed = '';
            $show = 'show';
        @endphp
    @endif

    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card accordion accordion-rounded-stylish accordion-bordered" id="search-sec-outer">
                <div class="accordion-header rounded-lg {{ $collapsed }}" data-bs-toggle="collapse" data-bs-target="#rounded-search-sec">
                    <span class="accordion-header-icon"></span>
                    <h4 class="accordion-header-text m-0">Tìm Kiếm</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    {{ Form::model(request()->all(), array('route' => array('admin.users.index'), 'method' => 'get')) }}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => __('common.name'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => __('common.email'))) }}
                            </div>
                            <div class="form-group col-sm-6 col-md-3 col-lg-4 col-xl-3">
                                {{ Form::select('role', $roleArr, null, array('class' => 'default-select form-control')) }}
                            </div>
                            <div class=" col-sm-6 col-md-3 col-lg-4 col-xl-3 text-sm-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.users.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <!-- row -->
    <div class="row">
        <!-- Column starts -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"></h4>
                    @can('Controllers > UsersController > create')
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Tạo tài khoản</a>
                    @endcan
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th> <strong> {{ __('common.s_no') }} </strong> </th>
                                    <th> <strong> Tên </strong> </th>
                                    <th> <strong> {!! DzHelper::dzSortable('email', __('common.email')) !!} </strong> </th>
                                    <th> <strong> Nhóm </strong> </th>
                                    <th> <strong> Ngày tạo </strong> </th>
                                    @canany(['Controllers > UsersController > edit', 'Controllers > UsersController > destroy'])
                                        <th class="text-center"> <strong> {{ __('common.actions') }} </strong> </th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $users->firstItem();
                                @endphp
                                @forelse ($users as $user)
                                <tr>
                                    <td> {{ $i++ }} </td>
                             
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td>
                                        @forelse ($user->roles as $role)
                                        <span class="badge bg-primary mb-1">{{ $role->name }}</span>
                                        @empty
                                        {{ __('common.not_assign') }}
                                        @endforelse
                                    </td>
                                    <td> {{ $user->created_at }} </td>
                                    <td class="text-center ">
                                        @can('Controllers > UsersController > edit')
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                        @endcan
                                        @can('Controllers > UsersController > destroy')
                                            <a href="{{ route('admin.users.delete', $user->id) }}" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('common.no_users') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $users->appends(Request::input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection