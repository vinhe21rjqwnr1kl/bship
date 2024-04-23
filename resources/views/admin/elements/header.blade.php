<!-- **********************************
	Header start
*********************************** -->

@php
	$current_user 	= auth()->user();
	$user_name 		= isset($current_user->full_name) ? $current_user->full_name : '';
	$user_email 	= isset($current_user->email) ? $current_user->email : '';
	$userId 		= isset($current_user->id) ? $current_user->id : '';
	$userImg 		= HelpDesk::user_img($current_user->profile);
	$page_title  	= isset($page_title) ? $page_title : 'Dashboard';
@endphp

<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
					<div class="d-flex align-items-center flex-wrap me-auto">
						<h3> {{ $page_title }}</h5>
					</div>
                </div>
                <ul class="navbar-nav header-right main-notification">
                	<li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell " href="{{ url('/login') }}">
							<i class="fas fa-home"></i>
                        </a>
					</li>
					<li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell dz-theme-mode" href="#">
							<i id="icon-light" class="fas fa-sun"></i>
                            <i id="icon-dark" class="fas fa-moon"></i>
							
                        </a>
					</li>
					<li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell dz-fullscreen" href="#">
                            <svg id="icon-full" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                            <svg id="icon-minimize" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minimize"><path d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3" style="stroke-dasharray: 37, 57; stroke-dashoffset: 0;"></path></svg>
                        </a>
					</li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
							<div class="header-info">
								<span>{{ $user_name }}</span>
								<small>{{ implode(', ', Auth::user()->roles->pluck('name')->toArray()) }}</small>
							</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{!! route('admin.users.profile') !!}" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ms-2"> Thông tin </span>
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
								<a href="{!! route('admin.logout'); !!}" class="dropdown-item ai-icon LogOutBtn">
									<svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
									<span class="ms-2">Thoát </span>
								</a>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
	</div>
</div>
<!--**********************************
	Header end ti-comment-alt
***********************************-->
