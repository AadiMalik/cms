<div class="side-nav">
    <div class="main-menu">
        <ul class="metismenu" id="menu">
            @can('dashboard_access')
                <li class="Ul_li--hover"><a class="{{ Request::is('home') ? 'sidebar_active' : '' }}"
                        href="{{ url('home') }}"><i class="fa fa-home mr-2 text-muted" style="font-size:20px;"></i><span
                            class="item-name text-15 text-muted">Dashboard</span></a>
                </li>
            @endcan
            @can('tagging_product_access')
                <li class="Ul_li--hover"><a class="{{ Request::is('finish-product/search') ? 'sidebar_active' : '' }}"
                        href="{{ url('finish-product/search') }}"><i class="fa fa-search mr-2 text-muted"
                            style="font-size:20px;"></i><span class="item-name text-15 text-muted">Tag Search</span></a>
                </li>
            @endcan
            @can('tagging_metal_product_access')
                <li class="Ul_li--hover"><a class="{{ Request::is('metal-product/search') ? 'sidebar_active' : '' }}"
                        href="{{ url('metal-product/search') }}"><i class="fa fa-search mr-2 text-muted"
                            style="font-size:20px;"></i><span class="item-name text-15 text-muted">Metal Tag
                            Search</span></a>
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
            @can('setting_access')
                <li class="Ul_li--hover"><a class="{{ Request::is('company-setting') ? 'sidebar_active' : '' }}"
                        href="{{ url('company-setting') }}"><i class="fa fa-cogs mr-2 text-muted"
                            style="font-size:20px;"></i><span class="item-name text-15 text-muted">Bank & Cash
                            Accounts</span></a>
                </li>
            @endcan
            @can('accounting_access')
                <li
                    class="Ul_li--hover {{ Request::is('journal-entries*') | Request::is('customer-payment*') | Request::is('reatainer*') | Request::is('supplier-payment*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-credit-card text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Reciepts & Pay..</span></a>
                    <ul class="mm-collapse">
                        @can('journal_entries_access')
                            <li class="item-name"><a class="{{ Request::is('journal-entries*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('journal-entries') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Journal Entries</span></a></li>
                        @endcan
                        @can('customer_payment_access')
                            <li class="item-name"><a class="{{ Request::is('customer-payment*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('customer-payment') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Customer Reciepts</span></a></li>
                        @endcan
                        @can('supplier_payment_access')
                            <li class="item-name"><a class="{{ Request::is('supplier-payment*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('supplier-payment') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Supplier Payments</span></a></li>
                        @endcan
                        {{-- @can('retainer_access') --}}
                        <li class="item-name"><a class="{{ Request::is('retainer*') ? 'sidebar_active' : '' }}"
                                href="{{ url('retainer') }}"><i class="nav-icon fa fa-circle"></i><span
                                    class="item-name">Retainers</span></a></li>
                        {{-- @endcan --}}

                    </ul>
                </li>
            @endcan
            @can('sales_access')
                <li
                    class="Ul_li--hover {{ Request::is('customers*') || Request::is('sale*') || Request::is('other-sale*') || Request::is('diamond-sale*') || Request::is('sale-order*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Sales</span></a>
                    <ul class="mm-collapse">
                        @can('customers_access')
                            <li class="item-name"><a class="{{ Request::is('customers*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('customers') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Customers</span></a></li>
                        @endcan
                        @can('sale_access')
                            <li class="item-name"><a class="{{ Request::is('sale*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('sale') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Sales</span></a></li>
                        @endcan
                        @can('metal_sale_access')
                            <li class="item-name"><a class="{{ Request::is('metal-sale*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('metal-sale') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Metal Sales</span></a></li>
                        @endcan
                        @can('other_sale_access')
                            <li class="item-name"><a class="{{ Request::is('other-sale*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('other-sale') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Other Sales</span></a></li>
                        @endcan
                        @can('sale_order_access')
                            <li class="item-name"><a class="{{ Request::is('sale-order*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('sale-order') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Sale Order</span></a></li>
                        @endcan
                        @can('metal_sale_order_access')
                            <li class="item-name"><a class="{{ Request::is('metal-sale-order*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('metal-sale-order') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Metal Sale Order</span></a></li>
                        @endcan
                        @can('diamond_sale_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-sale*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-sale') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Sale</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('purchase_access')
                <li
                    class="Ul_li--hover {{ Request::is('suppliers*') | Request::is('ratti-kaats*') || Request::is('gold-impurity*') || Request::is('job-purchase*') || Request::is('supplier-payment*') || Request::is('other-purchase*') || Request::is('diamond-purchase*') || Request::is('purchase-order*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-houzz text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Purchase</span></a>
                    <ul class="mm-collapse">
                        @can('suppliers_access')
                            <li class="item-name"><a class="{{ Request::is('suppliers*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('suppliers') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Suppliers/Karigar</span></a></li>
                        @endcan
                        @can('purchase_order_access')
                            <li class="item-name"><a class="{{ Request::is('purchase-order*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('purchase-order') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Purchase Order</span></a></li>
                        @endcan
                        @can('ratti_kaat_access')
                            <li class="item-name"><a class="{{ Request::is('ratti-kaats*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('ratti-kaats') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Ratti Kaat</span></a></li>
                        @endcan
                        @can('metal_purchase_access')
                            <li class="item-name"><a class="{{ Request::is('metal-purchase*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('metal-purchase') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Metal Purchase</span></a></li>
                        @endcan
                        @can('metal_purchase_order_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('metal-purchase-order*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('metal-purchase-order') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Metal Purchase Order</span></a></li>
                        @endcan
                        @can('other_purchase_access')
                            <li class="item-name"><a class="{{ Request::is('other-purchase*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('other-purchase') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Other Purchase</span></a></li>
                        @endcan

                        @can('gold_impurity_access')
                            <li class="item-name"><a class="{{ Request::is('gold-impurity*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('gold-impurity') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Gold Impurity</span></a></li>
                        @endcan
                        @can('job_purchase_access')
                            <li class="item-name"><a class="{{ Request::is('job-purchase*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('job-purchase') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Job Purchase</span></a></li>
                        @endcan
                        @can('diamond_purchase_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-purchase*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-purchase') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Purchase</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('stock_access')
                <li
                    class="Ul_li--hover {{ Request::is('finish-product*') | Request::is('metal-product*') | Request::is('stock') || Request::is('stock-taking*') || Request::is('transaction*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-line-chart text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Stock</span></a>
                    <ul class="mm-collapse">
                        @can('tagging_product_access')
                            <li class="item-name"><a class="{{ Request::is('finish-product*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('finish-product') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Tagging Products</span></a></li>
                        @endcan
                        @can('tagging_metal_product_access')
                            <li class="item-name"><a class="{{ Request::is('metal-product*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('metal-product') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Tagging Metal Products</span></a></li>
                        @endcan
                        @can('stock_access')
                            <li class="item-name"><a class="{{ Request::is('stock') ? 'sidebar_active' : '' }}"
                                    href="{{ url('stock') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stock</span></a></li>
                        @endcan
                        @can('stock_taking_access')
                            <li class="item-name"><a class="{{ Request::is('stock-taking*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('stock-taking') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stock Taking</span></a></li>
                        @endcan

                        @can('diamond_stock_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-stock') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-stock') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Stock</span></a></li>
                        @endcan

                        @can('transaction_log_access')
                            <li class="item-name"><a class="{{ Request::is('transaction*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('transaction') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Transaction Logs</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('common_access')
                <li
                    class="Ul_li--hover {{ Request::is('journals*') | Request::is('bead-type*') || Request::is('stone-category*') || Request::is('diamond-type*') || Request::is('diamond-color*') || Request::is('finish-product-location*') || Request::is('diamond-cut*') || Request::is('diamond-clarity*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Coding</span></a>
                    <ul class="mm-collapse">
                        @can('gold_rate_log_access')
                            <li class="item-name"><a class="{{ Request::is('gold-rate/logs') ? 'sidebar_active' : '' }}"
                                    href="{{ url('gold-rate/logs') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Gold Rate</span></a></li>
                        @endcan
                        @can('dollar_rate_log_access')
                            <li class="item-name"><a class="{{ Request::is('dollar-rate/logs') ? 'sidebar_active' : '' }}"
                                    href="{{ url('dollar-rate/logs') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Dollar Rate</span></a></li>
                        @endcan
                        @can('warehouses_access')
                            <li class="item-name"><a class="{{ Request::is('warehouses*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('warehouses') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Warehouses</span></a></li>
                        @endcan
                        @can('tagging_location_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('finish-product-location*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('finish-product-location') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Tagging Location</span></a></li>
                        @endcan
                        @can('products_access')
                            <li class="item-name"><a class="{{ Request::is('products*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('products') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Products</span></a></li>
                        @endcan
                        @can('other_product_access')
                            <li class="item-name"><a class="{{ Request::is('other-product*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('other-product') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Other Products</span></a></li>
                        @endcan
                        @can('bead_type_access')
                            <li class="item-name"><a class="{{ Request::is('bead-type*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('bead-type') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Bead Types</span></a></li>
                        @endcan
                        @can('stone_category_access')
                            <li class="item-name"><a class="{{ Request::is('stone-category*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('stone-category') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Stone Category</span></a></li>
                        @endcan
                        @can('diamond_type_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-type*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-type') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Type</span></a></li>
                        @endcan
                        @can('diamond_color_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-color*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-color') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Color</span></a></li>
                        @endcan
                        @can('diamond_cut_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-cut*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-cut') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Cut</span></a></li>
                        @endcan
                        @can('diamond_clarity_access')
                            <li class="item-name"><a class="{{ Request::is('diamond-clarity*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('diamond-clarity') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Diamond Clarity</span></a></li>
                        @endcan
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
                        @can('other_material_category_access')
                            <li class="item-name"><a
                                    class="{{ Request::is('other-material-category*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('other-material-category') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Other Material Category</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('report_access')
                <li class="Ul_li--hover {{ Request::is('reports*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Reports</span></a>
                    <ul class="mm-collapse">
                        @can('ledger_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/ledger-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/ledger-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Ledger Report</span></a></li>
                        @endcan
                        @can('tag_history_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/tag-history-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/tag-history-report') }}"><i
                                        class="nav-icon fa fa-circle"></i><span class="item-name">Tag History
                                        Report</span></a></li>
                        @endcan
                        @can('profit_loss_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/profit-loss-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/profit-loss-report') }}"><i
                                        class="nav-icon fa fa-circle"></i><span class="item-name">Profit Loss
                                        Report</span></a></li>
                        @endcan
                        @can('stock_ledger_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/stock-ledger-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/stock-ledger-report') }}"><i
                                        class="nav-icon fa fa-circle"></i><span class="item-name">Stock Ledger</span></a></li>
                        @endcan

                        @can('product_ledger_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/product-ledger-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/product-ledger-report') }}"><i
                                        class="nav-icon fa fa-circle"></i><span class="item-name">Product Ledger</span></a>
                            </li>
                        @endcan

                        @can('customer_list_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/customer-list-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/customer-list-report') }}"><i
                                        class="nav-icon fa fa-circle"></i><span class="item-name">Customer List</span></a>
                            </li>
                        @endcan
                        @can('product_consumption_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/product-consumption-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/product-consumption-report') }}"><i
                                        class="nav-icon fa fa-circle"></i><span class="item-name">Product
                                        Consumption</span></a></li>
                        @endcan
                        @can('financial_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/financial-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/financial-report') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Financial Report</span></a></li>
                        @endcan
                        @can('sale_user_wise_report')
                            <li class="item-name"><a
                                    class="{{ Request::is('reports/sale-user-wise-report*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('reports/sale-user-wise-report') }}"><i
                                        class="nav-icon fa fa-circle"></i><span class="item-name">Sale User Wise
                                        Report</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('job_task_access')
                <li class="Ul_li--hover {{ Request::is('job-task*') ? 'mm-active' : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-houzz text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">Job Task</span></a>
                    <ul class="mm-collapse">
                        @can('job_task_access')
                            <li class="item-name"><a class="{{ Request::is('job-task*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('job-task') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Jobs</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('gold_chart_access')
                <li class="Ul_li--hover"><a class="{{ Request::is('gold-rate') ? 'sidebar_active' : '' }}"
                        href="{{ url('gold-rate') }}"><i class="fa fa-bar-chart mr-2 text-muted"
                            style="font-size:20px;"></i><span class="item-name text-15 text-muted">Gold Chart</span></a>
                </li>
            @endcan

            @can('hrm_access')
                <li
                    class="Ul_li--hover {{ Request::is('employees*') ||
                    Request::is('department*') ||
                    Request::is('designation*') ||
                    Request::is('attendance*') ||
                    Request::is('leave-type*') ||
                    Request::is('leave-requests*') ||
                    Request::is('leave-balance*')
                        ? 'mm-active'
                        : '' }}">
                    <a class="has-arrow" href="#"><i class="fa fa-empire text-20 mr-2 text-muted"></i><span
                            class="item-name text-15 text-muted">HRM</span></a>
                    <ul class="mm-collapse">
                        @can('department_access')
                            <li class="item-name"><a class="{{ Request::is('department*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('department') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Departments</span></a></li>
                        @endcan
                        @can('designation_access')
                            <li class="item-name"><a class="{{ Request::is('designation*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('designation') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Designations</span></a></li>
                        @endcan
                        @can('employees_access')
                            <li class="item-name"><a class="{{ Request::is('employees*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('employees') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Employee</span></a></li>
                        @endcan
                        @can('attendance_access')
                            <li class="item-name"><a class="{{ Request::is('attendance*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('attendance') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Attendances</span></a></li>
                        @endcan
                        @can('attendance_summary')
                            <li class="item-name"><a
                                    class="{{ Request::is('attendance/summary*') ? 'sidebar_active' : '' }}"
                                    href="{{ url('attendance/summary') }}"><i class="nav-icon fa fa-circle"></i><span
                                        class="item-name">Attendance Summary</span></a></li>
                        @endcan
                        @can('leave_system_access')
                            <li class="Ul_li--hover {{ Request::is('leave-type*') || Request::is('leave-requests*') || Request::is('leave-balance*')? 'mm-active' : '' }}">
                                <a class="has-arrow" href="#"><i class="fa fa-calendar-alt text-20 mr-2 text-muted"></i><span
                                        class="item-name text-15 text-muted">Leave Management</span></a>
                                <ul class="mm-collapse">
                                    @can('leave_type_access')
                                        <li class="item-name"><a
                                                class="{{ Request::is('leave-type*') ? 'sidebar_active' : '' }}"
                                                href="{{ url('leave-type') }}"><i class="nav-icon fa fa-circle"></i><span
                                                    class="item-name">Leave Type</span></a></li>
                                    @endcan
                                    @can('leave_request_access')
                                        <li class="item-name"><a
                                                class="{{ Request::is('leave-requests*') ? 'sidebar_active' : '' }}"
                                                href="{{ url('leave-requests') }}"><i class="nav-icon fa fa-circle"></i><span
                                                    class="item-name">Leave Requests</span></a></li>
                                    @endcan
                                    @can('leave_balance_access')
                                        <li class="item-name"><a
                                                class="{{ Request::is('leave-balance*') ? 'sidebar_active' : '' }}"
                                                href="{{ url('leave-balance') }}"><i class="nav-icon fa fa-circle"></i><span
                                                    class="item-name">Leave Balance</span></a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- @can('logout_access') --}}
            <li class="Ul_li--hover"><a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"><i
                        class="fa fa-sign-out text-20 mr-2 text-muted"></i><span
                        class="item-name text-15 text-muted">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            {{-- @endcan --}}
        </ul>
    </div>
</div>
