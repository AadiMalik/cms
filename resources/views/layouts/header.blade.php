@php
$gold_rate = GoldRate();
$dollar_rate = DollarRate();
@endphp
<header class="main-header bg-white d-flex justify-content-between p-2">
    <div class="header-toggle">
        <div class="menu-toggle mobile-menu-icon">
            <div></div>
            <div></div>
            <div></div>
        </div>
        @can('gold_rate_log_access')
        <div style="display: ruby;border: 2px solid peru;padding: 5px;border-radius: 30%;">

            <h3 class="mr-1 font-weight-bold" data-toggle="tooltip" data-placement="top" title="{{isset($dollar_rate)?$gold_rate->created_at->format('d-m-Y g:i A'):''}}">AU: {{number_format($gold_rate->rate_tola??0,2)}}</h3>
            @can('gold_rate_log_create')
            <a href="javascript:void(0)" id="ChangeGoldRate" style="padding: 3px 5px 3px 5px;" class="btn-primary mr-2"><i
                    class="fa fa-refresh text-white"></i></a>
            @endcan
        </div>
        @endcan
        @can('dollar_rate_log_access')
        <div style="display: ruby;border: 2px solid peru;padding: 5px;border-radius: 30%;">
            <h3 class="mr-1 font-weight-bold" data-toggle="tooltip" data-placement="top" title="{{isset($dollar_rate)?$dollar_rate->created_at->format('d-m-Y g:i A'):''}}">$: {{number_format($dollar_rate->rate??0,2)}}</h3>
            @can('dollar_rate_log_create')
            <a href="javascript:void(0)" id="ChangeDollarRate" style="padding: 3px 5px 3px 5px;" class="btn-primary mr-2"><i
                    class="fa fa-refresh text-white"></i></a>
            @endcan
        </div>
        @endcan
    </div>
    <div class="header-part-right">
        

        <!-- Notificaiton -->
        <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" type="button" aria-haspopup="true" data-mdb-toggle="dropdown" data-mdb-auto-close="false" aria-expanded="false" onclick="readNewNotifications();">
                <span class="badge badge-primary" id="notification_badge">0</span>
                <i class="fa fa-bell text-muted header-icon"></i>
            </div>
            <!-- Notification dropdown -->
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true" id="notification_scroll">
                <div class="card-header text-right" id="card">
                    <!-- <a href="list-notification" class="text-primary mr-3">View All</a> -->
                    <a onclick="readAllNotifications();" class="text-primary">Mark all as read</a>
                </div>
                <div id="notification_list"></div>
                {{-- @foreach ($notification as $item)
                    <a href="{{ $item->url }}">
                    <div class="dropdown-item d-flex">
                        <div class="notification-icon">
                            <i class="fas fa-comment text-primary mr-1"></i>
                        </div>
                        <div class="notification-details flex-grow-1">
                            <p class="m-0 d-flex align-items-center">
                                <span>{{ $item->title ?? '' }}</span>
                                @if ($item->is_Read == 0)
                                <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
                                @endif
                                <span class="flex-grow-1"></span>
                                <span class="text-small text-muted ml-auto">{{ $item->created_at->diffForHumans() ?? '' }}</span>
                            </p>
                            <p class="text-small text-muted m-0">{{ $item->message ?? '' }}</p>
                        </div>
                    </div>
                </a>
                @endforeach --}}

            </div>
        </div>
        <!-- Notificaiton End -->

        <!-- Full screen toggle--><i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen=""></i>
        <!-- Grid menu Dropdown-->
        <!-- <div class="dropdown dropleft"><i class="i-Safe-Box text-muted header-icon" id="dropdownMenuButton"
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <div class="menu-icon-grid"><a href="#"><i class="i-Shop-4"></i> Home</a><a href="#"><i
                            class="i-Library"></i> UI Kits</a><a href="#"><i class="i-Drop"></i> Apps</a><a
                        href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a><a href="#"><i
                            class="i-Checked-User"></i> Sessions</a><a href="#"><i class="i-Ambulance"></i>
                        Support</a></div>
            </div>
        </div> -->

    </div>
</header>