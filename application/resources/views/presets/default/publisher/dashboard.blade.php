@extends($activeTemplate.'layouts.publisher.master')
@section('content')
<div class="row gy-4 mb-5 justify-content-center">
    <div class="col-xl-4 col-lg-6 col-sm-6">
        <a class="d-block" href="javascript:void(0)">
        <div class="dashboard-card">
            <span class="banner-effect-1"></span>
            <div class="dashboard-card__icon">
            <img src="{{asset($activeTemplateTrue.'dashboardImages/impression.png')}}" alt="ads">
            </div>
            <div class="dashboard-card__content">
                <h5 class="dashboard-card__title">@lang('Total Impressions')</h5>
                <h5 class="dashboard-card__amount">{{$widget['total_imp']}}</h5>
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
                <h5 class="dashboard-card__amount">{{$widget['total_click']}}</h5>
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
                <h5 class="dashboard-card__title">@lang('Earning Balance')</h5>
                <h5 class="dashboard-card__amount">{{__($general->cur_sym)}} {{showAmount($widget['balance'])}}</h5>
            </div>
        </div>
        </a>
    </div>

</div>
<div class="row gy-4">
    <div class="col-xl-6">
        <div class="dashboard-chart">
            <h5 class="card-title">@lang('Monthly Withdraw') (@lang('This year'))</h5>
            <div id="account-chart"></div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="dashboard-chart">
            <h5 class="card-title">@lang('Monthly Earning') (@lang('This year'))</h5>
            <div id="earning-chart"> </div>
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
                    name: '@lang('Wihtdrawals')',
                    type: 'area',
                    data: @json($withdrawalsChart['values'])
                }],
                fill: {
                    opacity: [0.85, 1],
                },
                labels: @json($withdrawalsChart['labels']),
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
                    name: '@lang('Earnings')',
                    type: 'area',
                    data: @json($earningsChart['values'])
                }],
                fill: {
                    opacity: [0.85, 1],
                },
                labels: @json($earningsChart['labels']),
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
                document.querySelector("#earning-chart"),
                options
            );
            chart.render();
        })();

    </script>
@endpush

