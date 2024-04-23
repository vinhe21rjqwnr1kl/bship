{{-- Extends layout --}}
@extends('admin.layout.default')

{{-- Content --}}
@section('content')

<div class="container-fluid">

    @php
        $collapsed = 'collapsed';
        $show = '';
    @endphp

    @if(!empty(request()->name))
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
                    <h4 class="accordion-header-text m-0">Tìm kiếm</h4>
                    <span class="accordion-header-indicator"></span>
                </div>
                <div class="card-body collapse accordion__body {{ $show }}" id="rounded-search-sec" data-bs-parent="#search-sec-outer">
                    {{ Form::model(request()->all(), array('route' => array('admin.roles.index'), 'method' => 'get'))}}
                        <input type="hidden" name="todo" value="Filter">
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => __('common.role_name'))) }}
                            </div>
                            <div class="col-md-8 text-end">
                                <input type="submit" name="search" value="{{ __('common.search') }}" class="btn btn-primary me-2"> <a href="{{ route('admin.roles.index') }}" class="btn btn-danger">{{ __('common.reset') }}</a>
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
                    @can('Controllers > RolesController > create')
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Thêm nhóm</a>
                    @endcan
                </div>
                <div class="pe-4 ps-4 pt-2 pb-2">
                    <div class="table-responsive">
                        <table class="table table-responsive-lg mb-0">
                            <thead>
                                <tr>
                                    <th><strong>STT</strong></th>
                                    <th><strong>Tên</strong></th>
                                    <th><strong>Quyền</strong></th>
                                    @canany(['Controllers > RolesController > edit', 'Controllers > RolesController > destroy'])
                                        <th><strong>Thao tác</strong></th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $roles->firstItem();
                                @endphp
                                @forelse($roles as $role)

                                    @php
                                        $rolePermissionCount = Acl::get_role_permissions_count($role->id);
                                    @endphp

                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td> {{ $role->name }} </td>
                                        <td> <span class="badge bg-primary">{{ $rolePermissionCount }}</span> </td>
                                        <td>
                                            @can('Controllers > RolesController > edit')
                                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('Controllers > RolesController > destroy')
                                                <a href="{{ route('admin.roles.delete', $role->id) }}" class="btn btn-danger shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">
                                            <p class="text-center">{{ __('common.records_not_found') }}</p>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

@endsection