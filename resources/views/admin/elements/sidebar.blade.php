<!--**********************************
	Sidebar Fixed
***********************************-->
@php
    $current_user       = auth()->user();
    $agency_id          =    $current_user->agency_id;
    $roles              =    $current_user->roles->toArray();
    $role_id            =   ($roles[0]['pivot']['role_id']) ?? null;
    $user_name          = isset($current_user->full_name) ? $current_user->full_name : '';
    $user_email         = isset($current_user->email) ? $current_user->email : '';
    $userId             = isset($current_user->id) ? $current_user->id : '';
    $userImg            = HelpDesk::user_img($current_user->profile);

@endphp
@php
    $sub_menu_icon = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><polygon points="0 0 24 0 24 24 0 24"/><path d="M22,15 L22,19 C22,20.1045695 21.1045695,21 20,21 L8,21 C5.790861,21 4,19.209139 4,17 C4,14.790861 5.790861,13 8,13 L20,13 C21.1045695,13 22,13.8954305 22,15 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000" opacity="0.3"/><path d="M15.5421357,5.69999981 L18.3705628,8.52842693 C19.1516114,9.30947552 19.1516114,10.5758055 18.3705628,11.3568541 L9.88528147,19.8421354 C8.3231843,21.4042326 5.79052439,21.4042326 4.22842722,19.8421354 C2.66633005,18.2800383 2.66633005,15.7473784 4.22842722,14.1852812 L12.7137086,5.69999981 C13.4947572,4.91895123 14.7610871,4.91895123 15.5421357,5.69999981 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000" opacity="0.3"/><path d="M5,3 L9,3 C10.1045695,3 11,3.8954305 11,5 L11,17 C11,19.209139 9.209139,21 7,21 C4.790861,21 3,19.209139 3,17 L3,5 C3,3.8954305 3.8954305,3 5,3 Z M7,19 C8.1045695,19 9,18.1045695 9,17 C9,15.8954305 8.1045695,15 7,15 C5.8954305,15 5,15.8954305 5,17 C5,18.1045695 5.8954305,19 7,19 Z" fill="#000000"/></g></svg>';
@endphp

<div class="deznav">
    <div class="deznav-scroll">
        <div class="main-profile">
            <!--div class="image-bx">
                <img src="{{ $userImg }}" alt="{{ __('common.user_profile') }}">
                <a href="{!! route('admin.users.profile') !!}"><i class="fa fa-cog" aria-hidden="true"></i></a>
            </div-->
            <h5 class="name"><span class="font-w400">Chào,</span> {{ $user_name }}</h5>
            <p class="email">{{ $user_email }}</p>
        </div>


        <ul class="metismenu" id="menu">

            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-141-home"></i>
                    <span class="nav-text">Tổng quan</span>
                </a>
                <ul aria-expanded="false">
                    <li class="{{ request()->is('admin') ? 'mm-active' : '' }}">
                        <a href="{!! url('/admin'); !!}">Thông tin</a>
                    </li>
                </ul>
            </li>

            @if($role_id ==4)
                <li class="nav-label">Thông tin</li>
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-push-pin"></i>
                        <span class="nav-text">Chuyến đi</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('trip.admin.fail') }}">Danh sách tìm thất bại</a></li>
                    </ul>
                </li>
                <li>

                    @else
                        <!--  Đại lý BUÔN MA THUỘT -->
                @if($agency_id ==6 || ($agency_id == 0 && $role_id ==1))
                    <li class="nav-label">Thông tin ( THANH HÀ )</li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-push-pin"></i>
                            <span class="nav-text">Chuyến đi</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('trip.admin.index',6) }}"> Chuyến đi Taxi điện</a></li>
                            <li><a href="{{ route('trip.admin.index',8) }}"> Chuyến đi xe hơi</a></li>
                            <li><a href="{{ route('trip.admin.index',11) }}">Chuyến đi xe máy</a></li>
                            <li><a href="{{ route('trip.admin.index',12) }}">Chuyến đi chung</a></li>
                            {{--                            <li><a href="{{ route('trip.admin.index',3) }}">Xe ôm Vinfast</a></li>--}}
                            {{--                            <li><a href="{{ route('trip.admin.index',4) }}">Tài xế tỉnh</a></li>--}}
                            {{--                            <li><a href="{{ route('trip.admin.index',5) }}">Xe hơi</a></li>--}}
                            {{--                            <li><a href="{{ route('trip.admin.index',8) }}">Bảo hiểm xe</a></li>--}}
                            {{--                            <li><a href="{{ route('trip.admin.index',9) }}">Bike</a></li>--}}
                            {{--                            <li><a href="{{ route('trip.admin.index',10) }}">Thuê xe tự lái</a></li>--}}
                            <li><a href="{{ route('trip.admin.create') }}">Tạo chuyến</a></li>

                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-049-copy"></i>
                            <span class="nav-text">Tài xế (Đối tác)</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('driver.admin.index') }}"> Danh sách tài xế</a></li>
                            <li><a href="{{ route('driver.admin.create') }}">Thêm tài xế</a></li>
                            <li><a href="{{ route('driver.admin.warn') }}"> Tài xế sắp hết tiền</a></li>
                            <li><a href="{{ route('driver.admin.online') }}">Tài xế online</a></li>
                            <li><a href="{{ route('driver.admin.onlinemap') }}">Tài xế online (map)</a></li>
                            <li><a href="{{ route('driver.admin.log') }}">Tra cứu tiền</a></li>

                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-088-tools"></i>
                            <span class="nav-text">Nạp tiền tài xế</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('driver.admin.payment') }}">Danh sách yêu cầu</a></li>
                            <li><a href="{{ route('driver.admin.payment_create') }}">Tạo yêu cầu</a></li>
                            @if($role_id ==1 or $role_id ==2  )
                                <li><a href="{{ route('driver.admin.payment_approve') }}">Danh sách cần duyệt</a></li>
                                <li><a href="{{ route('driver.admin.payment_log') }}">Lịch sử nạp tiền</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!--  Đại lý BUÔN MA THUỘT -->
                @if($agency_id !=3 && $role_id !== null )

                    <li class="nav-label">Thông tin</li>
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-push-pin"></i>
                            <span class="nav-text">Chuyến đi</span>
                        </a>
                        <ul aria-expanded="false">
                            @can('Controllers > TripController > admin_index')
                                <li><a href="{{ route('trip.admin.index',0) }}"> Danh sách chuyến đi</a></li>
                                <li><a href="{{ route('trip.admin.index',3) }}"> Danh sách xe ôm Vinfast</a></li>
                                <li><a href="{{ route('trip.admin.index',7) }}"> Danh sách chuyến (giao đồ ăn)</a></li>
                                <li><a href="{{ route('trip.admin.index',6) }}"> Danh sách chuyến (giao hàng)</a></li>
                            @endcan
                            @can('Controllers > TripController > admin_cancel')
                                <li><a href="{{ route('trip.admin.cancel') }}">Danh sách chuyến huỷ</a></li>
                            @endcan
                            @can('Controllers > TripController > admin_fail')
                                <li><a href="{{ route('trip.admin.fail') }}">Danh sách tìm thất bại</a></li>
                            @endcan
                            @can('Controllers > TripController > admin_create')
                                <li><a href="{{ route('trip.admin.create') }}">Tạo chuyến</a></li>
                            @endcan
                        </ul>
                    </li>
                    @can('Controllers > OrdersController > admin_index')
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-381-push-pin"></i>
                                <span class="nav-text">Đơn hàng</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('orders.admin.index') }}"> Danh sách đơn hàng </a></li>
                                <li><a href="{{ route('orders.admin.index', ['status'=>'Pending']) }}"> Chưa giải
                                        quyết </a>
                                </li>
                                <li><a href="{{ route('orders.admin.index', ['status'=>'Confirmed']) }}"> Đã xác
                                        nhận </a>
                                </li>
                                <li><a href="{{ route('orders.admin.index', ['status'=>'Delivered']) }}"> Đã giao
                                        hàng </a>
                                </li>
                                <li><a href="{{ route('orders.admin.index', ['status'=>'Cancelled']) }}"> Đã hủy bỏ </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('Controllers > DriverController > admin_index')
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-049-copy"></i>
                                <span class="nav-text">Tài xế</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > DriverController > admin_index')
                                    <li><a href="{{ route('driver.admin.index') }}"> Danh sách tài xế</a></li>
                                @endcan
                                @can('Controllers > DriverController > admin_create')
                                    <li><a href="{{ route('driver.admin.create') }}">Thêm tài xế</a></li>
                                @endcan
                                @can('Controllers > DriverController > admin_warn')
                                    <li><a href="{{ route('driver.admin.warn') }}"> Tài xế sắp hết tiền</a></li>
                                @endcan
                                @can('Controllers > DriverController > admin_online')
                                    <li><a href="{{ route('driver.admin.online') }}">Tài xế online</a></li>
                                @endcan
                                @can('Controllers > DriverController > admin_onlinemap')
                                    <li><a href="{{ route('driver.admin.onlinemap') }}">Tài xế online (map)</a></li>
                                @endcan
                                @can('Controllers > DriverController > log')
                                    <li><a href="{{ route('driver.admin.log') }}">Tra cứu tiền</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('Controllers > DriverController > admin_index')
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-088-tools"></i>
                                <span class="nav-text">Nạp tiền tài xế</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > DriverController > payment')
                                    <li><a href="{{ route('driver.admin.payment') }}">Danh sách yêu cầu</a></li>
                                @endcan
                                @can('Controllers > DriverController > payment_create')
                                    <li><a href="{{ route('driver.admin.payment_create') }}">Tạo yêu cầu</a></li>
                                @endcan
                                @can('Controllers > DriverController > payment_approve')
                                    <li><a href="{{ route('driver.admin.payment_approve') }}">Danh sách cần duyệt</a>
                                    </li>
                                @endcan
                                @can('Controllers > DriverController > payment_log')
                                    <li><a href="{{ route('driver.admin.payment_log') }}">Lịch sử nạp tiền</a></li>
                                @endcan

                            </ul>
                        </li>
                    @endcan
                    @can('Controllers > UsersController > index')
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-049-copy"></i>
                                <span class="nav-text">Khách hàng</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > UsersController > indexbutl')
                                    <li><a href="{{ route('admin.usersbutl.index') }}"> Danh sách</a></li>
                                @endcan
                                @can('Controllers > PointController > log')
                                    <li><a href="{{ route('admin.point.log') }}"> Nhật ký giao dịch điểm </a></li>
                                @endcan
                                @can('Controllers > PointController > point_list_request')
                                    <li><a href="{{ route('admin.point.list-request') }}"> Danh sách cần duyệt </a></li>
                                @endcan
                                {{--                                @endif--}}
                                @can('Controllers > PointController > point_list')
                                    <li><a href="{{ route('admin.point.list') }}"> Danh sách yêu cầu </a></li>
                                @endcan
                                @can('Controllers > PointController > addPoint')
                                    <li><a href="{{ route('admin.point.add') }}"> Tặng điểm </a></li>
                                @endcan
                                @can('Controllers > PointController > givePoint')
                                    <li><a href="{{ route('admin.point.give') }}"> Giao dịch điểm </a></li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('Controllers > LogAddMoneyController > cashoutIndex')
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-049-copy"></i>
                                <span class="nav-text">Nạp/rút tiền</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > LogAddMoneyController > cashoutIndex')
                                    <li><a href="{{ route('log_add_money.admin.cashout') }}"> Yêu cầu rút tiền </a>
                                    </li>
                                @endcan
                                @can('Controllers > LogAddMoneyController > cashinIndex')
                                    <li><a href="{{ route('log_add_money.admin.cashin') }}"> Yêu cầu nạp tiền </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @if($role_id == 1)
                        <li class="nav-label">Thông tin đặt lịch</li>
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-381-push-pin"></i>
                                <span class="nav-text">Đặt lịch</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('booking.admin.order') }}"> Danh sách đặt lịch</a></li>
                                <li><a href="{{ route('booking.admin.comment') }}">Danh sách bình luận</a></li>
                                <li><a href="{{ route('booking.admin.service') }}">Danh sách dịch vụ</a></li>
                                <li><a href="{{ route('booking.admin.image') }}">Danh sách hình ảnh</a></li>
                            </ul>
                        </li>
                    @endif

                    @if($role_id ==1)
                        <li class="nav-label">Cài đặt quản lý</li>
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-073-settings"></i>
                                <span class="nav-text">Cài đặt giá</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('price.admin.km') }}">Tính tiền theo Km</a></li>
                                <li><a href="{{ route('price.admin.city') }}">Theo tỉnh/thành phố</a></li>
                                <li><a href="{{ route('price.admin.time') }}">Theo thời gian</a></li>
                                <li><a href="{{ route('price.admin.ext') }}">Theo bảo hiểm / dịch vụ</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-073-settings"></i>
                                <span class="nav-text">Cài đặt vận chuyển</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('delivery_size.admin.index') }}">Danh sách kích thước sản phẩm
                                        vận
                                        chuyển</a></li>
                                <li><a href="{{ route('delivery_type.admin.index') }}">Danh sách loại vận chuyển</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-088-tools"></i>
                                <span class="nav-text">Cài đặt dịch vụ</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('price.admin.service') }}">Danh sách cha</a></li>
                                <li><a href="{{ route('price.admin.servicesub') }}">Danh sách con</a></li>
                                <li><a href="{{ route('price.admin.group') }}">Danh sách nhóm</a></li>
                                <li><a href="{{ route('price.admin.gservice') }}">Nhóm - dịch vụ</a></li>
                                <li><a href="{{ route('price.admin.detailservice') }}">Dịch vụ cha -> con</a></li>
                                <li><a href="{{ route('price.admin.agencyservice') }}">Cài đặt dv cho đại lý</a>
                                </li>
                                <li><a href="{{ route('price.admin.cityservice') }}">Mở dv theo thành phố</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-381-push-pin"></i>
                                <span class="nav-text">Cập nhật cài đặt</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="{{ route('price.admin.cache') }}">Cập nhật cài đặt</a></li>
                            </ul>
                        </li>
                        @if($role_id ==1)
                            <li class="nav-label">Cài đặt khuyến mại</li>
                            <li>
                                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                    <i class="flaticon-162-edit"></i>
                                    <span class="nav-text">Khuyến mại</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">
                                        <a href="{{ route('admin.voucher.index') }}">Danh sách</a>
                                    </li>
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                                        <a href="{{ route('admin.voucher.create') }}">Thêm khuyến mại</a>
                                    </li>
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                                        <a href="{{ route('admin.voucher.listused') }}">Khuyến mại đã dùng</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if($role_id ==1)
                            <li class="nav-label">Cài đặt quảng cáo</li>
                            <li>
                                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                    <i class="flaticon-162-edit"></i>
                                    <span class="nav-text">Thông báo</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">
                                        <a href="{{ route('custumer.admin.notify') }}">Danh sách thông báo</a>
                                    </li>

                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                                        <a href="{{ route('custumer.admin.notifycreate') }}">Thêm thông báo</a>
                                    </li>

                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                                        <a href="{{ route('custumer.admin.notifirebase') }}">Thông báo quảng cáo</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                    <i class="flaticon-162-edit"></i>
                                    <span class="nav-text">Banner</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">
                                        <a href="{{ route('custumer.admin.banner') }}">Danh sách banner</a>
                                    </li>
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                                        <a href="{{ route('custumer.admin.bannercreate') }}">Thêm banner</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-label">Cài đặt đại lý</li>
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-028-user-1"></i>
                                <span class="nav-text">Tài khoản</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > UsersController > index')
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">

                                        <a href="{{ route('admin.users.index') }}">Danh sách tài khoản</a>
                                    </li>
                                @endcan
                                @can('Controllers > UsersController > index')
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">

                                        <a href="{{ route('admin.users.vendor') }}">Danh sách cửa hàng</a>
                                    </li>
                                @endcan
                                @can('Controllers > UsersController > create')
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                                        <a href="{{ route('admin.users.create') }}">Thêm tài khoản</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                    @if($role_id ==1)
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-162-edit"></i>
                                <span class="nav-text">Đại lý</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > UsersController > index')
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">

                                        <a href="{{ route('admin.agencys.index') }}">Danh sách đại lý</a>
                                    </li>
                                @endcan
                                @can('Controllers > UsersController > create')
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'create') ? 'mm-active' : '' }}">
                                        <a href="{{ route('admin.agencys.create') }}">Thêm đại lý</a>
                                    </li>
                                @endcan
                                @can('Controllers > UsersController > index')
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">

                                        <a href="{{ route('booking.admin.supplier') }}">Danh sách đại lý đặt
                                            lịch</a>
                                    </li>
                                    <li class="{{ (DzHelper::controller() == 'UsersController' && DzHelper::action() == 'index') ? 'mm-active' : '' }}">

                                        <a href="{{ route('booking.admin.suppliercreate') }}">Thêm đại lý đặt
                                            lịch</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                    @if($role_id ==1)
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-153-user"></i>
                                <span class="nav-text">Nhóm</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > RolesController > index')
                                    <li><a href="{{ route('admin.roles.index') }}">Danh sách nhóm</a></li>
                                @endcan
                                @can('Controllers > RolesController > create')
                                    <li><a href="{{ route('admin.roles.create') }}">Tạo nhóm</a></li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                    @if($role_id ==1)
                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-035-shield"></i>
                                <span class="nav-text">{{ __('common.permissions') }}</span>
                            </a>
                            <ul aria-expanded="false">
                                @can('Controllers > PermissionsController > index')
                                    <li>
                                        <a href="{{ route('admin.permissions.index') }}">{{ __('common.all_permissions') }}</a>
                                    </li>
                                @endcan
                                @can('Controllers > PermissionsController > temp_permissions')
                                    <li>
                                        <a href="{{ route('admin.permissions.temp_permissions') }}">{{ __('common.all_temp_permissions') }}</a>
                                    </li>
                                @endcan
                                @can('Controllers > PermissionsController > roles_permissions')
                                    <li>
                                        <a href="{{ route('admin.permissions.roles_permissions') }}">{{ __('common.roles_permissions') }}</a>
                                    </li>
                                @endcan
                                @can('Controllers > PermissionsController > user_permissions')
                                    <li>
                                        <a href="{{ route('admin.permissions.user_permissions') }}">{{ __('common.users_permissions') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif

                    @if($role_id ==1)
                        <li class="nav-label">Cài đặt khác</li>

                        <li>
                            <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="flaticon-162-edit"></i>
                                <span class="nav-text">{{ __('common.appearance') }}</span>
                            </a>
                            <ul aria-expanded="false">

                                <li><a href="{{ route('themes.admin.index') }}">{{ __('common.themes') }}</a></li>
                            </ul>
                        </li>

                        @php
                            $configuration_menu = HelpDesk::configuration_menu();
                        @endphp

                        @if(!empty($configuration_menu))
                            <li>
                                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                    <i class="flaticon-073-settings"></i>
                                    <span class="nav-text">{{ __('common.configuration') }}</span>
                                </a>
                                <ul aria-expanded="false">
                                    @forelse($configuration_menu as $config_menu)
                                        <li>
                                            <a href="{{ route('admin.configurations.admin_prefix', $config_menu) }}">{{ $config_menu }}</a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </li>
                        @endif
                    @endif
                @endif
            @endif

        </ul>
        <div class="copyright">
            <p class="fs-12">{!! config('Site.footer_text') !!}</p>
            <p>Version 1.1.18.3</p>
        </div>
    </div>
</div>

<!--**********************************
Sidebar End
***********************************
