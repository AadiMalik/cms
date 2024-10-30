<div class="side-nav">
    <div class="main-menu">
        <ul class="metismenu" id="menu">
            @can('dashboard_access')
                <li class="Ul_li--hover"><a class="{{ Request::is('home') ? 'sidebar_active' : '' }}"
                        href="{{ url('home') }}"><i class="fa fa-home mr-2 text-muted" style="font-size:20px;"></i><span
                            class="item-name text-15 text-muted">Dashboard</span></a>
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
            @can('customers_access')
                <li class="Ul_li--hover {{ Request::is('customers*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-user text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Customers</span></a>
                    <ul class="mm-collapse">
                        @can('customers_access')
                            <li class="item-name"><a class="{{ Request::is('customers*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('customers') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Customers</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('inventory_access')
                <li class="Ul_li--hover {{ Request::is('warehouses*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-houzz text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Inventory</span></a>
                    <ul class="mm-collapse">
                        @can('products_access')
                            <li class="item-name"><a class="{{ Request::is('finish-product*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('finish-product') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Finish Products</span></a></li>
                        @endcan
                        @can('products_access')
                            <li class="item-name"><a class="{{ Request::is('products*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('products') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Products</span></a></li>
                        @endcan
                        @can('suppliers_access')
                            <li class="item-name"><a class="{{ Request::is('other-product*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('other-product') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Other Products</span></a></li>
                        @endcan
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
                <li class="Ul_li--hover {{ (Request::is('stock') || Request::is('stock-taking*') || Request::is('transaction*') ) ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-line-chart text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Stock</span></a>
                    <ul class="mm-collapse">
                        @can('accounts_access')
                            <li class="item-name"><a class="{{ Request::is('stock') ? 'sidebar_active' : '' }}"
                                    href="{{ url('stock') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stock</span></a></li>
                        @endcan
                        @can('journals_access')
                            <li class="item-name"><a class="{{ Request::is('stock-taking*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('stock-taking') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stock Taking</span></a></li>
                        @endcan
                        @can('journals_access')
                            <li class="item-name"><a class="{{ Request::is('transaction*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('transaction') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Transaction Logs</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('purchase_access')
                <li
                    class="Ul_li--hover {{ Request::is('ratti-kaats*') || Request::is('supplier-payment*') || Request::is('other-purchase*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-houzz text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Purchase</span></a>
                    <ul class="mm-collapse">
                        @can('ratti_kaat_access')
                            <li class="item-name"><a class="{{ Request::is('ratti-kaats*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('ratti-kaats') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Ratti Kaat</span></a></li>
                        @endcan
                        @can('supplier_payment_access')
                            <li class="item-name"><a class="{{ Request::is('other-purchase*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('other-purchase') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Other Purchase</span></a></li>
                        @endcan
                        @can('supplier_payment_access')
                            <li class="item-name"><a class="{{ Request::is('stock*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('stock') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stock</span></a></li>
                        @endcan
                        @can('supplier_payment_access')
                            <li class="item-name"><a class="{{ Request::is('supplier-payment*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('supplier-payment') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Supplier Payment</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('accounting_access')
                <li class="Ul_li--hover {{ Request::is('accounts*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-line-chart text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Accounting</span></a>
                    <ul class="mm-collapse">
                        @can('accounts_access')
                            <li class="item-name"><a class="{{ Request::is('accounts*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('accounts') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Chart of Accounts</span></a></li>
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
            @can('hrm_access')
                <li
                    class="Ul_li--hover {{ Request::is('bead-type*') || Request::is('stone-category*') || Request::is('diamond-type*') || Request::is('diamond-color*') || Request::is('diamond-cut*') || Request::is('diamond-clarity*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Commons</span></a>
                    <ul class="mm-collapse">
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('bead-type*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('bead-type') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Bead Types</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('stone-category*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('stone-category') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stone Category</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-type*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-type') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Type</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-color*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-color') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Color</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-cut*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-cut') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Cut</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-clarity*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-clarity') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Clarity</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('hrm_access')
                <li class="Ul_li--hover {{ (Request::is('sale*') || Request::is('other-sale*') )? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Sales</span></a>
                    <ul class="mm-collapse">
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('sale*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('sale') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Sales</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('other-sale*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('other-sale') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Other Sales</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('purchase_access')
                <li class="Ul_li--hover {{ Request::is('gold-rate*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-houzz text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Gold Rate</span></a>
                    <ul class="mm-collapse">
                        @can('ratti_kaat_access')
                            <li class="item-name"><a class="{{ Request::is('gold-rate') ? 'sidebar_active' : '' }}"
                                    href="{{ url('gold-rate') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Chart</span></a></li>
                        @endcan
                        @can('supplier_payment_access')
                            <li class="item-name"><a class="{{ Request::is('gold-rate/logs') ? 'sidebar_active' : '' }}"
                                    href="{{ url('gold-rate/logs') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Logs</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('hrm_access')
                <li class="Ul_li--hover {{ Request::is('reports*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Reports</span></a>
                    <ul class="mm-collapse">
                        @can('employees_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/ledger-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/ledger-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Ledger Report</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/tag-history-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/tag-history-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Tag History Report</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/profit-loss-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/profit-loss-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Profit Loss Report</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/stock-ledger-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/stock-ledger-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stock Ledger</span></a></li>
                        @endcan

                        @can('employees_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/product-ledger-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/product-ledger-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Product Ledger</span></a></li>
                        @endcan

                        @can('employees_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/customer-list-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/customer-list-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Customer List</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/product-consumption-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/product-consumption-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Product Consumption</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('purchase_access')
                <li class="Ul_li--hover {{ Request::is('dollar-rate*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-houzz text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Dollar Rate</span></a>
                    <ul class="mm-collapse">
                        @can('ratti_kaat_access')
                            <li class="item-name"><a class="{{ Request::is('dollar-rate/logs') ? 'sidebar_active' : '' }}"
                                    href="{{ url('dollar-rate/logs') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Logs</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('hrm_access')
                <li class="Ul_li--hover {{ Request::is('employees*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">HRM</span></a>
                    <ul class="mm-collapse">
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('employees*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('employees') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Employee</span></a></li>
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
