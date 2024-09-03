<div class="side-nav">
    <div class="main-menu">
        <ul class="metismenu" id="menu">
            <li class="Ul_li--hover"><a href="{{ url('home') }}"><i class="fa fa-home mr-2 text-muted"
                        style="font-size:20px;"></i><span class="item-name text-15 text-muted">Dashboard</span></a>
            </li>
            <li class="Ul_li--hover {{(Request::is('permissions*') || Request::is('roles*') || Request::is('users*'))?'mm-active':''}}"><a class="has-arrow" href="#"><i
                        class="fa fa-users text-20 mr-2 text-muted"></i><span class="item-name text-15 text-muted">User
                        Management</span></a>
                <ul class="mm-collapse">
                    <li class="item-name"><a class="{{(Request::is('permissions*'))?'sidebar_active':''}}" href="{{ url('permissions') }}"><i class="nav-icon fa fa-circle"></i><span
                                class="item-name">Permissions</span></a></li>
                    <li class="item-name"><a class="{{(Request::is('roles*'))?'sidebar_active':''}}" href="{{ url('roles') }}"><i class="nav-icon fa fa-circle"></i><span
                                class="item-name">Roles</span></a></li>
                    <li class="item-name"><a class="{{(Request::is('users*'))?'sidebar_active':''}}" href="{{ url('users') }}"><i class="nav-icon fa fa-circle"></i><span
                                class="item-name">Users</span></a></li>
                </ul>
            </li>
            <li class="Ul_li--hover"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"><i
                        class="fa fa-sign-out text-20 mr-2 text-muted"></i><span
                        class="item-name text-15 text-muted">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
