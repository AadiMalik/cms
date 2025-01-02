@extends('layouts.master')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/vendor/apexcharts.css') }}">
@endsection
@section('content')
<!-- ============ Body content start ============= -->
<div class="main-content pt-4">
    <div class="breadcrumb">
        <h1 class="mr-2">Dashboard</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <!-- ICON BG-->
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Add-User"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Today Customers</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->today_customers??0,0)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Add-User"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">All Customers</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->total_customers??0,0)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Financial"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Today Sales</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->today_sales??0,2)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Financial"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Yesterday Sales</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->yesterday_sales??0,2)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Financial"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Weekly Sales</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->weekly_sales??0,2)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Financial"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Monthly Sales</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->monthly_sales??0,2)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Financial"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Yearly Sales</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->yearly_sales??0,2)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Today Sale Orders</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->yearly_sales??0,0)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Process Sale Orders</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->uncompleted_sale_orders??0,0)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">Delivery Sale Orders</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->today_delivery_sale_orders??0,0)}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Checkout-Basket"></i>
                    <div class="content" style="margin:0px;align-items: center; max-width: 100%; width: 100%;">
                        <p class="text-muted mt-2 mb-0">All Sale Orders</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{number_format($data->all_sale_orders??0,0)}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">This Year Sales</div>
                    <div id="barChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Sales by Month</div>
                    <div id="echartPie" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card card-chart-bottom o-hidden mb-4">
                        <div class="card-body">
                            <div class="text-muted">Month Sales</div>
                            <p class="mb-4 text-primary text-24">{{$data->monthly_sales}}</p>
                        </div>
                        <div id="echart1" style="height: 260px;"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card card-chart-bottom o-hidden mb-4">
                        <div class="card-body">
                            <div class="text-muted">Week Sales</div>
                            <p class="mb-4 text-warning text-24">{{$data->weekly_sales??0}}</p>
                        </div>
                        <div id="echart2" style="height: 260px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">Top Selling Products</div>
                    @foreach($highest_products as $item)
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center mb-3">
                        <div class="flex-grow-1">
                            <h5><a href="#">{{$item->product_name??''}}</a></h5>
                            <p class="text-small text-danger m-0">{{number_format($item->total_sales??0,2)}}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div><!-- end of main-content -->
</div>
@endsection
@section('js')
<script src="{{ asset('assets/js/vendor/apexcharts.dataseries.js') }}"></script>
<script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
<script>
    barChart();
    paiChart();

    function barChart() {
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Sales',
                data: <?php echo $sales; ?>
            }],
            xaxis: {
                categories: <?php echo $month;  ?>
            }
        };

        var chart = new ApexCharts(document.querySelector("#barChart"), options);
        chart.render();
    }

    function paiChart() {
        var options = {
            chart: {
                type: 'donut',
                height: 350
            },
            series: <?php echo $sales; ?>, // Array of numerical values
            labels: <?php echo $month; ?>, // Array of labels (categories)
            legend: {
                position: 'bottom'
            }
        };

        var chart = new ApexCharts(document.querySelector("#echartPie"), options);
        chart.render();
    }
</script>
@endsection