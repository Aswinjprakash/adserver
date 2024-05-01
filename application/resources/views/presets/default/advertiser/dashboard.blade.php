@extends($activeTemplate . 'layouts.advertiser.master')
@section('content')
    <div class="row gy-4 mb-4 justify-content-center">
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <a class="d-block" href="{{ route('advertiser.ad.index') }}">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <img src="{{asset($activeTemplateTrue.'dashboardImages/ads.png')}}" alt="ads">
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Total Advertises')</h5>
                        <h5 class="dashboard-card__amount">{{ $widget['total_ads'] }}</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-6 col-sm-6">
            <a class="d-block" href="javascript:void(0)">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <img src="{{asset($activeTemplateTrue.'dashboardImages/impression.png')}}" alt="ads">
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Total Impressions')</h5>
                        <h5 class="dashboard-card__amount">{{ $widget['total_imp'] }}</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-6 col-sm-6">
            <a class="d-block" href="javascript:void(0)">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <img src="{{asset($activeTemplateTrue.'dashboardImages/click.png')}}" alt="ads">
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Total Clicks')</h5>
                        <h5 class="dashboard-card__amount">{{ $widget['total_click'] }}</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-6 col-sm-6">
            <a class="d-block" href="javascript:void(0)">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <img src="{{asset($activeTemplateTrue.'dashboardImages/impression.png')}}" alt="ads">
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Remaining Impression Points')</h5>
                        <h5 class="dashboard-card__amount">{{ $widget['remain_imp_point'] }}</h5>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-4 col-lg-6 col-sm-6">
            <a class="d-block" href="javascript:void(0)">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <img src="{{asset($activeTemplateTrue.'dashboardImages/click.png')}}" alt="ads">
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Remaining Click Points')</h5>
                        <h5 class="dashboard-card__amount">{{ $widget['remain_click_point'] }}</h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6">
            <a class="d-block" href="javascript:void(0)">
                <div class="dashboard-card">
                    <span class="banner-effect-1"></span>
                    <div class="dashboard-card__icon">
                        <img src="{{asset($activeTemplateTrue.'dashboardImages/dollar.png')}}" alt="ads">
                    </div>
                    <div class="dashboard-card__content">
                        <h5 class="dashboard-card__title">@lang('Balance')</h5>
                        <h5 class="dashboard-card__amount">{{__($general->cur_sym)}} {{ showAmount($widget['balance']) }}</h5>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-6">
            <div class="dashboard-chart">
                <h5 class="card-title">@lang('Monthly Deposit') (@lang('This year'))</h5>
                <div id="account-chart"></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="dashboard-chart">
                <h5 class="card-title">@lang('Monthly Transaction') (@lang('This year'))</h5>
                <div id="trx-chart"> </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/admin/js/apexcharts.min.js') }}"></script>

    <script>
        "use strict";
        // [ account-chart ] start
        (function() {
            var options = {
                chart: {
                    type: 'area',
                    stacked: false,
                    height: '310px'
                },
                stroke: {
                    width: [0, 3],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                colors: ['#00adad', '#67BAA7'],
                series: [{
                    name: '@lang('Deposits')',
                    type: 'area',
                    data: @json($depositsChart['values'])
                }],
                fill: {
                    opacity: [0.85, 1],
                },
                labels: @json($depositsChart['labels']),
                markers: {
                    size: 0
                },
                xaxis: {
                    type: 'text'
                },
                yaxis: {
                    min: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(y) {
                            if (typeof y !== "undefined") {
                                return "$ " + y.toFixed(0);
                            }
                            return y;

                        }
                    }
                },
                legend: {
                    labels: {
                        useSeriesColors: true
                    },
                    markers: {
                        customHTML: [
                            function() {
                                return ''
                            },
                            function() {
                                return ''
                            }
                        ]
                    }
                }
            }
            var chart = new ApexCharts(
                document.querySelector("#account-chart"),
                options
            );
            chart.render();
        })();


        (function() {
            var options = {
                chart: {
                    type: 'area',
                    stacked: false,
                    height: '310px'
                },
                stroke: {
                    width: [0, 3],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                colors: ['#00adad', '#67BAA7'],
                series: [{
                    name: '@lang('Transaction')',
                    type: 'area',
                    data: @json($trxChart['values'])
                }],
                fill: {
                    opacity: [0.85, 1],
                },
                labels: @json($trxChart['labels']),
                markers: {
                    size: 0
                },
                xaxis: {
                    type: 'text'
                },
                yaxis: {
                    min: 0
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(y) {
                            if (typeof y !== "undefined") {
                                return "$ " + y.toFixed(0);
                            }
                            return y;

                        }
                    }
                },
                legend: {
                    labels: {
                        useSeriesColors: true
                    },
                    markers: {
                        customHTML: [
                            function() {
                                return ''
                            },
                            function() {
                                return ''
                            }
                        ]
                    }
                }
            }
            var chart = new ApexCharts(
                document.querySelector("#trx-chart"),
                options
            );
            chart.render();
        })();
    </script>
@endpush
