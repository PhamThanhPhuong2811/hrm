<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Trang chủ</span>
                </li>
                <li class="{{ route_is('dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="la la-dashboard"></i> <span> Thống kê</span></a>
                </li>
                
                <li class="menu-title">
                    <!--<span>Nhân viên</span>-->
                </li>
                <li class="submenu">
                    <a href="#" class="{{ route_is(['employees','employees-list']) ? 'active' : '' }} "><i class="fa fa-users"></i> <span> Quản lý nhân viên</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('employees') ? 'active' : '' }}" href="{{route('employees')}}">Danh sách nhân viên</a></li>
                        <li><a class="{{ route_is('employees.attendance') ? 'active' : '' }}" href="{{route('employees.attendance')}}">Chấm công</a></li>
                        <li><a class="{{ route_is('overtime') ? 'active' : '' }}" href="{{route('overtime')}}">Làm thêm giờ</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fa fa-building"></i> <span>Cơ cấu tổ chức</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('departments') ? 'active' : '' }}" href="{{route('departments')}}">Phòng ban</a></li>
                        <li><a class="{{ route_is('designations') ? 'active' : '' }}" href="{{route('designations')}}">Chức vụ</a></li>
                        <li><a class="{{ route_is('policies') ? 'active' : '' }}" href="{{route('policies')}}">Chính sách</a></li>
                       
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fa fa-user-times"></i> <span>Nghỉ phép</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('employee-leave') ? 'active' : '' }}" href="{{route('employee-leave')}}">Danh sách nghỉ phép</a></li>
                        <li><a class="{{ route_is('holidays') ? 'active' : '' }}" href="{{route('holidays')}}">Ngày lễ</a></li>
                        <li><a class="{{ route_is('leave-type') ? 'active' : '' }}" href="{{route('leave-type')}}">Loại nghỉ phép</a></li>
                    </ul>
                </li>
<li class="submenu">
                    <a href="#"><i class="fa fa-bullhorn"></i> <span> Thông báo tuyển dụng </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('jobs') ? 'active' : '' }}" href="{{route('jobs')}}"> Quản lý tuyển dụng </a></li>
                        <li><a class="{{ route_is('job-applicants') ? 'active' : '' }}" href="{{route('job-applicants')}}">Thực tập sinh </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-crosshairs"></i> <span> Mục tiêu </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ route_is('goal-tracking') ? 'active' : '' }}" href="{{route('goal-tracking')}}"> Danh sách mục tiêu </a></li>
                        <li><a class="{{ route_is('goal-type') ? 'active' : '' }}" href="{{route('goal-type')}}"> Loại mục tiêu </a></li>
                    </ul>
                </li>


                
                <li class="submenu">
                    <a href="#"><i class="fa fa-gitlab"></i> <span> Dự án </span> <span class="menu-arrow"></span></a>
                    <ul style="display: non;">
                        <li>
                            <a class="{{ route_is(['projects','project-list']) ? 'active' : '' }}" href="{{route('projects')}}">Danh sách dự án</a>
                        </li>
                        <li>
                            <a class="{{ route_is('clients') ? 'active' : '' }}" href="{{route('clients')}}">Khách hàng</a>
                        </li>
                        <li>
                            <a class="{{ route_is(['tickets']) ? 'active' : '' }}" href="{{route('tickets')}}">Danh sách nhiệm vụ</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ route_is('assets') ? 'active' : '' }}">
                    <a href="{{route('assets')}}"><i class="fa fa-money"></i> <span>Tài sản</span></a>
                </li>
                <!--<li>
                    <a class="{{ route_is('activity') ? 'active' : '' }}" href="{{route('activity')}}"><i class="la la-bell"></i> <span>Activities</span></a>
                </li>-->
                <li class="{{ route_is('users') ? 'active' : '' }}">
                    <a href="{{route('users')}}"><i class="fa fa-user-circle"></i> <span>Quản lý người dùng</span></a>
                </li>
                  
                <li class="{{ route_is('salary') ? 'active' : '' }}">
                    <a href="{{route('salary')}}"><i class="fa fa-credit-card-alt"></i> <span> Quản lý lương</span></a>
                </li>
              

                
                {{-- <li class="submenu">
                    <a href="#"><i class="fa fa-commenting-o"></i> <span> Chat </span> <span class="menu-arrow"></span></a>
                    <ul style="display: non;">
                        <li>
                            <a class="{{ route_is(['chatify']) ? 'active' : '' }}" href="{{route('chatify')}}">Live chat</a>
                        </li>
                    </ul>
                </li> --}}
                
                <li class="{{ route_is('chatify') ? 'active' : '' }}">
                    <a href="{{ route('chatify') }}"><i class="fa fa-comments-o"></i> <span> Nhắn tin </span></a>
                </li>
                

                {{-- <li class="submenu">
                    <a href="#"><i class=" fa fa-envelope"></i> <span> Gmail </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            <a class="{{ Route::currentRouteName() == 'sendmail.index' ? 'active' : '' }}" href="{{ route('sendmail.index') }}">Gửi Gmail</a>
                        </li>
                    </ul>
                </li> --}}
                

                <li class="{{ Route::currentRouteName() == 'sendmail.index' ? 'active' : '' }}">
                    <a href="{{ route('sendmail.index') }}"><i class="fa fa-envelope"></i> <span> Gmail </span></a>
                </li>
            
              
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
