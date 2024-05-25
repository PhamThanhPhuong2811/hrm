<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div class="sidebar-menu">
            <ul>
                <li> 
                    <a href="{{route('dashboard')}}"><i class="la la-home"></i> <span>Trở về trang chủ</span></a>
                </li>
                <li class="menu-title">Cài đặt</li>

                <li class="{{ Request::routeIs('settings.company') ? 'active' : '' }}"> 
                    <a href="{{route('settings.company')}}"><i class="la la-building"></i> <span>Cài đặt chung</span></a>
                </li>
                
                <li class="{{ Request::routeIs('settings.attendance') ? 'active' : '' }}"> 
                    <a href="{{route('settings.attendance')}}"><i class="fa fa-clock-o"></i> <span>Cài đặt chấm công</span></a>
                </li>

                <li class="{{ Request::routeIs('change-password') ? 'active' : '' }}"> 
                    <a href="{{route('change-password')}}"><i class="la la-lock"></i> <span>Đổi mật khẩu</span></a>
                </li>
                
            </ul>
        </div>
    </div>
</div>
<!-- Sidebar -->