<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Trang chủ</span>
                </li>
          
                <li class="menu-title">
                    <!--<span>Nhân viên</span>-->
                </li>
                
                
                <li class="submenu">
                    <a href="#"><i class="fa fa-user-times"></i> <span>Nghỉ phép</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        
                        <li><a class="{{ route_is('Nhanviennghiphep') ? 'active' : '' }}" href="{{route('Nhanviennghiphep')}}">Danh sách nghỉ phép cá nhân</a></li>
                        <li><a class="{{ route_is('Xemloainghiphep') ? 'active' : '' }}" href="{{route('Xemloainghiphep')}}">Loại nghỉ phép</a></li>
                    </ul>
                </li>
                <li class="{{ route_is('Xemchamcong') ? 'active' : '' }}">
                    <a href="{{route('Xemchamcong')}}"><i class="fa fa-clock-o"></i> <span>Xem chấm công</span></a>
                </li>

                <li class="{{ route_is('Xemngayle') ? 'active' : '' }}">
                    <a href="{{route('Xemngayle')}}"><i class="fa fa-calendar-times-o"></i> <span>Ngày lễ</span></a>
                </li>


                <li class="submenu">
                    <a href="#"><i class="la la-rocket"></i> <span> Dự án </span> <span class="menu-arrow"></span></a>
                    <ul style="display: non;">
                        <li>
                            <a class="{{ route_is('Xemduan') ? 'active' : '' }}" href="{{route('Xemduan')}}">Danh sách dự án</a>
                        </li>
                        <li>
                            <a class="{{ route_is('Xemnhiemvu') ? 'active' : '' }}" href="{{route('Xemnhiemvu')}}">Danh sách nhiệm vụ</a>
                        </li>
                    </ul>
                </li>
                <li class="{{ route_is('Xemluong') ? 'active' : '' }}">
                    <a href="{{route('Xemluong')}}"><i class="fa fa-money"></i> <span>Lương</span></a>
                </li>
             
               
                <li class="{{ route_is('Xemmuctieu') ? 'active' : '' }}">
                    <a href="{{route('Xemmuctieu')}}"><i class="la la-crosshairs"></i> <span> Mục tiêu </span></a>
                </li>

                {{-- <li class="submenu">
                    <a href="#"><i class="fa fa-comments-o"></i> <span> Chat </span> <span class="menu-arrow"></span></a>
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
                            <a class="{{ Route::currentRouteName() == 'guimail.index' ? 'active' : '' }}" href="{{ route('guimail.index') }}">Gửi Gmail</a>
                        </li>
                    </ul>
                </li> --}}

                <li class="{{ Route::currentRouteName() == 'guimail.index' ? 'active' : '' }}">
                    <a href="{{ route('guimail.index') }}"><i class="fa fa-envelope"></i> <span> Gmail </span></a>
                </li>
                
                
                <li class="{{ route_is('Xemchinhsach') ? 'active' : '' }}">
                    <a href="{{route('Xemchinhsach')}}"><i class="fa fa-newspaper-o"></i> <span> Chính sách </span></a>
                </li>
                

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
