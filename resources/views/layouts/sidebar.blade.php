<div class="side-nav">
    <div class="main-menu">
        <ul class="metismenu" id="menu">
            @can('dashboard_access')
            <li class="Ul_li--hover"><a class="{{ Request::is('home') ? 'sidebar_active' : '' }}" href="{{ url('home') }}"><i class="fa fa-home mr-2 text-muted"
                        style="font-size:20px;"></i><span class="item-name text-15 text-muted">Dashboard</span></a>
            </li>
            @endcan
            @can('user_management_access')
            <li
                class="Ul_li--hover {{ Request::is('permissions*') || Request::is('roles*') || Request::is('users*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="#"><i class="fa fa-users text-20 mr-2 text-muted"></i><span
                        class="item-name text-15 text-muted">User
                        Management</span></a>
                <ul class="mm-collapse">
                    @can('permissions_access')
                        <li class="item-name"><a class="{{ Request::is('permissions*') ? 'sidebar_active' : '' }}"
                                href="{{ url('permissions') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Permissions</span></a></li>
                    @endcan

                    @can('roles_access')
                        <li class="item-name"><a class="{{ Request::is('roles*') ? 'sidebar_active' : '' }}"
                                href="{{ url('roles') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Roles</span></a></li>
                    @endcan

                    @can('users_access')
                        <li class="item-name"><a class="{{ Request::is('users*') ? 'sidebar_active' : '' }}"
                                href="{{ url('users') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Users</span></a></li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('inventory_access')
            <li
                class="Ul_li--hover {{ Request::is('warehouses*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="#"><i class="fa fa-houzz text-20 mr-2 text-muted"></i><span
                        class="item-name text-15 text-muted">Inventory</span></a>
                <ul class="mm-collapse">
                    @can('warehouses_access')
                        <li class="item-name"><a class="{{ Request::is('warehouses*') ? 'sidebar_active' : '' }}"
                                href="{{ url('warehouses') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Warehouses</span></a></li>
                    @endcan
                    @can('suppliers_access')
                        <li class="item-name"><a class="{{ Request::is('suppliers*') ? 'sidebar_active' : '' }}"
                                href="{{ url('suppliers') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Suppliers/Karigar</span></a></li>
                    @endcan

                </ul>
            </li>
            @endcan
            @can('accounting_access')
            <li
                class="Ul_li--hover {{ Request::is('accounts*') ? 'mm-active' : '' }}">
                <a class="has-arrow" href="#"><i class="fa fa-line-chart text-20 mr-2 text-muted"></i><span
                        class="item-name text-15 text-muted">Accounting</span></a>
                <ul class="mm-collapse">
                    @can('accounts_access')
                        <li class="item-name"><a class="{{ Request::is('accounts*') ? 'sidebar_active' : '' }}"
                                href="{{ url('accounts') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Accounts</span></a></li>
                    @endcan
                    @can('journals_access')
                        <li class="item-name"><a class="{{ Request::is('journals*') ? 'sidebar_active' : '' }}"
                                href="{{ url('journals') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Journals</span></a></li>
                    @endcan
                    @can('journal_entries_access')
                        <li class="item-name"><a class="{{ Request::is('journal-entries*') ? 'sidebar_active' : '' }}"
                                href="{{ url('journal-entries') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Journal Entries</span></a></li>
                    @endcan

                </ul>
            </li>
            @endcan
            @can('logout_access')
            <li class="Ul_li--hover"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"><i
                        class="fa fa-sign-out text-20 mr-2 text-muted"></i><span
                        class="item-name text-15 text-muted">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            @endcan
        </ul>
    </div>
</div>
